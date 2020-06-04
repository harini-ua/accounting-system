{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $contract->name)

{{-- page content --}}
@section('content')
    <!-- client update start -->
    <div id="contracts" class="section">

    </div>
    <!-- client update ends -->
@endsection
