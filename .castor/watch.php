<?php

use Castor\Attribute\Task;

use function Castor\watch;

#[Task(description: 'A simple task that watch on filesystem changes')]
function fs_change()
{
    watch(dirname(__DIR__) . '/...', function ($name, $type) {
        echo "File {$name} has been {$type}\n";
    });
}
