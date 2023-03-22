<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC;

final class Response implements ResponseInterface
{
    use ResponseTrait;

    private Context $context;

    private ?string $contentType;

    private string $payload;

    public function __construct(Context $context, ?\Google\Protobuf\Internal\Message $payload = null)
    {
        $this->context     = $context;
        $this->contentType = $context->getValue('content-type');
        $this->payload     = $payload === null ? '' : $this->preparePayload($payload, $this->contentType);
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function send(): void
    {
        /** @var \OpenSwoole\Http\Response $response */
        $rawResponse = $this->context->getValue(\OpenSwoole\Http\Response::class);

        $this->sendHeaders($rawResponse, $this->contentType);
        $this->sendPayload($rawResponse, $this->payload);

        $this->sendTrailers($rawResponse, $this->context);
        $rawResponse->end();
    }
}
