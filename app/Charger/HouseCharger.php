<?php


namespace RG\Charger;


use RG\Invoker;
use RG\Worker;
use RG\QueryTemplate;
use RG\Task;
use RG\Resource;


class HouseCharger implements ChargerInterface
{
    private $invoker;

    private $worker;

    public function __construct()
    {
        $this->invoker = new Invoker();
        $this->worker = new Worker();
    }

    public function charge(Resource $resource)
    {
        $task = new Task([
            'url' => $resource->url,
            'login' => $resource->login,
            'password' => $resource->password,
            'params' => QueryTemplate::json('house_ids'),
        ]);

        $housesData = $this->invoker->invoke($task);
        $houses = json_decode($housesData, true)['house_ids'];

        foreach ($houses as $house) {
            $this->worker->add(
                new Task([
                    'url' => $resource->url,
                    'login' => $resource->login,
                    'password' => $resource->password,
                    'params' => QueryTemplate::json($resource->service, $house),
                ])
            );
        }
    }
}