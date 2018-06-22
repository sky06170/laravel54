@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Ticket</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="輸入張數 (ex：10) ">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">新增</button>
                        </span>
                    </div>
                </div>
                <!-- Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>序號</th>
                            <th>狀態</th>
                            <th>建立日期</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $key => $ticket)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $ticket->no }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>{{ $ticket->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
