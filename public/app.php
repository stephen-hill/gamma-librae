<?php

use Michelf\Markdown;

$root = dirname(__DIR__);

$config = require($root . '/config/config.php');

require_once($root . '/vendor/autoload.php');

$entry = (object)[
    'path' => $_SERVER['SCRIPT_NAME'],
    'query' => $_GET,
    'post' => $_POST,
    'user-agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'auth' => $_SERVER['HTTP_AUTHORIZATION'] ?? '',
];

$json = json_encode($entry, JSON_PRETTY_PRINT);

$path = $root . '/logs/' . time() . '_' . date('Y-m-d_H-m') . '.json';

file_put_contents($path, $json);

$request = (object)[
    'get' => (object)$_GET,
    'post' => (object)$_POST,
    'server' => (object)$_SERVER,
];

$url = (object)parse_url($_SERVER['REQUEST_URI']);

$path = $url->path;

$map = [
    '/rest/ping.view' => 'Ping',
    '/rest/getAlbumList2.view' => 'GetAlbumList2',
    '/rest/getLicense.view' => 'GetLicense',
];

if (isset($map[$path]) === true)
{
    $class = 'GammaLibrae\Actions\\' . $map[$path];
    $action = new $class();
    return $action->run($request);
}

$markdown = file_get_contents($root . '/README.md');
$html = Markdown::defaultTransform($markdown);
echo $html;
