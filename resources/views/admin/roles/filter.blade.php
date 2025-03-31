@forelse($roles as $key=> $role)
<tr>
    <td>{{++$key}}</td>
    <td>{{$role->name}}</td>
    <td style="width: 60%;">
        @php
        $chunks = $role->permissions->chunk(4);
        $badgeClasses = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-dark'];
        @endphp
        @foreach($chunks as $chunk)
        <div class="permission-group">
            @foreach($chunk as $key =>$permission)
            <span class="badge rounded-pill {{ $badgeClasses[$key % count($badgeClasses)] }} permission-item">{{ ucwords(str_replace('-', ' ', $permission->name)) }}</span>
            @endforeach
        </div>
        @endforeach
    </td>

    <td class="text-right">
    @can('edit-roles')
        <a href="{{route('roles.edit',$role->id)}}">
        <button class="btn btn-icon btn-secondary-transparent rounded-pill btn-wave">
            <i class="ri-edit-line"></i>
        </button></a>
        @endcan
        @can('delete-roles')
            <button type="submit" onclick="destroy({{$role->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
            <i class="ri-delete-bin-line"></i>
        </button>
        @endcan
    </td>
</tr>
@empty
<tr class="empty-row">
    <td colspan="4" class="text-center">No data found.</td>
</tr>
@endforelse
<td colspan="4">
<span style="float: left;margin-top:10px;">showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }} Entries</span>
<span style="float: right;">{{$roles->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />