<?php


namespace RG;


class QueryTemplate
{
    public static function json(string $service, $house = null): string
    {
        $result = self::formData($service, $house);

        return json_encode($result);
    }

    public static function formData($service, $house = null): array
    {
        return [
            'service' => [
                [
                    'name' => $service,
                    'attributes' => [
                        'house' => $house
                    ],
                ]
            ]
        ];
    }
}