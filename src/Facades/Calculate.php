<?php

namespace Gmedia\IspSystem\Facades;

class Calculate
{
    public static function process($value)
    {
        if ($value < 0) {
            $result = 'Minus '.trim(static::denominator($value));
        } else {
            $result = trim(static::denominator($value));
        }

        return $result;
    }

    public static function denominator($value)
    {
        $value = abs($value);
        $text = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $temp = '';

        if ($value < 12) {
            $temp = ' '.$text[$value];
        } elseif ($value < 20) {
            $temp = static::denominator($value - 10).' Belas';
        } elseif ($value < 100) {
            $temp = static::denominator($value / 10).' Puluh'.static::denominator($value % 10);
        } elseif ($value < 200) {
            $temp = ' Seratus'.static::denominator($value - 100);
        } elseif ($value < 1000) {
            $temp = static::denominator($value / 100).' Ratus'.static::denominator($value % 100);
        } elseif ($value < 2000) {
            $temp = ' Seribu'.static::denominator($value - 1000);
        } elseif ($value < 1000000) {
            $temp = static::denominator($value / 1000).' Ribu'.static::denominator($value % 1000);
        } elseif ($value < 1000000000) {
            $temp = static::denominator($value / 1000000).' Juta'.static::denominator($value % 1000000);
        } elseif ($value < 1000000000000) {
            $temp = static::denominator($value / 1000000000).' Milyar'.static::denominator(fmod($value, 1000000000));
        } elseif ($value < 1000000000000000) {
            $temp = static::denominator($value / 1000000000000).' Trilyun'.static::denominator(fmod($value, 1000000000000));
        }

        return $temp;
    }
}
