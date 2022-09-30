<?php
$client = new OpenSwoole\Client(\OpenSwoole\Constant::SOCK_UNIX_DGRAM, \OpenSwoole\Constant::SOCK_SYNC);
if (!$client->connect(__DIR__ . '/svr.sock', 0, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}

$client->send("hello world\n");
echo $client->recv();
$client->close();

sleep(1);
