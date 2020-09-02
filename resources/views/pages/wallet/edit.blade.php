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
                <!-- <div class="card-body"> -->
                <div class="row">
                    <div class="col s12">
                        <!-- form start -->
                        <form id="accountForm" method="POST" action="{{ route('wallets.update', $model) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="row">
                                        <x-input name="name" title="Name" :model="$model"></x-input>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <a href="{{ route('wallets.index') }}" class="btn chanel-btn mr-1">Cancel</a>
                                    <button type="submit" class="btn waves-effect waves-light">
                                        Save changes</button>
                                </div>
                            </div>
                        </form>
                        <!-- edit form ends -->
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <!-- edit ends -->
@endsection
