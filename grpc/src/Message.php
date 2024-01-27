<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\GRPC;

final class Message implements MessageInterface
{
    private Context $context;

    private $message;

    public function __construct(Context $context, $message)
    {
        $this->context = $context;
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getContext()
    {
        return $this->context;
    }
}
