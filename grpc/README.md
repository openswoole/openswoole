# OpenSwoole GRPC for PHP

OpenSwoole GRPC is an open-source high-performance GRPC solution for PHP including server side and client side implementation.

[GRPC](https://grpc.io/) is a high performance, open source universal RPC framework. OpenSwoole GRPC is a high performance integration solution for building cloud-native multiple language microservices architecture.

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

## License

OpenSwoole GRPC is open-sourced software licensed under the [Apache 2.0 license](https://github.com/openswoole/grpc/blob/main/LICENSE).
