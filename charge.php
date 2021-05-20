<?php


require_once __DIR__ . '/vendor/autoload.php';


use RG\Resource;
use RG\ResourceRepository;
use RG\Charger\Context;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$resources = new ResourceRepository();

$context = new Context();

foreach ($resources->list($argv) as $resource) {
    $context->execute($resource);
}