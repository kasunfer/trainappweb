@forelse($trains as $key=> $train)
<tr>
    <td>{{++$key}}</td>
    <td class="wrap-text">{{$train->name}}</td>
    <td>{{$train->code}}</td>
    <td>
    <div class="form-check form-switch mb-2">
    <input class="form-check-input" type="checkbox" role="switch" onchange="Change_status(this,{{$train->id}})" name="status" id="switch-primary" {{$train->status?'checked':''}}>
</div>
    </td>
    <td class="text-right">
    @can('edit-trains')
        <a href="{{route('train.edit',$train->id)}}">
        <button class="btn btn-icon btn-secondary-transparent rounded-pill btn-wave">
            <i class="ri-edit-line"></i>
        </button></a>
        @endcan
        @can('delete-trains')
        <button type="submit" onclick="destroy({{$train->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
            <i class="ri-delete-bin-line"></i>
        </button>
        @endcan
    </td>
</tr>
@empty
<tr class="empty-row">
    <td colspan="9" class="text-center">No data found.</td>
</tr>
@endforelse
<td colspan="9">
<span style="float: left;margin-top:10px;">showing {{ $trains->firstItem() }} to {{ $trains->lastItem() }} of {{ $trains->total() }} Entries</span>
<span style="float: right;">{{$trains->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />