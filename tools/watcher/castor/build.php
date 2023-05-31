<?php

use Castor\Attribute\AsTask;
use Castor\Context;

use function Castor\parallel;
use function Castor\run;

#[AsTask(description: 'Build watcher for Linux system', namespace: 'watcher')]
function linux(Context $c)
{
    $c = $c->withPath(__DIR__ . '/..');
    run('go build -o bin/watcher-linux -ldflags="-s -w" main.go', environment: ['GOOS' => 'linux', 'CGO_ENABLED' => '0'], context: $c);
    run('upx --brute bin/watcher-linux', context: $c);
}

#[AsTask(description: 'Build watcher for MacOS system', namespace: 'watcher')]
function darwin(Context $c)
{
    $c = $c->withPath(__DIR__ . '/..');
    run('go build -o bin/watcher-darwin -ldflags="-s -w" main.go', environment: ['GOOS' => 'darwin', 'CGO_ENABLED' => '0'], context: $c);
}

#[AsTask(description: 'Build watcher for Windows system', namespace: 'watcher')]
function windows(Context $c)
{
    $c = $c->withPath(__DIR__ . '/..');
    run('go build -o bin/watcher-windows.exe -ldflags="-s -w" main.go', environment: ['GOOS' => 'windows', 'CGO_ENABLED' => '0'], context: $c);
}

#[AsTask(description: 'Build watcher for all systems', namespace: 'watcher')]
function build(Context $c)
{
    parallel(fn () => linux($c), fn () => darwin($c), fn () => windows($c));
}
