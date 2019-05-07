@extends('question::layouts.master')

@section('content')
    <h1>@lang('question::en.questions')</h1>

    @foreach($questions as $key => $question)
        <a href="{{route('question.edit', $question)}}"><b>@lang('question::en.question') {{$key+1}}:</b></a> {!!$question->content!!} <br>
        <b>@lang('question::en.options'):</b>
        @foreach($question->data->options as $optNum => $option)
            <i class="text-danger">@lang('question::en.options') {{$optNum+1}}:</i> {!! $option !!}
        @endforeach
        <br>
        <b>@lang('question::en.answer'):</b> {!! $question->data->answer !!}
        <hr>
    @endforeach
@stop
