<?php


namespace App\Tools;


class FormatTools
{
    const PRECISION = 2;
    public static function formatPrice($value){
        return round($value, self::PRECISION).'€';
    }
    public static function formatPercentage($value){

        return round($value, self::PRECISION).'%';
    }

}