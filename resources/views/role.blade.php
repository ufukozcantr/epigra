@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Roles')}}</div>

                <div class="card-body">
                    @foreach($users as $user)

                        {{$user->name}} {{$user->surname}}
                        @foreach($user->roles as $role) - {{$role->name}} @endforeach
                        <br>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $( document ).ready(function() {

        });
    </script>
@endsection
