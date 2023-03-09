<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC;

interface ResponseInterface extends MessageInterface
{
    public function getContext(): Context;

    /**
     * @return void
     * @throws \OpenSwoole\Exception
     */
    public function send(): void;
}
