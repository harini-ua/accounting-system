<!-- actions start  -->
<div class="col xl3 m4 s12">
    <div class="card invoice-action-wrapper animate fadeRight">
        <div class="card-content">
            <div id="change-salary-type-button" data-bind-block="change-salary-type-slide-down" class="invoice-action-btn slide-down-trigger">
                <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                    <span>{{ __('Change salary type') }}</span>
                </span>
            </div>
            <div id="change-contract-type-button" data-bind-block="change-contract-type-slide-down" class=" slide-down-trigger invoice-action-btn">
                <span class="btn-block btn  btn-light-indigo waves-effect waves-light">
                    <span>{{ __('Change type of contract') }}</span>
                </span>
            </div>
            <div id="make-former-button" data-bind-block="make-former-slide-down" class="invoice-action-btn slide-down-trigger">
                <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                    <span>{{ __('Make former employee') }}</span>
                </span>
            </div>
            <div id="long-vacation-button" data-bind-block="long-vacation-slide-down" class="slide-block-btn invoice-action-btn slide-down-trigger">
                <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                    <span>{{ __('Long-term vacation') }}</span>
                </span>
            </div>
            <div id="back-to-active-button" data-bind-block="back-to-active-slide-down" class="slide-down-trigger invoice-action-btn{{ ! $model->lastLongVacation() && ! $model->quited_at ? ' hide' : '' }}">
                <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                    <span>{{ __('Back to active employee') }}</span>
                </span>
            </div>
            <div id="pay-data-button" data-bind-block="pay-data-slide-down" class="slide-down-trigger invoice-action-btn">
                <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                    <span>{{ __('Pay Data') }}</span>
                </span>
            </div>
{{--            <div class="invoice-action-btn">--}}
{{--                <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">--}}
{{--                    <i class="material-icons mr-3">attach_money</i>--}}
{{--                    <span>{{ __('Final payslip') }}</span>--}}
{{--                </a>--}}
{{--            </div>--}}
            <div class="invoice-action-btn">
                @if($isEdit)
                    <a href="{{ route('people.show', $model) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                        <i class="material-icons mr-3">visibility</i>
                        <span class="text-nowrap">{{ __('View Person') }}</span>
                    </a>
                @else
                    <a href="{{ route('people.edit', $person) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                        <i class="material-icons mr-3">edit</i>
                        <span class="text-nowrap">{{ __('Edit Person') }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- actions end  -->
