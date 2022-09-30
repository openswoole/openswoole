<?php

OpenSwoole\Timer::tick(2000, function ($id) {
	var_dump($id);
});

OpenSwoole\Event::cycle(function () {
	echo "hello [1]\n";
    OpenSwoole\Event::cycle(function () {
	    echo "hello [2]\n";
        OpenSwoole\Event::cycle(null);
    });
});
