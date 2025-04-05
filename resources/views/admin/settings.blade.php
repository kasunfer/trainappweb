@extends('admin.layouts.app')
@section('title','Add Settings')
<style>
    #seat-layout {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 8px;
        width: fit-content;
        margin: auto;
    }

    .seat-row {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }

    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #007bff;
        background-color: #fff;
        border-radius: 5px;
    }

    .seat button {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        font-weight: bold;
        cursor: pointer;
    }

    .seat.booked {
        background-color: #dc3545;
        /* Red for booked seats */
        border-color: #dc3545;
    }

    .seat.booked button {
        color: white;
        cursor: not-allowed;
    }

    .seat-gap {
        width: 40px;
        height: 40px;
        display: inline-block;
    }

    .seat.selected {
        background-color: #4CAF50;
        /* Green for selected */
        color: white;
    }

    /* Style for booked seats (if you want to show booked seats differently) */
    .seat.booked {
        background-color: #f44336;
        /* Red for booked */
        color: white;
        cursor: not-allowed;
    }
</style>
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Add Settings
                </div>
            </div>
            <div class="card-body">
                <!-- Form to add new setting -->
                <div class="mb-3">
                    <form action="{{ route('setting.store') }}" method="POST">
                        @csrf
                        <h4>Add New Setting</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="key">Setting Key</label>
                                    <input type="text" class="form-control" id="key" name="key" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">Setting Value</label>
                                    <input type="text" class="form-control" id="value" name="value">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Add Setting</button>
                    </form>
                </div>

                <h4>Existing Settings</h4>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $setting)
                        <tr>
                            <form action="{{ route('setting.update', $setting->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <td><input type="text" class="form-control" name="key" value="{{ $setting->key }}" readonly></td>
                                <td><input type="text" class="form-control" name="value" value="{{ $setting->value }}"></td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                </td>
                            </form>
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