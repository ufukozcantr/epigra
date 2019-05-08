<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Match\Entities\Answer;
use Modules\Match\Entities\Match;
use Modules\Match\Entities\Set;
use Modules\Match\Entities\MatchUser;
use Modules\Match\Entities\MatchSet;
use Modules\Question\Entities\Question;
use DB;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function examiner()
    {
        $user = Auth::user();
        $matchUser = MatchUser::orWhere('first_user', $user->id)->orWhere('second_user', $user->id)->orderBy('id', 'desc')->first();

        if(!$matchUser)
            return redirect(route('home'));

        $allMatchSets = $matchUser->matchSets;
        foreach ($allMatchSets as $matchSet) {
            $allUserAnswers = $matchSet->answers->groupBy('created_by', 'match_set_id');
            if(count($allUserAnswers) == 2){
                foreach ($allUserAnswers as $key => $userAnswers) {
                    $ca[$key] = 0;
                    foreach ($userAnswers as $userAnswer) {
                        @$ca[$userAnswer->created_by] += $userAnswer->point;
                    }
                }

                    $winUserThisSetMax = array_keys($ca, max($ca))[0];
                $winUserThisSetMin = array_keys($ca, min($ca))[0];
                if($winUserThisSetMax == $winUserThisSetMin && count($ca)){
                    $matchSet->win = 0;
                    $matchSet->save();
                }else{
                    $matchSet->win = $winUserThisSetMax;
                    $matchSet->save();
                }
            }
        }

        foreach ($matchUser->matchSets as $matchSet) {
            $thisUserAnswers = $matchSet->answers()->where('created_by', $user->id)->get();
            $thisCountUser = count($matchSet->answers->groupBy('created_by', 'match_set_id'));

            if($thisCountUser > 1){
                $showResult[$matchSet->id] = true;
                $showMatchWin[$matchSet->id] = true;
            }

            if(count($thisUserAnswers) > 0)
                $doneSets[] = $matchSet;
            else{
                $willSets[] = $matchSet;
                $currentMatchSet = $willSets[0];
            }
        }

        if(isset($showMatchWin) && count($showMatchWin) == count($matchUser->matchSets)){
            foreach ($matchUser->matchSets as $matchSet) {
                @$winUsers[$matchSet->win] += 1;
            }
            $win = array_keys($winUsers, max($winUsers))[0];
        }

        $questions = Question::notAnswered($matchUser->match_id)->limit($matchUser->set->question)->get();

        return view('examiner', compact('matchUser', 'willSets', 'currentMatchSet', 'doneSets', 'questions', 'showResult', 'showMatchWin', 'win'));
    }

    public function matchUser(Request $request){

        $user = Auth::user();
        $matchUser = MatchUser::whereNull('first_user')->orWhereNull('second_user')->first();

        $match = Match::inRandomOrder()->first();
        $set = Set::inRandomOrder()->first();

        if($matchUser){
            if(!$matchUser->first_user && !$matchUser->win){
                $matchUser->first_user = $user->id;
            }elseif (!$matchUser->second_user && $matchUser->first_user != $user->id && !$matchUser->win){
                $matchUser->second_user = $user->id;
            }
            $matchUser->save();
        }else{
            $matchUser = new MatchUser();
            $matchUser->first_user = $user->id;
            $matchUser->match_id = $match->id;
            $matchUser->set_id = $set->id;
            $matchUser->save();

            for ($i = 0; $i < $set->set; $i ++) {
                $matchSet = new MatchSet();
                $matchSet->set_id = $set->id;
                $matchSet->match_user_id = $matchUser->id;
                $matchSet->save();
            }

        }

        return redirect(route('exam.examiner'));
    }

    public function end(Request $request){

        foreach ($request->all() as $id => $answer) {
            if($id != '_method' && $id != '_token' && $id != 'match_id' && $id != 'match_set_id'){

                $question = Question::find($id);
                $point = 0;
                if(trim($question->data->answer) == trim($answer))
                    $point = 100;

                $answer = Answer::create([
                    'question_id' => $id,
                    'match_id' => $request->match_id,
                    'match_set_id' => $request->match_set_id,
                    'point' => $point
                ]);

                activity()
                    ->causedBy(Auth::user())
                    ->withProperties([$request->match_id.'-'.$request->match_set_id => $point])
                    ->log('ansid'.$answer->id.'-quid'.$id.'-mid'.$request->match_id.'-msid'.$request->match_set_id.'-point:'.$point);
            }
        }

        return redirect(route('exam.examiner'));
    }

}
