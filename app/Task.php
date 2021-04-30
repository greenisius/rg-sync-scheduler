<?php


namespace RG;


class Task
{
    public $url;
    public $login;
    public $password;
    public $params;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}