<?php


namespace RG;


class Resource
{
    public $url;
    public $login;
    public $password;
    public $service;
    public $period;

    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->service = $data['service'];
        $this->period = $data['period'];
    }
}