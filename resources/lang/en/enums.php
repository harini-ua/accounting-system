<?php

return [
    \App\Enums\BonusType::class => [
        \App\Enums\BonusType::FIXED => 'Fixed',
        \App\Enums\BonusType::PERCENT => 'Percent',
    ],

    \App\Enums\ContractStatus::class => [
        \App\Enums\ContractStatus::OPENED => 'Opened',
        \App\Enums\ContractStatus::CLOSED => 'Closed',
    ],

    \App\Enums\Currency::class => [
        \App\Enums\Currency::USD => 'USD',
        \App\Enums\Currency::EUR => 'EUR',
        \App\Enums\Currency::UAH => 'UAH',
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
    ],

    \App\Enums\PersonContractType::class => [
        \App\Enums\PersonContractType::Individual2 => 'Individual II group',
        \App\Enums\PersonContractType::Individual3 => 'Individual III group',
        \App\Enums\PersonContractType::Contract => 'Contract',
        \App\Enums\PersonContractType::Employee => 'Employee',
    ],

    \App\Enums\Position::class => [
        \App\Enums\Position::CEO => 'CEO',
        \App\Enums\Position::COO => 'CEO',
        \App\Enums\Position::ProjectManager => 'Project Manager',
        \App\Enums\Position::Manager => 'Manager',
        \App\Enums\Position::SalesManager => 'Sales Manager',
        \App\Enums\Position::Developer => 'Developer',
        \App\Enums\Position::SysAdmin => 'SysAdmin',
        \App\Enums\Position::Accountant => 'Accountant',
        \App\Enums\Position::Designer => 'Designer',
    ],

    \App\Enums\SalaryType::class => [
        \App\Enums\SalaryType::Fixed40 => 'Fixed 40 hours week',
        \App\Enums\SalaryType::Fixed30 => 'Fixed 30 hours week',
        \App\Enums\SalaryType::Fixed20 => 'Fixed 20 hours week',
        \App\Enums\SalaryType::Hourly => 'Hourly',
    ],

    \App\Enums\VacationType::class => [
        \App\Enums\VacationType::Planned => 'Planned vacation',
        \App\Enums\VacationType::Actual => 'Actual vacation',
        \App\Enums\VacationType::Sick => 'Sick leave',
    ],

    \App\Enums\VacationPaymentType::class => [
        \App\Enums\VacationPaymentType::Paid => 'Paid',
        \App\Enums\VacationPaymentType::Unpaid => 'Unpaid',
    ],
];
