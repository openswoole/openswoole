<?php

use OpenSwoole\Coroutine\Client;
use OpenSwoole\Constant;

co::run(function()
{
    $client = new Client(Constant::SOCK_TCP);

    // Connect to the remote server, handle any errors as well...
    if(!$client->connect('127.0.0.1', 9501, 0.5))
    {
        echo "Connection Failed. Error: {$client->errCode}\n";
    }

    // Send data to the connected server
    $client->send("Hello World! - From OpenSwoole.\n");

    while(true)
    {
        // Keep reading data in using this loop
        $data = $client->recv();

        // Check if we have any data or not
        if(strlen($data) > 0)
        {
            echo $data . "\n";
            $client->send(time() . PHP_EOL);
        }
        else
        {
            // An empty string means the connection has been closed
            if($data === '')
            {
                // We must close the connection to use the client again
                $client->close();
                break;
            }
            else
            {
                // False means there was an error we need to check
                if($data === false)
                {
                    // You should use $client->errCode to handle errors yourself

                    // A timeout error will not close the connection.
                    if($client->errCode !== SOCKET_ETIMEDOUT)
                    {
                        // Not a timeout, close the connection due to an error
                        $client->close();
                        break;
                    }
                }
                else
                {
                    // Unknown error, close and break out of the loop
                    $client->close();
                    break;
                }
            }
        }

        // Wait 1 second before reading data again on our loop
        co::sleep(1);
    }
});
