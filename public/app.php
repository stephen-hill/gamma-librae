<?php

use GammaLibrae\Actions\GetLicense;
use GammaLibrae\Actions\Ping;

$root = dirname(__DIR__);

require_once($root . '/vendor/autoload.php');

$request = (object)[
    'get' => (object)$_GET,
    'post' => (object)$_POST,
    'server' => (object)$_SERVER,
];

$json = json_encode($request, JSON_PRETTY_PRINT);

$path = $root . '/logs/' . time() . '_' . date('Y-m-d_H-m') . '.json';

file_put_contents($path, $json);

$url = (object)parse_url($_SERVER['REQUEST_URI']);

$path = $url->path;

if ($path === '/rest/ping.view')
{
    $action = new Ping();
    return $action->run($request);
}

if ($path === '/rest/getLicense.view')
{
    $action = new GetLicense();
    return $action->run($request);
}
