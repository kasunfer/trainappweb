@forelse($routeFees  as $key=> $fee)
<tr>
    <td>{{++$key}}</td>
    <td>{{ $fee->fromStation->name }}</td>
                <td>{{ $fee->toStation->name }}</td>
                <td>{{ $fee->ticket_price }}</td>
    <td class="text-right">
    @can('edit-route-fee')
        <a href="{{route('route-fee.edit',$fee->id)}}">
        <button class="btn btn-icon btn-secondary-transparent rounded-pill btn-wave">
            <i class="ri-edit-line"></i>
        </button></a>
        @endcan
        @can('delete-route-fee')
        <button type="submit" onclick="destroy({{$fee->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
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
<span style="float: left;margin-top:10px;">showing {{ $routeFees->firstItem() }} to {{ $routeFees->lastItem() }} of {{ $routeFees->total() }} Entries</span>
<span style="float: right;">{{$routeFees->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />