<?php

namespace Modules\Question\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Question\Entities\Question;
use Illuminate\Foundation\Validation\ValidatesRequests;

class QuestionController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $questions = Question::all();

        return view('question::index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $question = new Question();

        return view('question::create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'data'=>'required',
            'content'=>'required'
        ]);

        $question = new Question();
        $question->fill($request->all());
        $question->save();

        return view('question::create', compact('request' ,'question'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        dd($id, 'show');
        return view('question::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Question $question)
    {
        return view('question::create', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'data'=>'required',
            'content'=>'required'
        ]);

        $question->fill($request->all());
        $question->save();

        return redirect(route('question.edit', $question));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Question $question)
    {dd('destroy');
        $question->delete();

        return redirect(route('question.index'));
    }
}
