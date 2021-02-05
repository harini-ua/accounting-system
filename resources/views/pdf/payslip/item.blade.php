<div class="payslip-wrapper">
    <table class="payslip">
        <tr>
            <td colspan="3" class="first no-border text-center title first-row">{{ $calendarMonth->name }} {{ $year }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.currency_dollar', [], 'ru') }}</td>
            <td class="values">{{ $payslip['currency'] }}</td>
        </tr>
        <tr>
            <td rowspan="2" class="first">{{ __('payslip.number_of_working', [], 'ru') }}</td>
            <td>{{ __('payslip.days', [], 'ru') }}</td>
            <td class="values">
                @php
                    $workingDay = $calendarMonth->calendar_days - $calendarMonth->holidays - $calendarMonth->weekends;
                @endphp
                {{ $workingDay }}
            </td>
        </tr>
        <tr>
            <td>{{ __('payslip.hours', [], 'ru') }}</td>
            <td class="values">{{ $workingDay * config('general.hour_day') }}</td>
        </tr>
        <tr>
            <td colspan="3" class="first no-border text-center title">{{ $payslip['person']['name'] }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.salary_type', [], 'ru') }}</td>
            <td class="values">{{ \App\Enums\SalaryType::getDescription($payslip['person']['salary_type']) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.type_of_contracts', [], 'ru') }}</td>
            <td class="values">{{ \App\Enums\PersonContractType::getDescription($payslip['person']['contract_type']) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.salary', [], 'ru') }}</td>
            <td class="values">{{ \App\Services\Formatter::currency( $payslip['person']['salary'], \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td rowspan="2" class="first">{{ __('payslip.number_of_working', [], 'ru') }}</td>
            <td>{{ __('payslip.days', [], 'ru') }}</td>
            <td class="values">{{ $payslip['worked_days'] }}</td>
        </tr>
        <tr>
            <td>{{ __('payslip.hours', [], 'ru') }}</td>
            <td class="values">{{ $payslip['worked_hours'] }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.delta_hours', [], 'ru') }}</td>
            <td class="values">
                @php
                    if (\App\Enums\SalaryType::isHourly($payslip['person']['salary_type']) || is_null($payslip['id'])) {
                        $delta = 0;
                    } else {
                        $deltaHours = $calendarMonth->getWorkingHours($payslip['person']['salary_type'])
                            - $payslip['worked_hours'] - \App\Services\SalaryPaymentService::calcHours((int) $payslip['vacations'], $payslip['person']['salary_type']);

                        $delta = round($deltaHours, 2);
                    }
                @endphp
                {{ $delta }}
            </td>
        </tr>
        <tr>
            <td rowspan="2" class="first">{{ __('payslip.overtime', [], 'ru') }}</td>
            <td>{{ __('payslip.hours', [], 'ru') }}</td>
            <td class="values">{{ $payslip['overtime_hours'] }}</td>
        </tr>
        <tr>
            <td>{{ __('payslip.pay', [], 'ru') }}</td>
            <td class="values">-</td>
        </tr>
        <tr>
            <td rowspan="3" class="first">{{ __('payslip.bonuses', [], 'ru') }}</td>
            <td>USD</td>
            <td class="values">{{ \App\Services\Formatter::currency( ($payslip['bonuses'] !== null && $payslip['bonuses']->USD) ? $payslip['bonuses']->USD : 0, \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td>EUR</td>
            <td class="values">{{ \App\Services\Formatter::currency( ($payslip['bonuses'] !== null && $payslip['bonuses']->EUR) ? $payslip['bonuses']->EUR : 0, \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td>UAH</td>
            <td class="values">{{ \App\Services\Formatter::currency( ($payslip['bonuses'] !== null && $payslip['bonuses']->UAH) ? $payslip['bonuses']->UAH : 0, \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td rowspan="2" class="first">{{ __('payslip.vacation', [], 'ru') }}</td>
            <td>{{ __('payslip.days', [], 'ru') }}</td>
            <td class="values">
                @php($vacation = $payslip['vacations'] ?? 0)
                {{ $payslip['vacations'] ?? 0 }}
            </td>
        </tr>
        <tr>
            <td>{{ __('payslip.compensation', [], 'ru') }}</td>
            <td class="values">
                @php($compensation = \App\Services\Formatter::currency( $vacation ? $payslip['vacation_compensation'] : 0, \App\Enums\Currency::symbol(\App\Enums\Currency::USD)))
                {{ $compensation }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.leads', [], 'ru') }}</td>
            <td class="values">
                @php($leads = $payslip['person']['tech_lead_reward'] + $payslip['person']['team_lead_reward'])
                @php($leads = \App\Services\Formatter::currency($leads ?? 0, \App\Enums\Currency::symbol(\App\Enums\Currency::USD)))
                {{ $leads }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.monthly_bonus', [], 'ru') }}</td>
            <td class="values">{{ \App\Services\Formatter::currency( $payslip['monthly_bonus'], \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.fines', [], 'ru') }}</td>
            <td class="values">{{ \App\Services\Formatter::currency( $payslip['fines'], \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="first">{{ __('payslip.compensations', [], 'ru') }}</td>
            <td class="values">{{ \App\Services\Formatter::currency( $payslip['tax_compensation'] + $payslip['other_compensation'], \App\Enums\Currency::symbol($payslip['person']['currency'])) }}</td>
        </tr>
        <tr>
            <td rowspan="3" class="first">{{ __('payslip.total', [], 'ru') }}</td>
            <td>UAH</td>
            <td class="values">
                @php($total = \App\Services\Formatter::currency($payslip['total_usd'] * $payslip['currency'], \App\Enums\Currency::symbol(\App\Enums\Currency::UAH)))
                {{ $total }}
            </td>
        </tr>
        <tr>
            <td>USD</td>
            <td class="values">
                @php($total = \App\Services\Formatter::currency($payslip['total_usd'], \App\Enums\Currency::symbol(\App\Enums\Currency::USD)))
                {{ $total }}
            </td>
        </tr>
    </table>

    <table class="payslip-footer">
        <tr>
            <td>{{ \Carbon\Carbon::now()->format('m/d/Y G:i:s') }}</td>
            <td class="text-right">#{{ $payslip['id'] }}</td>
        </tr>
    </table>
</div>
