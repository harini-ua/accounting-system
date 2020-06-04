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

{{-- page content --}}
@section('content')
    <!-- client update start -->
    <div id="clients" class="section">
        <h5>{{ $client->name.' ('.$client->company_name.')' }}</h5>
        <div class="row">
            <div class="col s12 m4 l3" style="margin-top: 25px">
                <div class="row">
                    <div class="col s12">
                        <a href="tel:{{ $client->phone }}" class="btn-small btn-light-indigo"><i class="material-icons">call</i></a>
                        <a href="mailto:{{ $client->email }}" class="btn-small btn-light-indigo"><i class="material-icons">mail_outline</i></a>
                        <a href="{{ route('clients.edit', $client) }}" class="btn-small indigo">{{ __('Edit') }}</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col s6">
                        <h6>{{ __('Contracts') }}</h6>
                        <h5 class="m-0"><a href="#" class="tooltipped"
                                           data-position="right"
                                           data-tooltip="{{ __('Total: ').$client->contracts->count().' / '.__('Closed: ').$closedContract }}">{{ $client->contracts->count().'/'.$closedContract}}</a></h5>
                    </div>
                    <div class="col s6">
                        <h6>{{ __('Balance') }}</h6>
                        <h5 class="m-0"><a href="#">+$40</a></h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <h6 class="col s12"> {{ __('Contact') }} </h6>
                    <!-- Phone -->
                    <div class="col s12 phone mt-4 p-0">
                        <div class="col s2 m2 l2"><i class="material-icons">call</i></div>
                        <div class="col s10 m10 l10">
                            <p class="m-0">{{ $client->phone }}</p>
                        </div>
                    </div>
                    <!-- Mail -->
                    <div class="col s12 mail mt-4 p-0">
                        <div class="col s2 m2 l2"><i class="material-icons">mail_outline</i></div>
                        <div class="col s10 m10 l10">
                            <p class="m-0">{{ $client->email }}</p>
                        </div>
                    </div>
                </div>
                <hr>
                @if($client->addresses->count())
                <div class="row">
                    <h6 class="col s12"> {{ __('Address') }} </h6>
                    @foreach($client->addresses as $address)
                    <!-- Address -->
                    <div class="col s12 place mt-4 p-0">
                        <div class="col s2 m2 l2"><i class="material-icons">place</i></div>
                        <div class="col s10 m10 l10">
                            <p class="m-0">{{ $address->postal_code }}, {{ $address->country }}, {{ $address->state }}, {{ $address->city }}</p>
                            <p class="m-0">{{ $address->address }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col s12 m8 l9">
                <div class="row">
                    <div class="card user-card-negative-margin z-depth-0" id="feed">
                        <div class="card-content card-border-gray">
                            <div class="row">
                                <div class="col s12">
                                    <h5>{{ __('Contracts') }}</h5>
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
