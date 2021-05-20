<?php


namespace RG\Charger;


use RG\Resource;


interface ChargerInterface
{
    public function charge(Resource $resource);
}