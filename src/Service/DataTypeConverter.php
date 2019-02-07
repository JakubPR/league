<?php

declare(strict_types=1);

namespace App\Service;

class DataTypeConverter
{
    private static $data = [
       0 => 'off',
       1 => 'on',
    ];

    public function changeToStr(int $int): string
    {
        return DataTypeConverter::$data[$int];
    }

    public function changeToInt(string $str): int
    {
        return array_search($str, DataTypeConverter::$data);
    }
}
