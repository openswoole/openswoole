<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

final class Request implements MessageInterface
{
    private Context $context;

    private string $payload;

    private string $service;

    private string $method;

    public function __construct(Context $context, string $service, string $method, string $payload)
    {
        $this->service = $service;
        $this->method  = $method;
        $this->context = $context;
        $this->payload = $payload;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function withContext(Context $context)
    {
        $this->context = $context;
        return $this;
    }
}
