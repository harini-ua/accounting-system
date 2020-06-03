{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Wallet View' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- app invoice View Page -->
    <section class="invoice-view-wrapper section">
        <div class="row">
            <!-- invoice view page -->
            <div class="col xl9 m8 s12">
                <div class="card">
                    <div class="card-content invoice-print-area">
                        <!-- header section -->

                        <!-- logo and title -->
                        <div class="row mt-3 invoice-logo-title">
                            <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
{{--                                <img src="{{asset('images/gallery/pixinvent-logo.png')}}" alt="logo" height="46" width="164">--}}
                            </div>
                            <div class="col m6 s12 pull-m6">
                                <h4 class="indigo-text">Wallet</h4>
                                <span>{{ $wallet->name }}</span><br>
                                <span>{{ $wallet->walletType->name }}</span>
                            </div>
                        </div>
                        <div class="divider mb-3 mt-3"></div>
                        <!-- product details table-->
                        <div class="invoice-product-details">
                            <table class="striped responsive-table">
                                <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th class="right-align">Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wallet->accounts as $account)
                                    <tr>
                                        <td>{{ $account->accountType->name }}</td>
                                        <td>
                                            @if($account->status)
                                                <span class="chip lighten-5 green green-text">Active</span>
                                            @else
                                                <span class="chip lighten-5 red red-text">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="indigo-text right-align">{{ $account->balance }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- invoice subtotal -->
                    </div>
                </div>
            </div>
            <!-- invoice action  -->
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper">
                    <div class="card-content">
                        <div class="invoice-action-btn">
                            <a href="{{ route('accounts.index') }}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Account List</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('money-flows.create') }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">attach_money</i>
                                <span class="text-nowrap">Add Payment</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- page scripts --}}
@section('page-script')

@endsection
