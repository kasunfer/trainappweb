@forelse($train_schedules as $key=> $train_schedule)
<tr>
    <td>{{++$key}}</td>
    <td>{{ $train_schedule->train->name }}</td>
                <td>{{ $train_schedule->schedule_date }}</td>
                <td>{{ $train_schedule->departure_time }}</td>
    <td class="text-right">
    @can('edit-trains-schedules')
        <a href="{{route('train-schedules.edit',$train_schedule->id)}}">
        <button class="btn btn-icon btn-secondary-transparent rounded-pill btn-wave">
            <i class="ri-edit-line"></i>
        </button></a>
        @endcan
        @can('edit-trains-schedules')
        <button type="submit" onclick="destroy({{$train_schedule->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
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
<span style="float: left;margin-top:10px;">showing {{ $train_schedules->firstItem() }} to {{ $train_schedules->lastItem() }} of {{ $train_schedules->total() }} Entries</span>
<span style="float: right;">{{$train_schedules->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />