# OpenSwoole GRPC for PHP

OpenSwoole GRPC is an open-source high-performance GRPC solution for PHP including server side and client side implementation.

[GRPC](https://grpc.io/) is a high performance, open source universal RPC framework. OpenSwoole GRPC is a high performance integration solution for building cloud-native multiple language microservices architecture.

## Install

You can add this package to your project using [Composer](https://getcomposer.org):

```bash
composer require openswoole/grpc
```

## Features

* Native GRPC implementation compliant
* PHP/PHP-FPM GRPC client compliant
* [OpenSwoole GRPC Compiler](https://github.com/openswoole/protoc-gen-openswoole-grpc) provided
* GRPC unary mode support
* GRPC server side stream mode
* GRPC server side interceptors
* GRPC client side connection pooling and multiplexing

## Example

You can find example helloworld project at [/example](https://github.com/openswoole/grpc/tree/main/example).

## Next steps:

1. Create `.proto` for your service
2. Generate PHP stub codes with Open Swoole GRPC Compiler
3. Implement your own service
4. Integrate with GRPC service with GRPC client

## Documentation

Documentation for Open Swoole can be found on the [Open Swoole website](https://openswoole.com/docs).
