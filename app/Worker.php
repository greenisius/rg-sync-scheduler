<?php


namespace RG;


use Pheanstalk\Pheanstalk;
use RG\Invoker;

class Worker
{
    private $job;
    private $invoker;
    private $worker;

    public function __construct()
    {
        $this->invoker = new Invoker();

        $this->worker = Pheanstalk::create($_ENV['QUERY_IP'], $_ENV['QUERY_PORT']);

        $this->worker->watch('sync-scheduler');
    }

    public function add(Task $task)
    {
        $this->worker->useTube('sync-scheduler')->put(serialize($task));
    }

    private function task(): Task
    {
        $this->job = $this->worker->reserve();

        return unserialize($this->job->getData());
    }

    public function work()
    {
        $task = $this->task();

        $this->invoker->invoke($task);

        $this->worker->delete($this->job);
    }
}