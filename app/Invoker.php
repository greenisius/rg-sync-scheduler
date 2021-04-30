<?php


namespace RG;


use GuzzleHttp\Client;

class Invoker
{
    public function invoke(Task $task)
    {
        $url = $task->url;

        $query = [
            'auth' => [
                $task->login,
                $task->password
            ],
            'form_params' => json_decode($task->params, true)
        ];

        $client = new Client();

        $response = $client->post($url, $query);

        return $response->getBody()->getContents();
    }
}