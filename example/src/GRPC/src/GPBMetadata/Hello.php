<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
# source: hello.proto

namespace GPBMetadata;

class Hello
{
    public static $is_initialized = false;

    public static function initOnce()
    {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
            return;
        }
        $pool->internalAddGeneratedFile(
            '
�
hello.protohello"
HelloRequest
name (	"

HelloReply
message (	2D
StreamGreeter3
Hello.hello.HelloRequest.hello.HelloReply" 0bproto3', true);

        static::$is_initialized = true;
    }
}
