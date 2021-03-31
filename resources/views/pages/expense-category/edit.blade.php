{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edit Expense Category')

{{-- page content --}}
@section('content')
<div class="section">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12">
                    <form method="POST" action="{{ route('expense-categories.update', $model) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="row">
                                    <x-input name="name" title="Category name" :model="$model"></x-input>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="row">
                                    <x-textarea name="comment" title="Comments" :model="$model"></x-textarea>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end mt-3">
                                <a href="{{ route('expense-categories.index') }}" class="btn btn-light cancel-btn mr-1">Cancel</a>
                                <button type="submit" class="btn waves-light waves-effect">
                                    Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
