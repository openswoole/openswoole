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
use OpenSwoole\GRPC\MessageInterface;
use OpenSwoole\GRPC\RequestHandlerInterface;
use OpenSwoole\GRPC\Response;
use OpenSwoole\GRPC\Status;
use OpenSwoole\Util;

class ServiceHandler implements MiddlewareInterface
{
    public function process(MessageInterface $request, RequestHandlerInterface $handler): MessageInterface
    {
        $result = null;
        try {
            $service = $request->getService();
            $method  = $request->getMethod();
            $context = $request->getContext();
            if (!isset($context->getValue('SERVICES')[$service])) {
                throw NotFoundException::create("{$service}::{$method} not found");
            }
            $output = $context->getValue('SERVICES')[$service]->handle($request);

            $context = $context->withValue(Constant::GRPC_STATUS, Status::OK);
        } catch (GRPCException $e) {
            Util::log(\OpenSwoole\Constant::LOG_ERROR, $e->getMessage() . ', error code: ' . $e->getCode() . "\n" . $e->getTraceAsString());
            $output          = '';
            $context         = $context->withValue(Constant::GRPC_STATUS, $e->getCode());
            $context         = $context->withValue(Constant::GRPC_MESSAGE, $e->getMessage());
        } catch (\OpenSwoole\Exception $e) {
            Util::log(\OpenSwoole\Constant::LOG_WARNING, $e->getMessage() . ', error code: ' . $e->getCode() . "\n" . $e->getTraceAsString());
            $output          = '';
            $context         = $context->withValue(Constant::GRPC_STATUS, $e->getCode());
            $context         = $context->withValue(Constant::GRPC_MESSAGE, $e->getMessage());
        } catch (\Throwable $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }

        return new Response($context, $output);
    }
}
