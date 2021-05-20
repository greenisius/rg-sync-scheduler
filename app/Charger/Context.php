<?php


namespace RG\Charger;


use RG\Resource;


class Context
{
    public function execute(Resource $resource)
    {
        switch ($resource->service) {
            case 'sync_meters':
            case 'sync_indications':
                $context = new HouseCharger();
                break;
            case 'remind_appointments':
                $context = new SimpleCharger();
                break;
            default:
                return;
        }

        return $context->charge($resource);
    }
}