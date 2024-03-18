<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class Response extends Message implements ResponseInterface
{
    public const CHUNK_SIZE = 100 * 1024 * 1024; // 100K

    private $statusCode;

    private $reasonPhrase;

    private static $statusPhrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        444 => 'Connection Closed Without Response',
        451 => 'Unavailable For Legal Reasons',

        499 => 'Client Closed Request',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
    ];

    public function __construct($body, int $statusCode = 200, string $reasonPhrase = '', array $headers = [], string $protocolVersion = '1.1')
    {
        $this->body = is_string($body) ? Stream::streamFor($body) : $body;
        $this->setStatusCode($statusCode);
        $this->setReasonPhrase($reasonPhrase);
        $this->setHeaders($headers);
        $this->protocolVersion = $protocolVersion;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatus($code, $reasonPhrase = ''): self
    {
        if (!is_int($code) && !is_string($code) || !array_key_exists($code, static::$statusPhrases)) {
            throw new InvalidArgumentException('Error HTTP status code.');
        }
        $response = clone $this;
        $response->setStatusCode($code);
        $response->setReasonPhrase($reasonPhrase);

        return $response;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    public static function emit(\OpenSwoole\HTTP\Response $response, $psrResponse)
    {
        $response->status($psrResponse->getStatusCode());
        foreach ($psrResponse->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                $response->header($name, $value);
            }
        }

        $body = $psrResponse->getBody();
        $body->rewind();
        if ($body->getSize() > static::CHUNK_SIZE) {
            while (!$body->eof()) {
                $response->write($body->read(static::CHUNK_SIZE));
            }
            $response->end();
        } else {
            $response->end($body->getContents());
        }
    }

    private function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    private function setReasonPhrase(string $reasonPhrase): void
    {
        if ($reasonPhrase === '' && array_key_exists($this->statusCode, static::$statusPhrases)) {
            $reasonPhrase = static::$statusPhrases[$this->statusCode];
        }

        $this->reasonPhrase = $reasonPhrase;
    }
}
