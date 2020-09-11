<?php

return [
    'trial_period' => '2 months',
    'bonuses' => [
        'recruit' => [
            /*
            | Example:
            |     1/2 - 50% after start, 50% after trial
            |     1/3 - 33% after start, 66% after trial
            |     1/4 - 25% after start, 75% after trial
            |     2/3 - 66% after start, 33% after trial
            |     3/4 - 75% after start, 25% after trial
            */
            'fraction' => '2/3'
        ]
    ]
];
