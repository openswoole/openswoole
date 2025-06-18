<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\GRPC\Middleware;

use OpenSwoole\GRPC\Constant;
use OpenSwoole\GRPC\Exception\GRPCException;
use OpenSwoole\GRPC\Exception\InvokeException;
use OpenSwoole\GRPC\Exception\NotFoundException;
use OpenSwoole\GRPC\MessageInterface;
use OpenSwoole\GRPC\RequestHandlerInterface;
use OpenSwoole\GRPC\Response;
use OpenSwoole\GRPC\Status;
use OpenSwoole\GRPC\StreamResponse;
use OpenSwoole\Util;
use Throwable;

class ServiceHandler implements MiddlewareInterface
{
    public function process(MessageInterface $request, RequestHandlerInterface $handler): MessageInterface
    {
        try {
            $service = $request->getService();
            $method  = $request->getMethod();
            $context = $request->getContext();
            if (!isset($context->getValue('SERVICES')[$service])) {
                throw NotFoundException::create("{$service}::{$method} not found");
            }

            $output  = $context->getValue('SERVICES')[$service]->handle($request);
            $context = $context->withValue(Constant::GRPC_STATUS, Status::OK);

            return is_iterable($output) ? new StreamResponse($context, $output) : new Response($context, $output);
        } catch (GRPCException $e) {
            Util::log(\OpenSwoole\Constant::LOG_ERROR, $e->getMessage() . ', error code: ' . $e->getCode() . "\n" . $e->getTraceAsString());
            $context = $context->withValue(Constant::GRPC_STATUS, $e->getCode());
            $context = $context->withValue(Constant::GRPC_MESSAGE, $e->getMessage());

            return new Response($context);
        } catch (\OpenSwoole\Exception $e) {
            Util::log(\OpenSwoole\Constant::LOG_WARNING, $e->getMessage() . ', error code: ' . $e->getCode() . "\n" . $e->getTraceAsString());
            $context = $context->withValue(Constant::GRPC_STATUS, $e->getCode());
            $context = $context->withValue(Constant::GRPC_MESSAGE, $e->getMessage());

            return new Response($context);
        } catch (Throwable $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }
    }
}
