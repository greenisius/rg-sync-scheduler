<?php


namespace RG;


use GuzzleHttp\Client;
use RG\Log;

class Invoker
{
    private $log;

    private $client;

    public function __construct()
    {
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
            $this->log->fail($task);
        }
    }

    private function checkError($content)
    {
        if ($error = json_decode($content, true)['error']) {
            throw new \Exception($error);
        }
    }
}