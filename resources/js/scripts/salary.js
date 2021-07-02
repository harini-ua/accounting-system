$(document).ready(function () {

    $('[name="person_id"], [name="calendar_month_id"]').change(function() {
        $.pjax({
            url: makeUrl({
                params: {
                    year: $('[name="calendar_year_id"]').val(),
                    month: $('[name="calendar_month_id"]').val(),
                    person_id: $('[name="person_id"]').val(),
                }
            }),
            container: '[data-pjax]'
        });
    });

    $(document).on('pjax:complete', function() {
        M.updateTextFields();
        $('[name="wallet_id"], [name="account_id"]').select2();
    });

    $('#salary-payment-form').on('keyup', '[name="worked_hours"]', function() {
        let deltaHours = $('[name="working_hours"]').val() - $('[name="worked_hours"]').val() - $('[name="vacations_hours"]').val();
        $('[name="delta_hours"]').val(deltaHours);
        if($('#person-info').attr('data-earned-recalc')) {
            let earned = Number($('#person-info').attr('data-rate') * $('[name="worked_hours"]').val()).toFixed(2);
            $('[name="earned"]').val(earned);
        }
        updateTotal();
    });

    $('#salary-payment-form').on('keyup', '[name="overtime_hours"]', function() {
        let overtimePay = Number($('#person-info').attr('data-rate') * $('[name="overtime_hours"]').val()).toFixed(2);
        $('[name="overtime_pay"]').val(overtimePay);
        updateTotal();
    });

    $('#salary-payment-form').on('keyup', '[name="fines"]', function() {
        let val = parseFloat($('[name="fines"]').val());
        $('[name="fines"]').val(val ? -Math.abs(val) : null);
        updateTotal();
    });

    $('#salary-payment-form').on('keyup', '[name="monthly_bonus"], [name="tax_compensation"]', function() {
        updateTotal();
    });

    function updateTotal()
    {
        let total = 0;
        for (let field in fields) {
            total += getConvertedFieldValue(field);
        }
        total = Number(total + Number($('#person-info').attr('data-total-bonuses'))).toFixed(2);

        $('[name="total_usd"]').val(total);
        $('[name="total_uah"]').val(Number(convert('USD', 'UAH', total)).toFixed(2));

        M.updateTextFields();
    }

    function convert(from, to, value)
    {
        return value * currencies[from] / currencies[to];
    }

    function convertToUSD(currency, value)
    {
        return convert(currency, 'USD', value);
    }

    function getConvertedFieldValue(field)
    {
        return convertToUSD(fields[field], Number($('[name="'+field+'"]').val()));
    }

    function makeUrl(options) {
        const url = new URL(options.route ? options.route : window.location.href);
        for (let name in options.params) {
            url.searchParams.set(name, options.params[name]);
        }
        return url.href;
    }
});
