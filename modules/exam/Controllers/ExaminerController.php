<?php

/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/17/2017
 * Time: 6:15 PM
 */

namespace Modules\Exam\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Modules\Exam\ExaminerSelection;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Session;
use Illuminate\Support\Facades\Input;
use Excel;
use File;
use Validator;
use PHPExcel;
//use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class ExaminerController extends Controller
{

    public function index()
    {
        $page_title = "Examiners Selection";

        $data = ExaminerSelection::with('exam_code.company','exam_code.designation')->groupBy('exam_code_id')->orderBy('id','desc')->where('status','active')->get();

        return view('exam::examiner.index', compact('data', 'page_title'));
    }

    public function create()
    {

        $page_title = "Select Examiners";

        $data = User::where('status','active')->where('role_id',6)->get();

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','aptitude_test')->where('status','active')->orderBy('id','desc')->take('5')->get()->lists('exam_code_name','id')->all();



        return view('exam::examiner.create',compact('data','page_title','company_list','designation_list','exam_code_list'));
    }

    public function show($id)
    {
        $pageTitle = 'Examiner Informations';
        $data = User::with('relCompany','relRoleInfo')->where('id',$id)->where('role_id',6)->first();

        return view('exam::examiner.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    public function store(Requests\ExaminerRequest $request)
    {

        $input = $request->all();


        if (! isset($input['checkbox'])) {
            Session::flash('message', 'Please select examiners first.');
            return redirect()->route('create-examiner');
        }

        foreach ($input['checkbox'] as $value) {

            $values[] = ['examiner_id' => $value,
                'company_id'=>$input['company_id'],
                'designation_id'=>$input['designation_id'],
                'exam_code_id'=>$input['exam_code_id'],
                'exam_date'=>$input['exam_date'],
                'status' => 'active'];
        }


        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            foreach ($values as $value) {

                ExaminerSelection::create($value);
            }

            DB::commit();
            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
        }   

        return redirect()->route('examiner-selection');
    }

    public function edit($id)
    {

        $data = ExaminerSelection::find($id);

        $questions = User::where('status','active')->where('role_id',6)->get();

        $selected_questions_id = ExaminerSelection::where('exam_code_id',$data->exam_code_id)->lists('examiner_id')->all();

        $page_title = 'Update Examiners Informations';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','aptitude_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();


        return view('exam::examiner.edit', compact('data','page_title','questions','selected_questions_id','company_list','designation_list','exam_code_list'));
    }

    public function update(Requests\ExaminerRequest $request, $id)
    {

        $data = ExaminerSelection::find($id);

        ExaminerSelection::where('exam_code_id',$data->exam_code_id)->where('status','active')->delete();

        return $this->store($request);

    }

    public function delete($id)
    {
        $model = ExaminerSelection::findOrFail($id);

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