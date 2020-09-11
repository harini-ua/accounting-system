{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $contract->name)

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
    <div id="contracts" class="users-list-wrapper section">
        <div class="row">
            <div class="page-layout col s12">
                <div class="card details-card pb-10 mr-2">
                    <div class="card-content">
                        <h5>Contracts detail</h5>
                        <div class="row">
                            <div class="col s12 phone mt-4 p-0">
                                <div class="col s1 m1 l1"><i class="material-icons">person</i></div>
                                <div class="col s11 m11 l11">
                                    <p class="m-0"><a href="{{ route('clients.show', $contract->client) }}">{{ $contract->client->name.' ('.$contract->client->company_name.')' }}</a></p>
                                </div>
                            </div>
                            <div class="col s12 mail mt-4 p-0">
                                <div class="col s1 m1 l1"><i class="material-icons">date_range</i></div>
                                <div class="col s11 m11 l11">
                                    <p class="m-0">{{ $contract->created_at.' - '.($contract->closed_at ? $contract->closed_at : 'In work') }}</p>
                                </div>
                            </div>
                            <div class="col s12 mail mt-4 p-0">
                                <div class="col s1 m1 l1"><i class="material-icons">flag</i></div>
                                <div class="col s11 m11 l11">
                                    <p class="m-0">{{ view('partials.view-status', [
                                        'status' => \App\Enums\ContractStatus::getDescription($contract->status),
                                        'color' => \App\Enums\ContractStatus::getColor($contract->status, 'class'),
                                    ]) }}</p>
                                </div>
                            </div>
                            <div class="col s12 mail mt-4 p-0">
                                <div class="col s1 m1 l1"><i class="material-icons">person_outline</i></div>
                                <div class="col s11 m11 l11">
                                    <p class="m-0"><a href="#">{{ $contract->manager->name }}</a></p>
                                </div>
                            </div>
                            <div class="col s12 mail mt-4 p-0">
                                <div class="col s1 m1 l1"><i class="material-icons">comment</i></div>
                                <div class="col s11 m11 l11">
                                    <p class="m-0">{{ $contract->comment }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('contracts.edit', $contract) }}"
                       class="btn-small position-absolute edit-btn">{{ __('Edit') }}</a>
                </div>
                <div class="card user-card-negative-margin" id="feed">
                    <div class="card-content card-border-gray">
                        <h5>{{ __('Invoices') }}</h5>
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
@endsection
