<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ __('Payslip') }}</title>
        <style>
            html {
                margin: {{ config('general.payslip.margins') }};
            }
        </style>
        @yield('page-style')
    </head>
    <body>
    @yield('content')
    </body>
</html>