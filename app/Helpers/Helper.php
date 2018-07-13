<?php

namespace App\Helpers;

class Helper
{
    public static function revese_date_format($date)
    {
        return implode('-', array_reverse(explode('-', $date)));
    }
}