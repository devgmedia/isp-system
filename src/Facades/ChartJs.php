<?php

namespace Gmedia\IspSystem\Facades;

class ChartJs
{
    public static function coloringDatasets($datasets = [])
    {
        $colors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 159, 64)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
        ];

        $index = 0;
        $coloredDatasets = collect($datasets)->map(function ($dataset) use($colors, &$index) {
            $dataset['borderColor'] = $colors[$index];
            $index++;

            return $dataset;
        })->all();

        return $coloredDatasets;
    }
}
