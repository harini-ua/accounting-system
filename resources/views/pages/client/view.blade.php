{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "$client->name ($client->company_name)")

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- client update start -->
    <div id="clients" class="users-list-wrapper section">
        <div class="row">
            <div>
            </div>
            <div class="page-layout row">
                <div class="col pb-2">
                    <div class="card details-card height-100 pb-10">
                        <div class="card-content">
                            <h5>Clients detail</h5>
                            <div class="row mt-5">
                                <div class="col s6">
                                    <h6 class="indigo-text">{{ __('Contracts') }}</h6>
                                    <h5 class=" m-0">
                                        <a href="#"
                                           class="tooltipped indigo-text text-darken-1"
                                           data-position="right"
                                           data-tooltip="{{ __('Total: ').$client->contracts->count().' / '.__('Closed: ').$closedContract }}">{{ $client->contracts->count().'/'.$closedContract}}</a>
                                    </h5>
                                </div>
                                <div class="col s6">
                                    <h6 class="purple-text">{{ __('Balance') }}</h6>
                                    <h5 class="m-0"><a class="purple-text text-darken-1" href="#">+$40</a></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h6 class="col s12 mt-3"> {{ __('Contact') }} </h6>
                                <!-- Phone -->
                                <div class="col s12 phone mb-2 p-0">
                                    <div class="col s2 m2 l2"><i class="material-icons">call</i></div>
                                    <div class="col s10 m10 l10">
                                        <p class="m-0">{{ $client->phone }}</p>
                                    </div>
                                </div>
                                <!-- Mail -->
                                <div class="col s12 mail p-0">
                                    <div class="col s2 m2 l2"><i class="material-icons">mail_outline</i></div>
                                    <div class="col s10 m10 l10">
                                        <p class="m-0">{{ $client->email }} <a href="mailto:{{ $client->email }}"
                                                                               class="btn-small indigo float-right"><i
                                                    class="material-icons">mail_outline</i></a></p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @if($address = $client->billingAddress)
                                <div class="row">
                                    <h6 class="col s12 mt-3"> {{ __('Address') }} </h6>
                                    <!-- Address -->
                                    <div class="col s12 place mb-2 p-0">
                                        <div class="col s2 m2 l2"><i class="material-icons">place</i></div>
                                        <div class="col s10 m10 l10">
                                            <p class="m-0">{{ $address->postal_code }}, {{ $address->country }}
                                                , {{ $address->state }}, {{ $address->city }}</p>
                                            <p class="m-0">{{ $address->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($bank = $client->bank)
                                <hr>
                                <div class="row">
                                    <h6 class="col s12"> {{ __('Bank Details') }}</h6>
                                    <div class="col s12 padding-2">
                                        <table class="responsive-table">
                                            <tbody>
                                            @if($bank->name)
                                                <tr>
                                                    <td>{{ __('Bank') }}:</td>
                                                    <td>{{ $bank->name }}</td>
                                                </tr>@endif
                                            @if($bank->address)
                                                <tr>
                                                    <td>{{ __('Bank Address') }}:</td>
                                                    <td>{{ $bank->address }}</td>
                                                </tr>@endif
                                            @if($bank->account)
                                                <tr>
                                                    <td>{{ __('Account #') }}:</td>
                                                    <td>{{ $bank->account }}</td>
                                                </tr>@endif
                                            @if($bank->iban)
                                                <tr>
                                                    <td>{{ __('IBAN') }}:</td>
                                                    <td>{{ $bank->iban }}</td>
                                                </tr>@endif
                                            @if($bank->swift)
                                                <tr>
                                                    <td>{{ __('SWIFT CODE') }}:</td>
                                                    <td>{{ $bank->swift }}</td>
                                                </tr>@endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('clients.edit', $client) }}"
                           class="position-absolute btn-small float-right edit-btn">{{ __('Edit') }}</a>
                    </div>
                </div>
                <div class="col pb-2">
                    <div class="card user-card-negative-margin height-100" id="feed">
                        <div class="card-content card-border-gray">
                            <h5>{{ __('Contracts') }}</h5>
                            <!-- datatable start -->
                            <div class="users-list-table">
                                <!-- datatable start -->
                                <div class="responsive-table">
                                    {{ $dataTable->table() }}
                                </div>
                                <!-- datatable ends -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- client update ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>
    <script src="{{asset('js/scripts/clients.js')}}"></script>
@endsection
