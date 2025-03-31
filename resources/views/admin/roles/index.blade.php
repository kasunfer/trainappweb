@extends('admin.layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
{{--@can('create_roles')--}}
<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Roles & Permissions</h5>
            
            @can('create-roles')
                <a href="{{ route('roles.create') }}">
                    <button class="btn btn-sm btn-primary forProductType">
                        <i class="ri-add-line align-middle me-2 d-inline-block"></i>
                        <span class="text">Add Roles & Permissions</span>
                    </button>
                </a>
            @endcan
        </div>
              <!-- Default Table -->
              <table class="table table-responsive">
                <thead>
                  <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" style="width: 200px;">Permissions</th>
                        <th scope="col" class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @include('admin.roles.filter')
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
{{--@endcan--}}
@endsection
@section('scripts')
<script src="{{ asset('js/common/crud_and_pagination.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.group-checkbox').change(function() {
            var groupId = $(this).data('group-id');
            var isChecked = $(this).prop('checked');
            $('.permission-checkbox').each(function() {
                console.log('per', $(this).data('group-id'));
                if ($(this).data('group-id') == groupId) {
                    $(this).prop('checked', isChecked);
                }
            });
        });
    });
    handleCrud(
        '{{ route('roles.create') }}',
        '{{ route('roles.store') }}',
        '{{ route('roles.show', ':id') }}',
        '{{ route('roles.edit', ':id') }}',
        '{{ route('roles.update', ':id') }}',
        '{{ route('roles.destroy', ':id') }}',
        'tbody',
        {
            create: 'Add Role',
            edit: 'Update Role'
        },
        '{{ route('roles.index') }}',
        '{{ csrf_token() }}'
    );
</script>
@endsection