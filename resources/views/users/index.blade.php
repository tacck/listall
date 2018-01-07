@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    <div>
                    @if (isset($users))
                        @foreach ($users as $user)
                            <div>
                                <div class="col-md-1">{{Html::link('/users/' . $user['id'], $user['id'])}}</div>
                                <div class="col-md-2">{{ $user['name'] }}</div>
                                <div class="col-md-6">{{ $user['email'] }}</div>
                                <div class="col-md-3">{{ $user['htn_name'] }}</div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
