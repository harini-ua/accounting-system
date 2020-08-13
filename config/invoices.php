<?php

return [
    'date' => [
        'format' => 'Y-m-d',
    ],
    'serial_number' => [
        'series' => 'INV',
        'sequence_padding' => 5,
        'delimiter' => '-',
        // Example: INV-00001
        'format' => '{SERIES}{DELIMITER}{SEQUENCE}',
    ],
    'paper' => [
        'size' => 'a4',
        'orientation' => 'portrait',
    ],
    'address' => [
        'format' => '{ADDRESS}, {CITY}, {STATE} {COUNTRY} {POST_CODE}'
    ],
    'logo' => [
        'src' => '/images/dreamdev-solutions.png',
        'height' => 33,
        'width' => 160,
    ]
];
