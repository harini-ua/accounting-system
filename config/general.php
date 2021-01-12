<?php

return [
    'date' => [
        'format' => 'd/m/Y',
    ],
    'currency' => [
        'delimiter' => ' ',
        'format' => '{SYMBOL}{DELIMITER}{VALUE}',
    ],
    'number' => [
        'format' => [
            'decimals' => 2,
            'dec_point' => ',',
            'thousands_sep' => ' ',
        ]
    ],
    'ui' => [
        'datatable' => [
            'filter' => [
                'show' => true,
            ]
        ]
    ]
];
