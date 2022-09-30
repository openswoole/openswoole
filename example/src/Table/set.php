<?php
$table = new OpenSwoole\Table(1024);
$table->column('name', OpenSwoole\Table::TYPE_STRING, 64);
$table->column('id', OpenSwoole\Table::TYPE_INT, 4);       //1,2,4,8
$table->column('num', OpenSwoole\Table::TYPE_FLOAT);
$table->create();

function child1()
{
    global $table;
    $s = microtime(true);
    $table->set('a', array('id' => 1, 'name' => 'swoole-co-uk', 'num' => 3.1415));
    $table->set('b', array('id' => 2, 'name' => "swoole-uk", 'num' => 3.1415));
    $table->set('hello@swoole.co.uk', array('id' => 3, 'name' => 'swoole', 'num' => 3.1415));
    echo "set - 3 use: ".((microtime(true) - $s) * 1000)."ms\n";
}

//master
sleep(1);

child1();
$s = microtime(true);
for($i =0; $i < 1000; $i++)
{
    $arr = $table->get('a');
}

echo "get -1000 use: ".((microtime(true) - $s) * 1000)."ms\n";
$s = microtime(true);
//$table->incr('tianfenghan@qq.com', 'id', 5);
//$table->decr('hello@qq.com', 'num', 1.1);
$ret1 = $table->get('a');
$ret2 = $table->get('b');
$ret3 = $table->get('hello@swoole.co.uk');

echo "get -3 use: ".((microtime(true) - $s) * 1000)."ms\n";
var_dump($ret1, $ret2, $ret3);
echo "id:".$ret1['id']."\n";
echo "name:".$ret1['name']."\n";
echo "num:".$ret1['num']."\n";
