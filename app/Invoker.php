<?php


namespace RG;


use GuzzleHttp\Client;
use RG\Log;

class Invoker
{
    private $status;

    private $log;

    private $client;

    public function __construct()
    {
        $this->status = true;

        $this->log = new Log();

        $this->client = new Client();
    }

    public function invoke(Task $task)
    {
        $url = $task->url;

        $query = [
            'auth' => [
                $task->login,
                $task->password
            ],
            'form_params' => json_decode($task->params, true),
            'timeout' => 300.0,
            'connect_timeout' => 300.0,
        ];

        try {
            $response = $this->client->post($url, $query);
            
            $content = $response->getBody()->getContents();

            $this->checkError($content);

            return $content;

        } catch (\Exception $e) {
            $task->error = $e->getMessage();
            $this->log->fail($task);
            $this->status = false;
        }
    }

    private function checkError($content)
    {
        if ($error = json_decode($content, true)['error']) {
            throw new \Exception($error);
        }
    }

    public function isSuccess()
    {
        return $this->status;
    }
}