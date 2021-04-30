<?php


require_once __DIR__ . '/vendor/autoload.php';


use RG\Invoker;
use RG\QueryTemplate;
use RG\Resource;
use RG\ResourceRepository;
use RG\Task;
use RG\Worker;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$resources = new ResourceRepository();

$worker = new Worker();

$invoker = new Invoker();

foreach ($resources->list() as $resource) {
    $task = new Task([
        'url' => $resource->url,
        'login' => $resource->login,
        'password' => $resource->password,
        'params' => QueryTemplate::json('house_ids'),
    ]);

    $housesData = $invoker->invoke($task);
    $houses = json_decode($housesData, true)['house_ids'];

    foreach ($houses as $house) {
        $worker->add(
            new Task([
                'url' => $resource->url,
                'login' => $resource->login,
                'password' => $resource->password,
                'params' => QueryTemplate::json($resource->service, $house),
            ])
        );
    }
}




