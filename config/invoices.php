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
        'src' => 'https://dummyimage.com/200x100/aaa/fff.png&text=Seller+Logo',
        'height' => 100,
        'width' => 200,
    ]
];
