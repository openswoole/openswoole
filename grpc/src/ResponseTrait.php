<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC;

use OpenSwoole\GRPC\Exception\InvokeException;
use Throwable;

trait ResponseTrait
{
    private function preparePayload($message, ?string $contentType): string
    {
        try {
            if ($contentType !== 'application/grpc+json') {
                $payload = $message->serializeToString();
            } else {
                $payload = $message->serializeToJsonString();
            }

            return pack('CN', 0, strlen($payload)) . $payload;
        } catch (Throwable $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }
    }

    private function sendHeaders(
        \OpenSwoole\Http\Response $rawResponse,
        ?string $contentType,
        array $headers = []
    ): void {
        $headers = array_merge([
            'content-type' => $contentType,
            'trailer'      => 'grpc-status, grpc-message',
        ], $headers);

        foreach ($headers as $key => $value) {
            $rawResponse->header($key, $value);
        }
    }

    private function sendPayload(\OpenSwoole\Http\Response $rawResponse, string $payload): void
    {
        $ret = $rawResponse->write($payload);

        if (!$ret) {
            throw new \OpenSwoole\Exception('Client side is disconnected');
        }
    }

    private function sendTrailers(
        \OpenSwoole\Http\Response $rawResponse,
        Context $context,
        array $trailers = []
    ): void {
        $trailers = array_merge([
            Constant::GRPC_STATUS  => $context->getValue(Constant::GRPC_STATUS),
            Constant::GRPC_MESSAGE => $context->getValue(Constant::GRPC_MESSAGE),
        ], $trailers);

        foreach ($trailers as $key => $value) {
            $rawResponse->trailer($key, (string) $value);
        }
    }
}
