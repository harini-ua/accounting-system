{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Wallet' )

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
                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light">
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
                    <h3 class="card-title contact-title-label">Create New Contact</h3>
                    <div class="close close-icon">
                        <i class="material-icons">close</i>
                    </div>
                </div>
                <div class="divider"></div>
                <!-- form start -->
                <form class="edit-contact-item mb-5 mt-5">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> perm_identity </i>
                            <input id="first_name" type="text" class="validate">
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> perm_identity </i>
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Last Name</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> business </i>
                            <input id="company" type="text" class="validate">
                            <label for="company">Company</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> business_center </i>
                            <input id="business" type="text" class="validate">
                            <label for="business">Job Title</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> email </i>
                            <input id="email" type="email" class="validate">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> call </i>
                            <input id="phone" type="text" class="validate">
                            <label for="phone">Phone</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> note </i>
                            <input id="notes" type="text" class="validate">
                            <label for="notes">Notes</label>
                        </div>
                    </div>
                </form>
                <div class="card-action pl-0 pr-0 right-align">
                    <button class="btn-small waves-effect waves-light add-contact">
                        <span>Add Contact</span>
                    </button>
                    <button class="btn-small waves-effect waves-light update-contact display-none">
                        <span>Update Contact</span>
                    </button>
                </div>
                <!-- form start end-->
            </div>
        </div>
    </div>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/person.js')}}"></script>
@endsection
