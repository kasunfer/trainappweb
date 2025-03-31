@forelse($users as $key=> $user)
<tr>
    <td>{{++$key}}</td>
    <td class="wrap-text">{{$user->username}}</td>
    <td>{{$user->code}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->contact}}</td>
    <td>{{$user->roles()->first()->name}}</td>
    <td>
    <div class="form-check form-switch mb-2">
    <input class="form-check-input" type="checkbox" role="switch" onchange="Change_status(this,{{$user->id}})" name="status" id="switch-primary" {{$user->is_active?'checked':''}}>
</div>
    </td>
    <td class="text-right">
    {{--@if($user->roles()->first()->name != 'Super Admin')--}}
    @can('edit-user')
        <a href="{{route('users.edit',$user->id)}}">
        <button class="btn btn-icon btn-secondary-transparent rounded-pill btn-wave">
            <i class="ri-edit-line"></i>
        </button></a>
        @endcan
    {{--@endif--}}
    @can('view-user')
        <a href="{{route('users.show',$user->id)}}">
        <button class="btn btn-icon btn-warning-transparent rounded-pill btn-wave">
            <i class="ri-eye-line"></i>
        </button></a>
        @endcan
        @if($user->roles()->first()->name != 'Super Admin')
        @can('delete-user')
            <button type="submit" onclick="destroy({{$user->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
            <i class="ri-delete-bin-line"></i>
        </button>
        @endcan
        @endif
    </td>
</tr>
@empty
<tr class="empty-row">
    <td colspan="9" class="text-center">No data found.</td>
</tr>
@endforelse
<td colspan="9">
<span style="float: left;margin-top:10px;">showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} Entries</span>
<span style="float: right;">{{$users->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />