@extends('app.layout.app')
@section('title', 'Active Users')
@section('main-content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Active Users
                </div>
            </div>
            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('translate.name')}}</th>
                                            <th scope="col">{{__('translate.last_login')}}</th>
                                            <th scope="col">{{__('translate.last_activity_on')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activeUsers as $key=> $user)
                        <tr>
                            <th>{{++$key}}</th>
                            <td class="wrap-text">{{$user->username}}</td>
                            <td>{{Carbon\Carbon::parse($user->last_login)->diffForHumans()}}</td>
                            <td>{{Carbon\Carbon::parse($user->last_activity)->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
           
</div>
@endsection
