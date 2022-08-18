<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

use OpenSwoole\GRPC\Exception\GRPCException;

class BaseStub
{
    private $client;

    private $deserialize;

    private $streamId;

    public function __construct($client)
    {
        if ($client) {
            $this->client = $client;
        }
    }

    protected function _simpleRequest(
        $method,
        $request,
        $deserialize,
        array $metadata = []
    ) {
        $streamId              = $this->client->send($method, $request);
        [$data, $trailers]     = $this->client->recv($streamId);

        if ($trailers['grpc-status'] !== '0') {
            throw new GRPCException($trailers['grpc-message']);
        }
        return $this->_deserializeResponse($deserialize, $data);
    }

    protected function _deserializeResponse($deserialize, $value)
    {
        if ($value === null) {
            return;
        }

        [$className, $deserializeFunc] = $deserialize;
        $obj                           = new $className();
        $obj->mergeFromString($value);
        return $obj;
    }

    protected function _serverStreamRequest(
        $method,
        $request,
        $deserialize,
        array $metadata = []
    ) {
        $this->deserialize = $deserialize;
        $streamId          = $this->client->send($method, $request);
        [$data,]           = $this->client->recv($streamId);

        $this->streamId    = $streamId;
        return $this->_deserializeResponse($deserialize, $data);
    }

    protected function _getData()
    {
        [$data,]     = $this->client->recv($this->streamId);

        return $this->_deserializeResponse($this->deserialize, $data);
    }
}
