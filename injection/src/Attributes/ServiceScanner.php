<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Scanner;

use OpenSwoole\Injection\Metadata\ServiceDefinition;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

class ServiceScanner
{
    private DocBlockServiceParser $docBlockParser;

    public function __construct()
    {
        $this->docBlockParser = new DocBlockServiceParser();
    }

    /**
     * Scan $directory for classes under $namespace annotated with @Service / #[Service].
     *
     * @return ServiceDefinition[]
     */
    public function scan(string $directory, string $namespace): array
    {
        $definitions = [];

        /** @var SplFileInfo $file */
        foreach ($this->phpFiles($directory) as $file) {
            foreach ($this->classNamesFromFile($file->getRealPath(), $namespace) as $fqcn) {
                $definition = $this->inspect($fqcn);
                if ($definition !== null) {
                    $definitions[] = $definition;
                }
            }
        }

        return $definitions;
    }

    private function phpFiles(string $directory): RecursiveIteratorIterator
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );
    }

    /**
     * Extract fully-qualified class names from a PHP file using the tokenizer,
     * without requiring/executing the file.
     *
     * @return string[]
     */
    private function classNamesFromFile(string $path, string $namespacePrefix): array
    {
        if (pathinfo($path, PATHINFO_EXTENSION) !== 'php') {
            return [];
        }

        $source = file_get_contents($path);
        if ($source === false) {
            return [];
        }

        $tokens    = token_get_all($source);
        $namespace = '';
        $classes   = [];
        $count     = count($tokens);

        for ($i = 0; $i < $count; $i++) {
            $token = $tokens[$i];

            // Capture namespace declaration.
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                $namespace = '';
                $i++;
                // Skip whitespace after 'namespace'.
                while ($i < $count && is_array($tokens[$i]) && $tokens[$i][0] === T_WHITESPACE) {
                    $i++;
                }
                // Collect the namespace string (handles T_NAME_QUALIFIED on PHP 8+).
                while ($i < $count) {
                    $t = $tokens[$i];
                    if (is_array($t) && in_array($t[0], [T_STRING, T_NS_SEPARATOR], true)) {
                        $namespace .= $t[1];
                        $i++;
                    } elseif (is_array($t) && defined('T_NAME_QUALIFIED') && $t[0] === T_NAME_QUALIFIED) {
                        $namespace .= $t[1];
                        $i++;
                    } else {
                        break;
                    }
                }
                continue;
            }

            // Capture class declaration — skip anonymous classes.
            if (is_array($token) && $token[0] === T_CLASS) {
                // The next non-whitespace token must be T_STRING (the class name).
                // If it's '{', this is an anonymous class.
                $j = $i + 1;
                while ($j < $count && is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE) {
                    $j++;
                }
                if (!isset($tokens[$j]) || !is_array($tokens[$j]) || $tokens[$j][0] !== T_STRING) {
                    continue;
                }

                $className = $tokens[$j][1];
                $fqcn      = $namespace !== '' ? $namespace . '\\' . $className : $className;

                if (strncmp($fqcn, $namespacePrefix, strlen($namespacePrefix)) === 0) {
                    $classes[] = $fqcn;
                }
            }
        }

        return $classes;
    }

    private function inspect(string $fqcn): ?ServiceDefinition
    {
        if (!class_exists($fqcn)) {
            return null;
        }

        $reflection = new ReflectionClass($fqcn);

        if (!$reflection->isInstantiable()) {
            return null;
        }

        // PHP 8+: read native #[Service] attribute.
        if (PHP_MAJOR_VERSION >= 8) {
            $attrs = $reflection->getAttributes(\OpenSwoole\Injection\Attributes\Service::class);
            if (count($attrs) > 0) {
                $instance = $attrs[0]->newInstance();
                return new ServiceDefinition($fqcn, $fqcn, $instance->lifetime);
            }
        }

        // PHP 7.4+: read /** @Service */ docblock.
        $docblock = $reflection->getDocComment();
        if ($docblock === false) {
            return null;
        }

        return $this->docBlockParser->parse($fqcn, $docblock);
    }
}
