@extends('layouts.master')

@section('content')
    <div class="flex-center">
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
            <h4 class="">
                {{--Examination--}}
            </h4>

                @if(isset($currentMatchSet))
                    <h4> {{__('en.set')}}: {{isset($doneSets) ? count($doneSets)+1 : 1}} - {{__('en.questions')}} </h4>
                    <form method="GET" action="{{ route('exam.end') }}">
                        <input type="hidden" name="_method" value="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @csrf

                        <input type="hidden" name="match_id" value="{{$matchUser->match_id}}">
                        <input type="hidden" name="match_set_id" value="{{$currentMatchSet->id}}">
                        @foreach($questions as $key => $question)
                            <b>{{__('en.question')}} {{$key+1}}:</b> {{$question->content}}<br>
                            @foreach($question->data->options as $option)
                                <input type="radio" name="{{$question->id}}" id="{{$question->id}}" value="{{$option}}"/> {{$option}}
                            @endforeach
                            <br>
                        @endforeach
                        <br>
                        <button type="submit" class="btn btn-primary">{{__('en.set_end')}}</button>
                        <br><br>
                    </form>
                @else
                    @if(isset($doneSets))
                        {{__('en.done_sets')}} <br>
                        @foreach($doneSets as $key=>$ds)
                            {{__('en.set')}} {{$key+1}}:
                            @if(isset($showResult[$ds->id]))
                                @if($ds->win == 0)
                                    <i class="text-danger">{{__('en.match_deuce')}}</i><br>
                                @else
                                    {{__('en.set_winning')}}: <i class="text-success">{{\App\User::find($ds->win)->name}}</i><br>
                                @endif
                            @else
                            <i class="text-danger">{{__('en.match_did_not_finish')}}</i><br>
                            @endif
                        @endforeach
                        <br><a href="{{route('home')}}" class="btn btn-primary">{{__('en.new_match')}}</a>
                    @endif

                    @if(isset($willSets))
                        <b>{{__('en.will_sets')}}</b> <br>
                        @foreach($willSets as $key=>$ws)
                            {{$ws->set->name}}
                        @endforeach
                    @endif

                    @if(isset($showMatchWin))
                        <br><br> {{__('en.win_match')}} <br>
                        <i class="text-primary">{{\App\User::find($win)->name}} {{\App\User::find($win)->surname}}</i>
                    @endif
                @endif

        </div>

    </div>
@endsection
