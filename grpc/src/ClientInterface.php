<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

interface ClientInterface
{
    public function set(array $settings): self;

    public function connect(): self;

    public function stats(): array;

    public function close();

    public function send($method, $message, $type = 'proto');

    public function recv($streamId, $timeout = -1);

    public function push($streamId, $message, $type = 'proto', $end = false);
}
