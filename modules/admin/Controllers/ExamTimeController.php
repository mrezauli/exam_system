<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\ExamTime;
use App\Http\Requests;

use DB;
use Session;
use Input;


class ExamTimeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title = "Set Exam Time";

        $typing_exam = ExamTime::where('exam_type','typing_exam')->first();
        $aptitude_exam = ExamTime::where('exam_type','aptitude_exam')->first();

        $data = ExamTime::all();

        return view('admin::exam_time.index', compact('typing_exam', 'aptitude_exam', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ExamTimeRequest $request)
    {


        $typing_exam = ExamTime::where('exam_type','typing_exam')->first();
        $aptitude_exam = ExamTime::where('exam_type','aptitude_exam')->first();

        $typing_exam_data = ['exam_type'=>'typing_exam','exam_time'=>$request->typing_exam_time,'status'=>'active'];
        $aptitude_exam_data = ['exam_type'=>'aptitude_exam','exam_time'=>$request->aptitude_exam_time,'status'=>'active'];

        DB::beginTransaction();
        try {

            $typing_exam->update($typing_exam_data);
            $aptitude_exam->update($aptitude_exam_data);
            DB::commit();
            Session::flash('message', "Successfully Updated");

        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', "Invalid Request. Please Try Again");
        }
        return redirect()->back();
    }





}