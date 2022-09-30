<?php
function dump($var)
{
    return highlight_string("<?php\n\$array = ".var_export($var, true).";", true);
}
$key_dir = dirname(dirname(__DIR__)) . '/tests/ssl';
//$http = new OpenSwoole\Http\Server("0.0.0.0", 9501, \OpenSwoole\Server::SIMPLE_MODE);
$http = new OpenSwoole\Http\Server("0.0.0.0", 9501);

//https
//$http = new OpenSwoole\Http\Server("0.0.0.0", 9501, \OpenSwoole\Server::SIMPLE_MODE, \OpenSwoole\Constant::SOCK_TCP | \OpenSwoole\Constant::SSL);

$http->set([
    'worker_num' => 1,
]);

$http->listen('127.0.0.1', 9502, \OpenSwoole\Constant::SOCK_TCP);

function chunk(OpenSwoole\Http\Request $request, \OpenSwoole\Http\Response $response)
{
    $response->write("<h1>hello world1</h1>");
    //sleep(1);
    $response->write("<h1>hello world2</h1>");
    //sleep(1);
    $response->end();
}

function no_chunk(OpenSwoole\Http\Request $request, \OpenSwoole\Http\Response $response)
{
    if (substr($request->server['request_uri'], -8, 8) == 'test.jpg') {
        $response->header('Content-Type', 'image/jpeg');
        $response->sendfile(dirname(__DIR__) . '/test.jpg');
        return;
    } elseif ($request->server['request_uri'] == '/test.txt') {
        $last_modified_time = filemtime(__DIR__ . '/test.txt');
        $etag = md5_file(__DIR__ . '/test.txt');
        // always send headers
        $response->header("Last-Modified", gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
        $response->header("Etag", $etag);
        if (strtotime($request->header['if-modified-since']) == $last_modified_time or trim($request->header['if-none-match']) == $etag) {
            $response->status(304);
            $response->end();
        } else {
            $response->sendfile(__DIR__ . '/test.txt');
        }
        return;
    } else if ($request->server['request_uri'] == '/favicon.ico') {
        $response->status(404);
        $response->end();
        return;
    } else if ($request->server['request_uri'] == '/big_response') {
        var_dump($response->end(str_repeat('A', 16 * 1024 * 1024)));
        return;
    } else if ($request->server['request_uri'] == '/code') {
        $response->sendfile(__FILE__);
        return;
    } elseif ($request->server['request_uri'] == '/save') {
        file_put_contents(__DIR__ . '/httpdata', $request->getData());
        $response->end('hello');
        return;
    } else {
        $output = '';
        $output .= "<h2>HEADER:</h2>" . dump($request->header);
        $output .= "<h2>SERVER:</h2>" . dump($request->server);
        if (!empty($request->files)) {
            $output .= "<h2>FILE:</h2>" . dump($request->files);
        }
        if (!empty($request->cookie)) {
            $output .= "<h2>COOKIES:</h2>" . dump($request->cookie);
        }
        if (!empty($request->get)) {
            $output .= "<h2>GET:</h2>" . dump($request->get);
        }
        if (!empty($request->post)) {
            $output .= "<h2>POST:</h2>" . dump($request->post);
        }
        var_dump($request->post);

        $response->end("<h1>Hello Swoole.</h1>" . $output);
        return;
    }

    $file = realpath(__DIR__ . '/../' . $request->server['request_uri']);
    if (is_file($file))
    {
        echo "http get file=$file\n";
        if (substr($file, -4) == '.php')
        {
            $response->gzip();
        }
        else
        {
            $response->header('Content-Type', 'image/jpeg');
        }
        $content = file_get_contents($file);
        echo "response size = " . strlen($content) . "\n";

        $response->end($content);
    }
    else
    {
        $response->end("<h1>Hello Open Swoole.</h1>");
    }
}

$http->on('request', function ($req, $resp) {
    $uri = $req->server['request_uri'];
    if ($uri == '/favicon.ico') {
        $resp->status(404);
        $resp->end();
    }
    elseif ($uri == '/chunk') {
        chunk($req, $resp);
    } else {
        no_chunk($req, $resp);
    }
});

$http->on('finish', function ()
{
    echo "task finish";
});

$http->on('task', function ()
{
    echo "async task\n";
});

$http->on('workerStart', function ($serv, $id)
{
    var_dump($serv);
});

$http->start();
