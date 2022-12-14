{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Wallet')

{{-- page content --}}
@section('content')
    <!-- edit start -->
    <div class="section animate fadeUp">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <form id="accountForm" method="POST" action="{{ route('wallets.update', $wallet) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="row">
                                        <x-input name="name" title="Name" :model="$wallet"></x-input>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <a href="{{ route('wallets.index') }}" class="btn cancel-btn mr-1">Cancel</a>
                                    <button type="submit" class="btn waves-effect waves-light">
                                        Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- edit ends -->
@endsection
