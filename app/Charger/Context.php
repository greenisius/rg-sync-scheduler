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
            case 'sync_insurances':
            case 'sync_arrears':
            case 'sync_payments':
                $context = new HouseCharger();
                break;
            default:
                $context = new SimpleCharger();
        }

        return $context->charge($resource);
    }
}