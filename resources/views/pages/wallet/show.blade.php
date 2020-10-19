{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Wallet' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- app invoice View Page -->
    <section class="invoice-view-wrapper section">
        <div class="row">
            <!-- invoice view page -->
            <div class="col xl9 m8 s12">
                <div class="card animate fadeLeft">
                    <div class="card-content invoice-print-area">
                        <!-- header section -->

                        <!-- logo and title -->
                        <div class="row mt-3 invoice-logo-title">
                            <div class="col m6 s12"></div>
                            <div class="col m6 s12 pull-m6 mb-4">
                                <h4 class="indigo-text mb-0 mt-0">{{ $wallet->name }}</h4><br>
                                <span>{{ $wallet->walletType->name }}</span>
                            </div>
                        </div>
                        <!-- product details table-->
                        <div class="invoice-product-details">
                            <table class="responsive-table">
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
                                                <span class="chip green green-text">Active</span>
                                            @else
                                                <span class="chip red red-text">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="right-align">{{ $account->balance }}</td>
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
                <div class="card invoice-action-wrapper animate fadeRight">
                    <div class="card-content">
                        <div class="invoice-action-btn">
                            <a href="{{ route('accounts.index') }}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <span>Account List</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn">
                            <a href="{{ route('money-flows.create') }}" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                <i class="material-icons mr-3">attach_money</i>
                                <span class="text-nowrap">Money flow</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
