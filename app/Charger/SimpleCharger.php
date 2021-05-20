<?php


namespace RG\Charger;


use RG\Invoker;
use RG\QueryTemplate;
use RG\Task;
use RG\Resource;


class SimpleCharger implements ChargerInterface
{
    private $invoker;

    public function __construct()
    {
        $this->invoker = new Invoker();
    }

    public function charge(Resource $resource)
    {
        $task = new Task([
            'url' => $resource->url,
            'login' => $resource->login,
            'password' => $resource->password,
            'params' => QueryTemplate::json($resource->service),
        ]);

        $this->invoker->invoke($task);
    }
}