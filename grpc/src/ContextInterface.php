<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

interface ContextInterface
{
    public function withValue(string $key, $value): self;

    public function getValue(string $key);

    public function getValues(): array;
}
