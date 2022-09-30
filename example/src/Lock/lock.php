<?php

$lock = new OpenSwoole\Lock(\OpenSwoole\Constant::MUTEX);
echo "[Master] Create lock\n";
$lock->lock();
if (pcntl_fork() > 0)
{
    sleep(1);
    $lock->unlock();
}
else
{
    echo "[Child] Wait Lock\n";
    $lock->lock();
    echo "[Child] Get Lock\n";
    $lock->unlock();
    exit("[Child] exit\n");
}
echo "[Master]release lock\n";
unset($lock);
sleep(1);
echo "[Master]exit\n";