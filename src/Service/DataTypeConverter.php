<?php

namespace App\Service;

class DataTypeConverter
{
    public function changeToStr(int $int): string
    {
        if (1 === $int) {
            return 'on';
        }

        return 'off';
    }

    public function changeToInt(string $str): int
    {
        if ('yes' === $str) {
            return 1;
        }

        return 0;
    }
}
