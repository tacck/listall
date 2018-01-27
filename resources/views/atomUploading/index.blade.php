@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Atom Uploading</div>
                    <div class="panel-body">
                        <div>
                            {!! Form::open(['url' => 'atomUploading', 'files' => true], ['class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                {{ Form::label('atomFile', 'Hatena Bookmarks Atom File', ['class' => 'col-md-4']) }}
                                {{ Form::file("atomFile", ['class' => 'col-md-8 control-label']) }}
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {{ Form::submit('Upload', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
