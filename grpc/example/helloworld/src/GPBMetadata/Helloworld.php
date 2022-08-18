<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
# source: helloworld.proto

namespace GPBMetadata;

class Helloworld
{
    public static $is_initialized = false;

    public static function initOnce()
    {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
            return;
        }
        $pool->internalAddGeneratedFile(hex2bin(
            '0aff010a1068656c6c6f776f726c642e70726f746f120a68656c6c6f776f' .
            '726c64221c0a0c48656c6c6f52657175657374120c0a046e616d65180120' .
            '012809221d0a0a48656c6c6f5265706c79120f0a076d6573736167651801' .
            '2001280932490a0747726565746572123e0a0853617948656c6c6f12182e' .
            '68656c6c6f776f726c642e48656c6c6f526571756573741a162e68656c6c' .
            '6f776f726c642e48656c6c6f5265706c792200324f0a0653747265616d12' .
            '450a0d4665746368526573706f6e736512182e68656c6c6f776f726c642e' .
            '48656c6c6f526571756573741a162e68656c6c6f776f726c642e48656c6c' .
            '6f5265706c7922003001620670726f746f33'
        ));

        static::$is_initialized = true;
    }
}
