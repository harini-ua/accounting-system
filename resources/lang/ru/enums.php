<?php

return [
    \App\Enums\Month::class => [
        \App\Enums\Month::January => 'Январь',
        \App\Enums\Month::February => 'Февраль',
        \App\Enums\Month::March => 'Март',
        \App\Enums\Month::April => 'Апрель',
        \App\Enums\Month::May => 'Май',
        \App\Enums\Month::June => 'Июнь',
        \App\Enums\Month::July => 'Июль',
        \App\Enums\Month::August => 'Август',
        \App\Enums\Month::September => 'Сентябрь',
        \App\Enums\Month::October => 'Октябрь',
        \App\Enums\Month::November => 'Ноябрь',
        \App\Enums\Month::December => 'Декабрь',
    ],

    \App\Enums\PersonContractType::class => [
        \App\Enums\PersonContractType::Individual2 => 'II группа',
        \App\Enums\PersonContractType::Individual3 => 'III группа',
        \App\Enums\PersonContractType::Contract => 'Договор',
        \App\Enums\PersonContractType::Employee => 'Наемный',
    ],

    \App\Enums\SalaryType::class => [
        \App\Enums\SalaryType::Fixed40 => '40 часов в неделю',
        \App\Enums\SalaryType::Fixed30 => '30 часов в неделю',
        \App\Enums\SalaryType::Fixed20 => '20 часов в неделю',
        \App\Enums\SalaryType::Hourly => 'Почасовая',
    ],
];
