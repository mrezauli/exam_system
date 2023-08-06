<?php

/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Exam\Controllers;

use Modules\Exam\Helpers\StdClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Modules\Exam\Examination;
use Modules\Question\QSelectionTypingTest;
use Modules\Admin\ExamTime;
use App\Http\Requests;
use DB;
use Session;
use Input;


require base_path() . '/modules/exam/Controllers/typing_test_process.php';


class TypingTestController extends Controller
{

    private $object;

    public function __construct()
    {

        $this->object = StdClass::fromArray();
    }


    public function exam_status()
    {

        $object = $this->object;

        $user = Auth::user();

        $user_id = $user->id;

        $examination = Examination::where('user_id', $user_id)->get();

        $first_exam_type = $examination->get(0, $object)->exam_type;

        $first_exam_started = $examination->get(0, $object)->started;

        $first_exam_completed = $examination->get(0, $object)->completed;

        $last_exam_type = $examination->get(1, $object)->exam_type;

        $last_exam_started = $examination->get(1, $object)->started;

        $last_exam_completed = $examination->get(1, $object)->completed;

        return ['first_exam_type' => $first_exam_type, 'first_exam_started' => $first_exam_started, 'first_exam_completed' => $first_exam_completed, 'last_exam_type' => $last_exam_type, 'last_exam_started' => $last_exam_started, 'last_exam_completed' => $last_exam_completed];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Typing Test";

        $user = Auth::user();

        $user_id = $user->id;

        $roll_no = $user->roll_no;

        $username = $user->username;

        $exam_type  = '';

        $question = '';

        $typing_exam_time = ExamTime::where('exam_type','typing_exam')->first()->exam_time;

        $exam_status = $this->exam_status();

        extract($exam_status);


        if( $first_exam_completed && $last_exam_completed ){

            $exams = Examination::with('user')->where('user_id',$user_id)->get();

            return view('exam::typing_exam.completed',compact('exams'));
        }


        if( $first_exam_started && ! $first_exam_completed ){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$first_exam_type)->where('status','active')->first();


            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';


            $exam_type = $first_exam_type;

        }elseif($last_exam_started && ! $last_exam_completed){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$last_exam_type)->where('status','active')->first();

            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';

            $exam_type = $last_exam_type;

        }

        return view('exam::typing_exam.index', compact('question','started','exam_type','first_exam_type','last_exam_type','first_exam_completed','last_exam_completed','first_exam_started','last_exam_started','typing_exam_time','username','roll_no'));
    }

    public function welcome()
    {
        return view('exam::typing_exam.welcome');
    }

    public function enTypingExam()
    {
        $page_title = "Typing Test";

        $user = Auth::user();

        $user_id = $user->id;

        $roll_no = $user->roll_no;

        $username = $user->username;

        $exam_type  = '';

        $question = '';

        $typing_exam_time = ExamTime::where('exam_type','typing_exam')->first()->exam_time;

        $exam_status = $this->exam_status();

        extract($exam_status);


        if( $first_exam_completed && $last_exam_completed ){

            $exams = Examination::with('user')->where('user_id',$user_id)->get();

            return view('exam::typing_exam.completed',compact('exams'));
        }


        if( $first_exam_started && ! $first_exam_completed ){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$first_exam_type)->where('status','active')->first();


            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';


            $exam_type = $first_exam_type;

        }elseif($last_exam_started && ! $last_exam_completed){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$last_exam_type)->where('status','active')->first();

            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';

            $exam_type = $last_exam_type;

        }

        return view('exam::typing_exam.enTypingExam', compact('question','started','exam_type','first_exam_type','last_exam_type','first_exam_completed','last_exam_completed','first_exam_started','last_exam_started','typing_exam_time','username','roll_no'));
    }

    public function bnTypingExam()
    {
        $page_title = "Typing Test";

        $user = Auth::user();

        $user_id = $user->id;

        $roll_no = $user->roll_no;

        $username = $user->username;

        $exam_type  = '';

        $question = '';

        $typing_exam_time = ExamTime::where('exam_type','typing_exam')->first()->exam_time;

        $exam_status = $this->exam_status();

        extract($exam_status);

        if( $first_exam_completed && $last_exam_completed ){

            $exams = Examination::with('user')->where('user_id',$user_id)->get();

            return view('exam::typing_exam.completed',compact('exams'));
        }


        if( $first_exam_started && ! $first_exam_completed ){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$first_exam_type)->where('status','active')->first();


            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';


            $exam_type = $first_exam_type;

        }elseif($last_exam_started && ! $last_exam_completed){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$last_exam_type)->where('status','active')->first();

            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';

            $exam_type = $last_exam_type;

        }

        return view('exam::typing_exam.bnTypingExam', compact('question','started','exam_type','first_exam_type','last_exam_type','first_exam_completed','last_exam_completed','first_exam_started','last_exam_started','typing_exam_time','username','roll_no'));
    }

    /**
     * Create a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function start(Requests\ExamRequest $request, $exam_type)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $typing_exam_time = ExamTime::where('exam_type', 'typing_exam')->first()->exam_time;
        $input = '';


        $exam_status = $this->exam_status();

        extract($exam_status);

        $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id', $user->typing_exam_code_id)->where('exam_type', $exam_type)->where('status', 'active')->first();



        if (!$question) {

            Session::flash('danger', "No question has been set for this exam.");
            return redirect()->route('typing-exams');
        }


        if (empty($first_exam_type) || empty($last_exam_type)) {


            $input = [
                'qselection_typing_id' => $question->id,
                'user_id' => $user_id,
                'exam_type' => $exam_type,
                'exam_time' => $typing_exam_time,
                'started' => $started = 1
            ];


            $answer_created = Examination::where('qselection_typing_id', $question->id)->where('user_id', $user_id)->where('exam_type', $exam_type)->first();



            /* Transaction Start Here */
            DB::beginTransaction();
            try {

                if (!$answer_created) {

                    $task = Examination::create($input);
                }


                //dd($task);
                DB::commit();

                Session::flash('message', 'Successfully added!');
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                //Session::flash('danger', $e->getMessage());

                Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
            }
        }

        /**
         * must be delete
         */
        //return redirect()->route('typing-exams');
        if ($exam_type === 'bangla') {
            return redirect()->route('bn-typing-exam');
        } else {
            return redirect()->route('en-typing-exam');
        }
    }


    /**
     * Create a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function submit(Requests\ExamRequest $request, $exam_type)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $input = $request->all();

        $data = [];

        $typing_exam_time = ExamTime::where('exam_type', 'typing_exam')->first()->exam_time;

        $question = $input['original_text'];
        $answer = $input['answered_text'];


        $test_answer = test_answer($question, $answer);

        $total_words = $test_answer[3];

        $typed_words = $test_answer[4];

        $inserted_words = $test_answer[5];

        $deleted_words = $test_answer[6];

        $accuracy = ($total_words - $deleted_words) / $total_words * 100;

        $wpm = $total_words / $typing_exam_time;



        $data = [

            'original_text' => implode($test_answer[0], ' '),
            'answered_text' => implode($test_answer[1], ' '),
            'process_text' => implode($test_answer[2], ' '),
            'total_words' => $total_words,
            'typed_words' => $typed_words,
            'inserted_words' => $inserted_words,
            'deleted_words' => $deleted_words,

            'accuracy' => round($accuracy, 2),
            'wpm' => $wpm,
            'completed' => 1

        ];



        $examination = Examination::where('user_id', $user_id)->where('exam_type', $exam_type)->first();



        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $test = $examination->update($data);

            DB::commit();

            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            dd($e->getMessage());
            Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
        }


        return redirect()->route('typing-exams');
    }

    public function enPreview(Requests\ExamRequest $request, $exam_type)
    {
        $page_title = "Typing Test";

        $user = Auth::user();

        $user_id = $user->id;

        $roll_no = $user->roll_no;

        $username = $user->username;

        $exam_type  = '';

        $question = '';

        $typing_exam_time = ExamTime::where('exam_type','typing_exam')->first()->exam_time;

        $exam_status = $this->exam_status();

        extract($exam_status);


        if( $first_exam_completed && $last_exam_completed ){

            $exams = Examination::with('user')->where('user_id',$user_id)->get();

            return view('exam::typing_exam.completed',compact('exams'));
        }


        if( $first_exam_started && ! $first_exam_completed ){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$first_exam_type)->where('status','active')->first();


            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';


            $exam_type = $first_exam_type;

        }elseif($last_exam_started && ! $last_exam_completed){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$last_exam_type)->where('status','active')->first();

            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';

            $exam_type = $last_exam_type;

        }

        return view('exam::typing_exam.enTypingExamPreview', compact('request', 'exam_type', 'question','started','exam_type','first_exam_type','last_exam_type','first_exam_completed','last_exam_completed','first_exam_started','last_exam_started','typing_exam_time','username','roll_no'));
    }

    public function bnPreview(Requests\ExamRequest $request, $exam_type)
    {
        $page_title = "Typing Test";

        $user = Auth::user();

        $user_id = $user->id;

        $roll_no = $user->roll_no;

        $username = $user->username;

        $exam_type  = '';

        $question = '';

        $typing_exam_time = ExamTime::where('exam_type','typing_exam')->first()->exam_time;

        $exam_status = $this->exam_status();

        extract($exam_status);


        if( $first_exam_completed && $last_exam_completed ){

            $exams = Examination::with('user')->where('user_id',$user_id)->get();

            return view('exam::typing_exam.completed',compact('exams'));
        }


        if( $first_exam_started && ! $first_exam_completed ){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$first_exam_type)->where('status','active')->first();


            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';


            $exam_type = $first_exam_type;

        }elseif($last_exam_started && ! $last_exam_completed){

            $question = QSelectionTypingTest::with('qbank_typing_question')->where('exam_code_id',$user->typing_exam_code_id)->where('status','active')->where('exam_type',$last_exam_type)->where('status','active')->first();

            $question = isset($question->qbank_typing_question->typing_question)?$question->qbank_typing_question->typing_question:'';

            $exam_type = $last_exam_type;

        }

        return view('exam::typing_exam.bnTypingExamPreview', compact('request', 'exam_type', 'question','started','exam_type','first_exam_type','last_exam_type','first_exam_completed','last_exam_completed','first_exam_started','last_exam_started','typing_exam_time','username','roll_no'));
    }

    public function calculateEnglish(Requests\ExamRequest $request, $exam_type)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $input = $request->all();

        $data = [];

        $typing_exam_time_in_minute = ExamTime::where('exam_type', 'typing_exam')->first()->exam_time;

        $question = $input['original_text'];
        $answer = $input['answered_text'];
        $markedAnswer = $input['process_text'];

        $total_words = $input['totalGivenCharacters'] ? $input['totalGivenCharacters'] : 0;

        $typed_words = $input['typedCharacters'];

        $inserted_words = $input['correctedCharacters'] ? $input['correctedCharacters'] : 0;

        $deleted_words = $typed_words - $inserted_words;

        //accuracy = (number of correctly typed words / total number of words) * 100
        $accuracy = ($inserted_words / $total_words) * 100;
        $accuracy = $accuracy ? $accuracy : 0;

        //WPM = (total number of accurate characters typed / 5) / (time taken in minute)
        $wpm = $inserted_words / $typing_exam_time_in_minute;


        $data = [
            'original_text' => $question,
            'answered_text' => $answer,
            'process_text' => $markedAnswer,
            'total_words' => $total_words,
            'typed_words' => $typed_words,
            'inserted_words' => $inserted_words,
            'deleted_words' => $deleted_words,
            'accuracy' => round($accuracy, 2),
            'wpm' => $wpm,
            'completed' => 1
        ];

        $examination = Examination::where('user_id', $user_id)->where('exam_type', $exam_type)->first();

        //dd($data);
        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $test = $examination->update($data);

            DB::commit();

            return response()->json(['success' => 'Successfully added!']);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();

            return response()->json(['danger' => 'Couldn\'t Update Successfully. Please Try Again.']);
        }
        //return redirect()->route('typing-exams');
    }

    public function calculateBangla(Requests\ExamRequest $request, $exam_type)
    {

        $user = Auth::user();

        $user_id = $user->id;

        $input = $request->all();

        $data = [];

        $typing_exam_time_in_minute = ExamTime::where('exam_type', 'typing_exam')->first()->exam_time;

        $question = $input['original_text'];
        $answer = $input['answered_text'];
        $markedAnswer = $input['process_text'];

        $total_words = $input['totalGivenCharacters'];

        $typed_words = $input['typedCharacters'];

        $inserted_words = $input['correctedCharacters'];

        $deleted_words = $input['wrongCharacters'];

        //accuracy = (number of correctly typed words / total number of words) * 100
        $accuracy = ($inserted_words / $total_words) * 100;

        //WPM = (total number of accurate characters typed / 5) / (time taken in minute)
        $wpm = $inserted_words / $typing_exam_time_in_minute;

        $data = [
            'original_text' => $question,
            'answered_text' => $answer,
            'process_text' => $markedAnswer,
            'total_words' => $total_words,
            'typed_words' => $typed_words,
            'inserted_words' => $inserted_words,
            'deleted_words' => $deleted_words,
            'accuracy' => round($accuracy, 2),
            'wpm' => $wpm,
            'completed' => 1
        ];

        $examination = Examination::where('user_id', $user_id)->where('exam_type', $exam_type)->first();

        //dd($data);
        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $test = $examination->update($data);

            DB::commit();

            return response()->json(['success' => 'Successfully added!']);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();

            return response()->json(['danger' => 'Couldn\'t Update Successfully. Please Try Again.']);
        }


        //return redirect()->route('typing-exams');
    }

    /**
     * Create a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        $page_title = "Exam Informations";

        $user = Auth::user();
        $user_id = $user->user_id;

        $exams = Exam::with('user')->where('user_id', 'user_id')->get();

        return view('exam::typing_exam.completed', compact('exams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ExamRequest $request)
    {

        $user_id = Auth::user()->id;
        $input = $request->all();
        $input['user_id'] = $user_id;


        //dd($input);


        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $task = Examination::create($input);

            //dd($task);
            DB::commit();

            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());

            //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
            return redirect()->back();
        }

        return redirect()->back();
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajax_store(Requests\ExamRequest $request, $id)
    {


        return $_POST;

        $input = Input::except('password', 'task_id');

        $input['lead_id'] = $id;

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $data = Exam::create($input);

            DB::commit();

            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
            return redirect()->back();
        }

        $user = User::find($data->assigned_to_id);

        $username = $user->username;

        $data->username = $username;


        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { //print_r($id);exit;
        $page_title = 'View Exam Informations';
        $data = Exam::find($id);



        return view('exam::typing_exam.view', compact('data', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Exam::find($id);

        $data->start_date = ($data->start_date != '0000-00-00') ? $data->start_date : '';
        $data->finish_date = ($data->finish_date != '0000-00-00') ? $data->finish_date : '';

        $user = Auth::user();
        $user_id = $user->id;


        $user_list =  [$user_id => 'Me'] + User::select('username', 'id')->where('status', 'active')->lists('username', 'id')->all();


        $page_title = 'Update Exam Informations';

        return view('exam::typing_exam.edit', compact('data', 'page_title', 'user_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ExamRequest $request, $id)
    {

        $input = $request->except('id', 'password');
        $model = Exam::where('id', $request->id)->first();




        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Updated");
        } catch (Exception $e) {
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
        }

        return redirect()->route('leads');
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajax_update(Requests\ExamRequest $request, $id)
    {

        $input = $request->except('password', 'task_id');
        $model = Exam::where('id', $request->task_id)->first();



        DB::beginTransaction();
        try {
            $data = $model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Updated");
        } catch (Exception $e) {
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
        }

        $data = Exam::with('assigned_user')->where('id', $request->task_id)->first();

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = Exam::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($model->status == 'active') {
                $model->status = 'inactive';
            } else {
                $model->status = 'active';
            }
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', "Invalid Request. Please Try Again");
        }
        return redirect()->back();
    }




    public function show_result(Requests\ExamRequest $request)
    {

        $input = $request->all();


        //dd($input);
        $question = $input['original_text'];
        $answer = $input['answered_text'];

        // dd($question);
        // $question = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum ab, excepturi fugit laudantium debitis doloremque. Pariatur, saepe, magni! Modi, quam?';

        // $answer = 'Lorem ipsum dolor dfgit amet, sdfs, consectetur adipisicing elit. Eum ab, excepturi fugit laudantium debitis doloremque. Pariatur, saepe, magni! Modi, quam?';



        $ddd = ddd($question, $answer);



        $original_question = implode($ddd[0], ' ');
        $original_answer = implode($ddd[1], ' ');
        $process_answer = implode($ddd[2], ' ');



        $user_id = Auth::user()->id;
        $input = $request->all();

        $input['user_id'] = $user_id;
        $input['original_text'] = $original_question;
        $input['answered_text'] = $original_answer;
        $input['accuracy'] = $process_answer;

        //dd($input);


        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $task = Examination::create($input);

            //dd($task);
            DB::commit();

            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());

            //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
            return redirect()->back();
        }

        return redirect()->back();
    }
}