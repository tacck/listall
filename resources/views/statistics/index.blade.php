@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Statistic</div>

                <div class="panel-body">
                    <div>
                    @if (isset($bookmarks))
                        @foreach ($bookmarks as $bookmark)
                            <div>
                                <div class="col-md-6">{{ $bookmark['date'] }}</div>
                                <div class="col-md-6">{{ $bookmark['count'] }}</div>
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
