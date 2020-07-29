{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Person' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/person.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-view-wrapper section">
        <div class="row">
            <div class="col xl9 m8 s12">
                <div class="card animate fadeLeft">
                    <div class="card-content invoice-print-area">
                        @include('pages.person.partials._form')
                    </div>
                </div>
            </div>
            <!-- action  -->
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div id="change-salary-type-button" class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change salary type</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Change type of contract</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Make former employee</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Long-term vacation</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Back to active employee</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">attach_money</i>
                                <span>Final payslip</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('people.show', $model) }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">visibility</i>
                                <span class="text-nowrap">View Person</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  Contact sidebar -->
    <div id="change-salary-type-sidebar" class="contact-compose-sidebar">
        <div class="card quill-wrapper">
            <div class="card-content pt-0">
                <div class="card-header display-flex pb-2">
                    <h3 class="card-title contact-title-label">Change salary type</h3>
                    <div class="close close-icon">
                        <i class="material-icons">close</i>
                    </div>
                </div>
                <div class="divider"></div>
                <!-- form start -->
                <form name="change-salary-type" class="edit-contact-item mb-5 mt-5" method="post" action="{{ route('people.change-salary-type', $model) }}">
                    @csrf
                    <div class="row">
                        <x-date name="salary_type_changed_at" title="Date" :model="$model"></x-date>
                        <x-select name="salary_type" title="Salary type" :options="$salaryTypes" :model="$model"></x-select>
                    </div>
                </form>
                <!-- form start end-->
                <div class="card-action pl-0 pr-0 right-align">
                    <button class="btn-small waves-effect waves-light add-contact">
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
