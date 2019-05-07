@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Dashboard')}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                    <a class="btn btn-primary" type="button" href="{{route('exam.matchUser')}}">{{__('en.match_user')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $( document ).ready(function() {
            {{--saveMatch({{Auth::user()->id}});--}}
        });

        function saveMatch(user_id) {
            $.ajax({
                "url": '{{route('exam.matchUser')}}',
                "data": {_token:"{{csrf_token()}}", user_id: user_id},
                "dataType": "json",
                "type": "GET"
            }).done(function(resp){
            }).fail(function(e){
            });
        }
    </script>
@endsection
