<?php

namespace App\Http\Controllers;
use App\models\Questions;
use App\Http\Requests\QuestionsRequest;
use Illuminate\Http\Request;
use Validator;
use App\models\Answers;
use App\models\AnswerQuestion;
use App\User;

class QuestionsController extends Controller
{
	
	public function index()
	{
		$user = User::find(\Auth::user()->id);
		if($user->hasRole('admin'))
		{
			$questions = Questions::orderBy('id', 'DESC')->get();
		}
		else
		{
			$questions = Questions::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
		}
		return view('questions.index', ['questions' => $questions]);
    }
    
    public function create()
    {
		return view('questions.create');
    }
    
    public function apply(QuestionsRequest $request)
    {
		$questions = new Questions($request->all());
		$questions->user_id = \Auth::user()->id;
		$questions->save();
		return redirect('/');
    }
    
    public function update(Request $request, $id)
    {
		if($request->isMethod('post'))
		{
			$validator = Validator::make($request->all(), [
				'title' => 'required|max:255',
				'body' => 'required',
			]);
	
			if ($validator->fails()) {
				return redirect("/questions/update/$id")
					->withErrors($validator)
					->withInput();
			}
			$model = Questions::findOrFail($request->id);
			$model->update($request->all());
			return redirect('/');
		}
		$model = Questions::findOrFail($id);
		if(($model->status == 2) || ($model->user_id != \Auth::user()->id))
		{
			return redirect('/')->with('error', 'Permission Denied.');
		}
		return view('questions.update', ['model' => $model]);
	}

	public function view($id)
    {
		$model = Questions::findOrFail($id);
		if($model->user_id != \Auth::user()->id)
		{
			return redirect('/')->with('error', 'Permission Denied.');
		}
		$answer_question = AnswerQuestion::select('answer_id')->where('question_id', $id)->get();
		// print_r($answer_question);exit;
		$answers = Answers::whereIn('id', $answer_question)->get();
		return view('questions.view', ['model' => $model, 'answers' => $answers]);
	}
	
	public function delete(Request $request)
    {
		if($request->isMethod('post'))
		{
			$model = Questions::findOrFail($request->_delete);
			if($model->user_id != \Auth::user()->id)
			{
				return redirect('/')->with('error', 'Permission Denied.');
			}
			$model->delete($request->_delete);
			return redirect('/');
		}
		return redirect("/")
			->with('error', 'Delete this Question is Insecure.');
	}
	
	public function createAnswer(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'q_id' => 'required|integer',
			'body' => 'required',
		]);

		if ($validator->fails()) {
			return redirect("/questions/view/$request->q_id")
				->withErrors($validator)
				->withInput();
		}
		$answers = new Answers(['body' => $request->body]);
		$answers->user_id = \Auth::user()->id;
		if($answers->save()) {
			$answer_question = new AnswerQuestion();
			$answer_question->answer_id = $answers->id;
			$answer_question->question_id = $request->q_id;
			if($answer_question->save()) {
				$question = Questions::findOrFail($request->q_id);
				$question->update(['status' => 2]);
			}
		}
		return redirect("/questions/view/$request->q_id");
    }
}