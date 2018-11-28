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
	/**
	 * set directory for save uploaded file in this.
	 */
	private $upload_dir = 'public/attachements';
	
	/**
	 * show list of Questions
	 * @return void
	 */
	public function index()
	{
		// check role of user for show questions.
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
	
	/**
	 * show create question
	 * @return void
	 */
    public function create()
    {
		return view('questions.create');
    }
	
	/**
	 * handle and validate posted request for create question
	 * @param object, $request. posted data from create question form
	 * @return void
	 */
    public function apply(QuestionsRequest $request)
    {
		$questions = new Questions($request->all());
		$questions->user_id = \Auth::user()->id;
		// if file is uploaded save this
		if(!empty($request->attachement))
		{
			$questions->attachement = $request->attachement->storeAs($this->upload_dir, md5(uniqId(rand(), true)) . '.' . $questions->attachement->getClientOriginalExtension());
		}
		$questions->save();
		return redirect('/');
    }
	
	/**
	 * show update form and validate posted request for update question
	 * @param object, $request. posted data from create question form
	 * @param integer, $id. id of question
	 * @return void
	 */
    public function update(Request $request, $id)
    {
		// check called method and validate for update changes
		if($request->isMethod('post'))
		{
			$validator = Validator::make($request->all(), [
				'title' => 'required|max:255',
				'body' => 'required',
			]);
	
			if ($validator->fails())
			{
				return redirect("/questions/update/$id")
					->withErrors($validator)
					->withInput();
			}
			$model = Questions::findOrFail($request->id);
			// if file is uploaded save this
			if(!empty($request->attachement))
			{
				$questions->attachement = $request->attachement->store($this->upload_dir . $questions->attachement->getClientOriginalExtension());
			}
			$model->update($request->all());
			return redirect('/');
		}
		$model = Questions::findOrFail($id);
		// if question is answered or question owner is different with this user then aborted, except admin role
		$user = User::find(\Auth::user()->id);
		if(!$user->hasRole('admin'))
		{
			if(($model->status == 2) || ($model->user_id != \Auth::user()->id))
			{
				return redirect('/')->with('error', 'Permission Denied.');
			}
		}
		return view('questions.update', ['model' => $model]);
	}

	/**
	 * show question with all answers and able to answering to this question
	 * @param integer, id of question
	 * @return void
	 */
	public function view($id)
    {
		$model = Questions::findOrFail($id);
		// if question owner is different with this user then aborted, except admin role
		$user = User::find(\Auth::user()->id);
		if(!$user->hasRole('admin'))
		{
			if($model->user_id != \Auth::user()->id)
			{
				return redirect('/')->with('error', 'Permission Denied.');
			}
		}
		// get relationship with question and answers
		$answer_question = AnswerQuestion::select('answer_id')->where('question_id', $id)->get();
		// get all answers for this question
		$answers = Answers::whereIn('id', $answer_question)->get();
		return view('questions.view', ['model' => $model, 'answers' => $answers]);
	}
	
	/**
	 * delete this question with all answers.
	 * @param object, $request posted data
	 * @return void
	 */
	public function delete(Request $request)
    {
		// check request method
		if($request->isMethod('post'))
		{
			$model = Questions::findOrFail($request->_delete);
			// if question owner is different with this user then aborted, except admin role
			$user = User::find(\Auth::user()->id);
			if(!$user->hasRole('admin'))
			{
				if($model->user_id != \Auth::user()->id)
				{
					return redirect('/')->with('error', 'Permission Denied.');
				}
			}
			$model->delete($request->_delete);
			Answers::where('question_id', $model->id)->delete();
			return redirect('/');
		}
		return redirect("/")
			->with('error', 'Delete this Question is Insecure.');
	}
	
	/**
	 * create answer for question
	 * @param object, $request posted data
	 * @return void
	 */
	public function createAnswer(Request $request)
    {
		// check request method
		if($request->isMethod('post'))
		{
			// validate request
			$validator = Validator::make($request->all(), [
				'q_id' => 'required|integer',
				'body' => 'required',
			]);

			if ($validator->fails())
			{
				return redirect("/questions/view/$request->q_id")
					->withErrors($validator)
					->withInput();
			}
			// just save answer
			$answers = new Answers(['body' => $request->body]);
			$answers->user_id = \Auth::user()->id;
			if($answers->save())
			{
				// save relationship between this answer and this question
				$answer_question = new AnswerQuestion();
				$answer_question->answer_id = $answers->id;
				$answer_question->question_id = $request->q_id;
				if($answer_question->save())
				{
					// change status of question from Open to Answered
					$question = Questions::findOrFail($request->q_id);
					$question->update(['status' => 2]);
				}
			}
			return redirect("/questions/view/$request->q_id");
		}
    }
}