<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Scanner;

use InvalidArgumentException;
use OpenSwoole\Injection\Metadata\ServiceDefinition;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

class ServiceScanner
{
    /** @var ServiceParserInterface[] */
    private array $parsers;

    /**
     * @param ServiceParserInterface[] $parsers Parsers tried in order; first non-null result wins.
     *                                          Defaults to the version-appropriate set.
     */
    public function __construct(array $parsers = [])
    {
        if ($parsers === []) {
            $this->parsers = $this->defaultParsers();
            return;
        }

        foreach ($parsers as $parser) {
            if (!$parser instanceof ServiceParserInterface) {
                $type = is_object($parser) ? get_class($parser) : gettype($parser);

                throw new InvalidArgumentException('Service parser must implement ' . ServiceParserInterface::class . "; got {$type}");
            }
        }

        $this->parsers = array_values($parsers);
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

    /**
     * @return ServiceParserInterface[]
     */
    private function defaultParsers(): array
    {
        if (PHP_MAJOR_VERSION >= 8) {
            return [new AttributeServiceParser(), new DocBlockServiceParser()];
        }

        return [new DocBlockServiceParser()];
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

                if ($this->matchesNamespace($fqcn, $namespacePrefix)) {
                    $classes[] = $fqcn;
                }
            }
        }

        return $classes;
    }

    /**
     * True when $fqcn is exactly $namespacePrefix or is beneath it as a
     * namespace segment. This prevents App\Scan matching App\Scanner\Foo.
     */
    private function matchesNamespace(string $fqcn, string $namespacePrefix): bool
    {
        if ($namespacePrefix === '' || $namespacePrefix === '\\') {
            return true;
        }

        $prefix = rtrim($namespacePrefix, '\\');

        return $fqcn === $prefix
            || strncmp($fqcn, $prefix . '\\', strlen($prefix) + 1) === 0;
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

        foreach ($this->parsers as $parser) {
            $definition = $parser->parse($reflection);
            if ($definition !== null) {
                return $definition;
            }
        }

        return null;
    }
}
