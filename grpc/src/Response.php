<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

final class Response implements MessageInterface
{
    private Context $context;

    private string $payload;

    public function __construct(Context $context, string $payload)
    {
        $this->context = $context;
        $this->payload = $payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getContext()
    {
        return $this->context;
    }
}
