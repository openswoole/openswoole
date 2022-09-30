<?php
$table = new OpenSwoole\Table(1024);
$table->column('id', OpenSwoole\Table::TYPE_INT);
$table->column('name', OpenSwoole\Table::TYPE_STRING, 64);
$table->column('num', OpenSwoole\Table::TYPE_FLOAT);
$table->create();

$table->set('a', array('id' => 1, 'name' => 'swoole-co-uk', 'num' => 3.1415));
$table->set('b', array('id' => 2, 'name' => "swoole-uk", 'num' => 3.1415));
$table->set('hello@swoole.co.uk', array('id' => 3, 'name' => 'swoole', 'num' => 3.1415));

var_dump($table->get('a'));
var_dump($table->get('b', 'name'));
