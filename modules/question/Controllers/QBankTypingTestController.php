<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Question\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Modules\Question\QBankTypingTest;
use App\Http\Requests;
use DB;
use Session;
use Input;


class QBankTypingTestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */


    public function index()
    {

        $page_title = "Typing Speed Test Question";

        $data = QBankTypingTest::where('status','active')->orderBy('id','desc')->get();

        return view('question::qbank_typing_test.index', compact('data', 'page_title'));
    }


    public function create()
    {

        $page_title = "Add Typing Test Questions";

        return view('question::qbank_typing_test.create',compact('page_title'));
    }

    public function store(Requests\QBankTypingTestRequest $request)
    {
        $input = $request->all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            foreach ($input['typing_question'] as $value) {
      
                $value = ['typing_question' => $value,
                          'exam_type'=>$input['exam_type'],
                          'status'=>'active'];
                QBankTypingTest::create($value);
    
            }

            DB::commit();
            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
        }

        return redirect()->route('qbank-typing-test');
    }

    public function show($id)
    {
        $page_title = 'View Typing Test Question';

        $data = QBankTypingTest::where('id',$id)->first();
    

        return view('question::qbank_typing_test.view', compact('data','page_title'));
    }


    public function edit($id)
    {   

        $data = QBankTypingTest::find($id);

        $page_title = 'Update Typing Question Informations';

        return view('question::qbank_typing_test.edit', compact('data','page_title'));
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

        $input = $request->only('typing_question');
        $model = QBankTypingTest::find($id);
        
        $input['typing_question'] = $input['typing_question'][0];

        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");           
        }

        return redirect()->route('qbank-typing-test');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = QBankTypingTest::findOrFail($id);

        DB::beginTransaction();
        try {
            if($model->status =='active'){
                $model->status = 'inactive';
            }else{
                $model->status = 'active';
            }
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('error', "Invalid Request. Please Try Again");
        }
        return redirect()->back();
    }



}