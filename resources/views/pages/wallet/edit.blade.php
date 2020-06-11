{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Wallet')

{{-- page content --}}
@section('content')
    <!-- edit start -->
    <div class="section">
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
                                    <button type="submit" class="btn indigo mr-1">
                                        Save changes</button>
                                    <a href="{{ route('wallets.index') }}" class="btn btn-light">Cancel</a>
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
