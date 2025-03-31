@extends('admin.layouts.app')
@section('title', 'Route Fee List')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card-title">
                Route Fee
                </div>
                @can('create-route-fee')
                <div class="prism-toggle">
                    <a href="{{ route('route-fee.create') }}"><button class="btn btn-sm btn-primary forProductType">
                        <i class="ri-add-line align-middle me-2 d-inline-block"></i>
                        <span class="text">{{__('translate.add_route_fee')}}</span>
                    </button></a>
                </div>
                @endcan
            </div>
            </div>
            <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table text-nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th>From Station</th>
                <th>To Station</th>
                <th>Ticket Price</th>
                <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('admin.routeFee.filter')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
           
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/common/crud_and_pagination.js') }}"></script>
<script type="text/javascript">
    handleCrud(
        '{{ route('route-fee.create') }}',
        '{{ route('route-fee.store') }}',
        '{{ route('route-fee.show', ':id') }}',
        '{{ route('route-fee.edit', ':id') }}',
        '{{ route('route-fee.update', ':id') }}',
        '{{ route('route-fee.destroy', ':id') }}',
        'tbody',
        {
            create: 'Add Route Fee',
            edit: 'Update Route Fee'
        },
        '{{ route('route-fee.index') }}',
        '{{ csrf_token() }}'
    );
</script>
@endsection