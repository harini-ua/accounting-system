<?php

return [
    \App\Enums\ContractStatus::class => [
        \App\Enums\ContractStatus::OPENED => 'Opened',
        \App\Enums\ContractStatus::CLOSED => 'Closed',
    ],

    \App\Enums\InvoiceItemType::class => [
        \App\Enums\InvoiceItemType::HOURLY => 'Hourly',
        \App\Enums\InvoiceItemType::FIXED => 'Fixed',
    ],

    \App\Enums\InvoiceStatus::class => [
        \App\Enums\InvoiceStatus::DRAFT => 'Draft',
        \App\Enums\InvoiceStatus::SEND => 'Send',
        \App\Enums\InvoiceStatus::PAID => 'Paid',
        \App\Enums\InvoiceStatus::OVERDUE => 'Overdue',
        \App\Enums\InvoiceStatus::CANCELED => 'Canceled',
        \App\Enums\InvoiceStatus::DEBT => 'Debt',
    ],

    \App\Enums\InvoiceType::class => [
        \App\Enums\InvoiceType::DEFAULT => 'Default',
    ]
];
