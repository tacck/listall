@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>

                    <div class="panel-body">
                        <div>
                            @if (isset($user))
                                <div>
                                    <div class="col-md-1">{{ $user['id'] }}</div>
                                    <div class="col-md-2">{{ $user['name'] }}</div>
                                    <div class="col-md-6">{{ $user['email'] }}</div>
                                    <div class="col-md-3">{{ $user['htn_webhook_token'] }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
