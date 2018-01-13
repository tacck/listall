@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User</div>
                    <div class="panel-body">
                        <div>
                            @if (isset($user))
                                <form class="form-horizontal" method="POST"
                                      action="{{ Helper::routeEx('users.update', ['id' => 1]) }}">
                                    <input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-md-1">{{ $user['id'] }}</div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) }}
                                        <div class="col-md-6">
                                            {{ Form::email('email', $value = $user['email'], ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('name', 'Hatena Name', ['class' => 'col-md-4 control-label']) }}
                                        <div class="col-md-6">
                                            {{ Form::text('name', $value = $user['name'], ['class' => 'form-control']) }}
                                        </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('htn_webhook_token', 'Hatena Web Hook Token', ['class' => 'col-md-4 control-label']) }}
                                        <div class="col-md-6">
                                            {{ Form::text('htn_webhook_token', $value = $user['htn_webhook_token'], ['class' => 'form-control']) }}
                                        </div>
                                        @if ($errors->has('htn_webhook_token'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('htn_webhook_token') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('password', 'New Ppassword', ['class' => 'col-md-4 control-label']) }}
                                        <div class="col-md-6">
                                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Input password if you want to change.']) }}
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'Ppassword Confirmation', ['class' => 'col-md-4 control-label']) }}
                                        <div class="col-md-6">
                                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Input password again.']) }}
                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            {{ Form::submit('Commit', ['class' => 'btn btn-primary']) }}
                                        </div>
                                    </div>

                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
