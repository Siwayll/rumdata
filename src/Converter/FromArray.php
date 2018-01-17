<?php

namespace Siwayll\RumData\Converter;

use Siwayll\RumData\RumData;

class FromArray
{
    static public function toRumData(array $array): RumData
    {
        $data = new RumData();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::toRumData($value);
            }
            $data->set($value, $key);
        }

        return $data;
    }
}

