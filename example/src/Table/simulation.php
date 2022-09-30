<?php
$table = new OpenSwoole\Table(1024);
$table->column('name', OpenSwoole\Table::TYPE_INT, 4);
$table->column('id', OpenSwoole\Table::TYPE_INT, 4);       //1,2,4,8
$table->column('num', OpenSwoole\Table::TYPE_INT, 4);
$table->create();

while (true) {
    $i = rand(1, 1000);
    $if = rand(0,1);
    if ($if) {
        $table->set($i, ['id' => $i, 'name' => $i, 'num' => $i]);
    } else {
        $table->del($i);
    }
    var_dump('count ' . $table->count());
}
