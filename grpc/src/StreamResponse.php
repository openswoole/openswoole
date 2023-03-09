<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC;

final class StreamResponse implements ResponseInterface
{
    use ResponseTrait;

    private Context $context;

    private iterable $payload;

    public function __construct(Context $context, iterable $payload)
    {
        $this->context = $context;
        $this->payload = $payload;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    /**
     * @return void
     * @throws \OpenSwoole\Exception
     */
    public function send(): void
    {
        /** @var \OpenSwoole\Http\Response $response */
        $rawResponse = $this->context->getValue(\OpenSwoole\Http\Response::class);
        $contentType = $this->context->getValue('content-type');

        $this->sendHeaders($rawResponse, $contentType);
        foreach ($this->payload as $payload) {
            $this->sendPayload(
                $rawResponse,
                $this->preparePayload($payload, $contentType)
            );
        }

        $this->sendTrailers($rawResponse, $this->context);
        $rawResponse->end();
    }
}
