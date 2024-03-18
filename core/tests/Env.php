<?php

namespace OpenSwoole\Core\Tests;

class Env
{
    const ENV_PREFIX = 'PHP_';

    public static function loadFile(string $filePath):void
    {
        if (!file_exists($filePath)) throw new \Exception('Environment file' . $filePath . 'not exist');

        $env = parse_ini_file($filePath, true);
        foreach ($env as $key => $val) {
            $prefix = static::ENV_PREFIX . strtoupper($key);
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    $item = $prefix . '_' . strtoupper($k);
                    putenv("$item=$v");
                }
            } else {
                putenv("$prefix=$val");
            }
        }
    }

    public static function get(string $name, $default = null)
    {
        $result = getenv(static::ENV_PREFIX . strtoupper(str_replace('.', '_', $name)));

        if (false !== $result) {
            if ('false' === $result) {
                $result = false;
            } elseif ('true' === $result) {
                $result = true;
            }
            return $result;
        }
        return $default;
    }
}