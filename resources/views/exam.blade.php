@extends('layouts.master')

@section('content')
    <div class="flex-center  full-height">
        {{--@if (Route::has('login'))--}}
            {{--<div class="top-right links">--}}
                {{--@auth--}}
                    {{--<a href="{{ url('/home') }}">Home</a>--}}
                {{--@else--}}
                    {{--<a href="{{ route('login') }}">Login</a>--}}

                    {{--@if (Route::has('register'))--}}
                        {{--<a href="{{ route('register') }}">Register</a>--}}
                    {{--@endif--}}
                {{--@endauth--}}
            {{--</div>--}}
        {{--@endif--}}

        <div class="content">
            <h3> Questions - {{$match->set->set}} </h3>

            <form method="GET" action="{{ route('exam.end') }}">
                <input type="hidden" name="_method" value="GET">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @csrf

                <input type="hidden" name="match_id" value="{{$match->id}}">
                <input type="hidden" name="set_id" value="{{$match->set->id}}">
                @foreach($questions as $key => $question)
                    <b>Question {{$key+1}}:</b> {{$question->content}}<br>
                    @foreach($question->data->options as $option)
                        <input type="radio" name="{{$question->id}}" id="{{$question->id}}" value="{{$option}}"/> {{$option}}
                    @endforeach
                    <br>
                @endforeach
                <br>
                <button type="submit" class="btn btn-primary">{{__('match.start')}}</button>
                <br>
            </form>

        </div>

    </div>
@endsection
