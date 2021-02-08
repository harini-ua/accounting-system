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
        ],
        'navigation' => [
            'lock' => false
        ]
    ],
    'hour_day' => 8,
    'payslip' => [
        'per_page' => [
            'available' => [
                4 => [2, 2],
                6 => [2, 3],
                9 => [3, 3],
                12 => [3, 4],
                16 => [4, 4],
            ],
            'default' => 6,
        ],
        'language' => [
            'available' => [ 'en', 'ru' ],
            'default' => 'ru',
        ],
        'margins' => '20px 0 0 0',
    ]
];
