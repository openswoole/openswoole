# Example project of OpenSwoole GRPC server and clients

## Prerequisites

* PHP and Composer
* Open Swoole
* Open Swoole GRPC
* Open Swoole GRPC Compiler
* google/protobuf or ext-protobuf (Optional)

## Get started

```bash
composer install
# start example GRPC server
php server.php
# run client
php simple_client.php
# run golang client
go run client.go
```

## Examples:

1. `simple_client.php`p: one GRPC call with client
2. `factory_client.php`: use factory to create clients
3. `plain_client.php`: use lower layer protocol
4. `pooling_client.php`: how to use clientpool
5. `server_streaming_client.php`: receive one way data stream from GRPC server
6. `client_streaming_client.php`: send one way data stream to GRPC server

## Next steps:

1. Create `.proto` for your service
2. Generate PHP stub codes with Open Swoole GRPC Compiler
3. Implement your own service
4. Integrate with GRPC client

## License

OpenSwoole GRPC code generator is open-sourced software licensed under the [Apache 2.0 license](https://github.com/openswoole/grpc/blob/main/LICENSE).
