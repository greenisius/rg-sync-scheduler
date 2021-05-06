<?php


namespace RG;


use RG\Task;


class Log
{
    public function success(Task $task)
    {
        $time = date('d.m.y H:i:s');

        file_put_contents($_ENV['LOG'], "$time: для $task->url синхронизация сервиса c параметрами $task->params\n", FILE_APPEND);
    }

    public function fail(Task $task)
    {
        $time = date('d.m.y H:i:s');

        file_put_contents($_ENV['LOG'], "$time: <ОШИБКА> для $task->url c параметрами $task->params\n", FILE_APPEND);
    }
}