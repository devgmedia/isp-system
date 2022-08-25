<?php

namespace Gmedia\IspSystem\Facades;

class MonthYear
{
    public static function getYearRange($start_date, $end_date)
    {
        $year = [];

        $c = $start_date;

        while ($c < $end_date) {
            array_push($year, $c);
            $c++;
        }

        return $year;
    }

    public static function getMonthLang($lang = 'en')
    {
        switch ($lang) {
            case 'en':
                return [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December',
                ];
                break;

            case 'id':
                return [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Augustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember',
                ];
                break;
        }

        return false;
    }

    public static function getMonthLangWithId($lang = 'en')
    {
        switch ($lang) {
            case 'en':
                return [
                    ['id' => 1, 'text' => 'January'],
                    ['id' => 2, 'text' => 'February'],
                    ['id' => 3, 'text' => 'March'],
                    ['id' => 4, 'text' => 'April'],
                    ['id' => 5, 'text' => 'May'],
                    ['id' => 6, 'text' => 'June'],
                    ['id' => 7, 'text' => 'July'],
                    ['id' => 8, 'text' => 'August'],
                    ['id' => 9, 'text' => 'September'],
                    ['id' => 10, 'text' => 'October'],
                    ['id' => 11, 'text' => 'November'],
                    ['id' => 12, 'text' => 'December'],
                ];
                break;

            case 'id':
                return [
                    ['id' => 1, 'text' => 'Januari'],
                    ['id' => 2, 'text' => 'Februari'],
                    ['id' => 3, 'text' => 'Maret'],
                    ['id' => 4, 'text' => 'April'],
                    ['id' => 5, 'text' => 'Mei'],
                    ['id' => 6, 'text' => 'Juni'],
                    ['id' => 7, 'text' => 'Juli'],
                    ['id' => 8, 'text' => 'Augustus'],
                    ['id' => 9, 'text' => 'September'],
                    ['id' => 10, 'text' => 'Oktober'],
                    ['id' => 11, 'text' => 'November'],
                    ['id' => 12, 'text' => 'Desember'],
                ];
                break;
        }

        return false;
    }

    public static function numberToMonth($n, $lang = 'en')
    {
        $month = static::getMonthLang($lang);

        return $month[$n - 1];
    }

    public static function getMonthAsNumber($start_date = null, $end_date = null)
    {
        // period support, belum ditambahkan
        return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    }
}
