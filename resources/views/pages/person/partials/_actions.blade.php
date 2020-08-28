<!-- actions start  -->
<div class="col xl3 m4 s12">
    <div class="card invoice-action-wrapper animate fadeRight">
        <div class="card-content">
            <div id="change-salary-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change salary type</span>
                            </span>
            </div>
            <div id="change-contract-type-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change type of contract</span>
                            </span>
            </div>
            <div id="make-former-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Make former employee</span>
                            </span>
            </div>
            <div id="long-vacation-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Long-term vacation</span>
                            </span>
            </div>
            <div id="back-to-active-button" class="invoice-action-btn{{ ! $model->lastLongVacation() ? ' hide' : '' }}">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Back to active employee</span>
                            </span>
            </div>
            <div id="pay-data-button" class="invoice-action-btn">
                            <span class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Pay Data</span>
                            </span>
            </div>
            <div class="invoice-action-btn">
                <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                    <i class="material-icons mr-3">attach_money</i>
                    <span>Final payslip</span>
                </a>
            </div>
            <div class="invoice-action-btn">
                @if($isEdit)
                    <a href="{{ route('people.show', $model) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                        <i class="material-icons mr-3">visibility</i>
                        <span class="text-nowrap">View Person</span>
                    </a>
                @else
                    <a href="{{ route('people.edit', $person) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                        <i class="material-icons mr-3">edit</i>
                        <span class="text-nowrap">Edit Person</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- actions end  -->
