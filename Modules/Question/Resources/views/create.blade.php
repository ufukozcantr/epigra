@extends('question::layouts.master')

@section('content')
    @if($question->id)
        <h1>@lang('question::en.edit')</h1>
    @else
        <h1>@lang('question::en.create')</h1>
    @endif

    <form action="{{route('question.destroy', $question)}}" method="GET" id="delete_form" name="delete_form">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf
    </form>

    <form method="POST" action="{{ $question->id ? route('question.update', $question) : route('question.store') }}">
        <input type="hidden" name="_method" value="@if($question->id) PUT @else POST @endif">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf
        <div class="form-group">

            <label for="content">@lang('question::en.content') :</label>
            <input type="text" class="form-control" name="content" value="{{$question->content}}"/>
            @if ($errors->has('content'))
                <span class="text-danger">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="data">@lang('question::en.data') :</label>
            <textarea type="text" class="form-control" name="data">{{$question->id ? json_encode($question->data) : ""}}</textarea>
            @if ($errors->has('data'))
                <span class="text-danger">
                    <strong>{{ $errors->first('data') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">@lang('question::en.save')</button>
        @if($question->id)
            <button type="submit" class="btn btn-danger delete">@lang('question::en.delete')</button>
        @endif
    </form>
@stop

@section('js')
    <script type="text/javascript">

        $(document).ready(function () {
            $("button.delete").on("click", function () {
                event.preventDefault();
                console.log($(".form_delete"));
                $(".form_delete").submit();
            });
        });
    </script>
@stop