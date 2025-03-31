@forelse($stations as $key=> $station)
<tr>
    <td>{{++$key}}</td>
    <td class="wrap-text">{{$station->name}}</td>
    <td>{{$station->city}}</td>
    <td>
    <div class="form-check form-switch mb-2">
    <input class="form-check-input" type="checkbox" role="switch" onchange="Change_status(this,{{$station->id}})" name="status" id="switch-primary" {{$station->status?'checked':''}}>
</div>
    </td>
    <td class="text-right">
    @can('edit-stations')
        <a href="{{route('station.edit',$station->id)}}">
        <button class="btn btn-icon btn-secondary-transparent rounded-pill btn-wave">
            <i class="ri-edit-line"></i>
        </button></a>
        @endcan    
        @can('delete-stations')
        <button type="submit" onclick="destroy({{$station->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
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
<span style="float: left;margin-top:10px;">showing {{ $stations->firstItem() }} to {{ $stations->lastItem() }} of {{ $stations->total() }} Entries</span>
<span style="float: right;">{{$stations->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />