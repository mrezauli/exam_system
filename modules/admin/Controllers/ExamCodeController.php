<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Modules\Exam\Examination;
use Modules\Exam\AptitudeExamResult;
use App\Http\Requests;
use DB;
use Session;
use Input;


class ExamCodeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title = "Generate Exam Code";
        $disabled = 'disabled';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $data = ExamCode::with('Company','Designation')->where('status', 'active')->orderBy('id', 'desc')->get();
        return view('admin::exam_code.index', compact('data', 'page_title','disabled','company_list','designation_list'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

        $page_title = "Generate Exam Code";

        $data = ExamCode::where('status','active')->orderBy('id','desc')->get();

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();


        return view('admin::exam_code.create',compact('data','page_title','company_list','designation_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ExamCodeRequest $request)
    {

        $input = $request->all();

        $exam_date_array = explode('-', $input['exam_date']);

        $time = (string)time();

        $exam_code = $exam_date_array[0][2] . $exam_date_array[0][3] . $exam_date_array[1] . $exam_date_array[2] . rand(10,99);

        $exam_code_found = ExamCode::where('exam_code_name',$exam_code)->where('status','active')->first();

        $previous_data_found = ExamCode::where('company_id',$input['company_id'])->where('designation_id',$input['designation_id'])->where('exam_date',$input['exam_date'])->where('exam_type',$input['exam_type'])->where('shift',$input['shift'])->where('status','active')->first();


        $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);



        if ($exam_date_error) {

            Session::flash('danger', "Exam date must be equal or greater than current date.");
            return redirect()->back()->withInput();

        }

        if ($exam_code_found) {

            Session::flash('danger', "Couldn't Generate Exam Code Successfully. Please Try Again.");
            return redirect()->back()->withInput();

        }

        if ($previous_data_found) {

            Session::flash('danger', "This Shift already has been Booked, Please Select another shift for this Organization.");
            return redirect()->back()->withInput();

        }


        // dd($input);


        $input['exam_code_name'] = $exam_code;
        $input['status'] = 'active';

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            ExamCode::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
            return redirect()->back()->withInput();
    
        }

        return redirect()->route('exam-code');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {//print_r($id);exit;
        $page_title = 'View Name of the Post';
        $data = ExamCode::where('id',$id)->first();

        return view('admin::exam_code.view', ['data' => $data, 'page_title'=> $page_title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Update Name of the Post';
        $disabled = '';
        $data = ExamCode::where('id',$id)->first();

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        return view('admin::exam_code.edit', compact('data','company_list','designation_list', 'page_title','disabled'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ExamCodeRequest $request, $id)
    {

        $model = ExamCode::where('id',$id)->first();
        $input = $request->all();


        $typing_exam_occured = Examination::whereHas('qselection_typing_test', function ($query) use ($id){
            $query->where('exam_code_id',$id)
                  ->where('status','active');
        })->first();


        $aptitude_exam_occured = AptitudeExamResult::whereHas('qsel_apt_test', function ($query) use ($id){
            $query->where('exam_code_id',$id)
                  ->where('status','active');
        })->first();


        $search_previous_data = ExamCode::where('company_id',$input['company_id'])->where('designation_id',$input['designation_id'])->where('exam_date',$input['exam_date'])->where('exam_type',$input['exam_type'])->where('shift',$input['shift'])->where('status','active')->first();

        $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);




        if ($exam_date_error) {

            Session::flash('danger', "Exam date must be equal or greater than current date.");
            return redirect()->back()->withInput();

        }


        if (isset($search_previous_data) && $search_previous_data->id != $id)  {
            
            Session::flash('danger', "This Shift already has been Booked, Please Select another shift for this Organization.");
            return redirect()->back()->withInput();

        }

        if (! empty($typing_exam_occured) || ! empty($aptitude_exam_occured)) {

          Session::flash('danger', "You can't update this row anymore because an exam has already been occured.");
          return redirect()->route('exam-code');

        }



        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', "Invalid Request. Please Try Again");
            return redirect()->back()->withInput();
        }

        return redirect()->route('exam-code');
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {


        $typing_exam_occured = Examination::whereHas('qselection_typing_test', function ($query) use ($id){
            $query->where('exam_code_id',$id)
                  ->where('status','active');
        })->first();


        $aptitude_exam_occured = AptitudeExamResult::whereHas('qsel_apt_test', function ($query) use ($id){
            $query->where('exam_code_id',$id)
                  ->where('status','active');
        })->first();



        if (! empty($typing_exam_occured) || ! empty($aptitude_exam_occured)) {

          Session::flash('danger', "You can't delete this row anymore because an exam has already been occured.");
          return redirect()->route('exam-code');

        }


        $model = ExamCode::findOrFail($id);
       
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajax_get_exam_code()
    {

         $exam_code = DB::table('exam_code')->where('id',$_POST['exam_code_id'])->first();

         return json_encode($exam_code);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajax_get_exam_process_code()
    {

       $exam_code = DB::table('exam_code')->where('id',$_POST['exam_code_id'])->first();

       $exam_number = DB::table('user AS u')
                ->select('u.exam_number')
                ->where('role_id',4)
                ->where('company_id',$exam_code->company_id)
                ->where('designation_id',$exam_code->designation_id)
                ->max('exam_number');

        if($exam_code->exam_type == 'typing_test')
        {

            $sl_no = DB::table('user AS u')
                ->select('u.sl')
                ->where('role_id',4)
                ->where('company_id',$exam_code->company_id)
                ->where('designation_id',$exam_code->designation_id)
                ->where('exam_number',$exam_number)
                ->where('typing_status','inactive')
                ->where('attended_typing_test',null)
                //->where('typing_exam_code_id',null)
                //->where('aptitude_exam_code_id',null)
                ->orderBy('sl','asc')
                ->get();

            return json_encode([$exam_code,$sl_no]);

        }
        elseif($exam_code->exam_type == 'aptitude_test')
        {
            $sl_no = DB::table('user AS u')
                ->select('u.sl')
                ->where('role_id',4)
                ->where('company_id',$exam_code->company_id)
                ->where('designation_id',$exam_code->designation_id)
                ->where('exam_number',$exam_number)
                ->where('aptitude_status','inactive')
                ->where('attended_aptitude_test',null)
                //->where('typing_exam_code_id',null)
                //->where('aptitude_exam_code_id',null)
                ->orderBy('sl','asc')
                ->get();

            return json_encode([$exam_code,$sl_no]);

        }

       /*$sl_no = DB::table( 'user AS u' )
                   ->select('u.sl')
                   ->where('role_id',4)
                   ->where('company_id',$exam_code->company_id)
                   ->where('designation_id',$exam_code->designation_id)
                   ->where('exam_code_id','!=',$exam_code->id)
                   ->where('exam_type',$exam_code->exam_type)
                   ->orderBy('sl','asc')
                   ->get();

        $count = count($sl_no);


        if( $count>0 )
        {
            return json_encode([$exam_code,$sl_no]);
        }
        else
        {
            $sl_no = DB::table( 'user AS u' )
                ->select('u.sl')
                ->where('role_id',4)
                ->where('company_id',$exam_code->company_id)
                ->where('designation_id',$exam_code->designation_id)
                ->where('exam_code_id','!=',$exam_code->id)
                ->orderBy('sl','asc')
                ->get();

            //dd($sl_no);

            return json_encode([$exam_code,$sl_no]);
        }*/


    }


    public function ajax_get_total_candidate_number()
    {


       $exam_code = DB::table('exam_code')->where('id',$_POST['exam_code_id'])->first();



       if($exam_code->exam_type == 'typing_test')
       {

           $total_candidate_number = DB::table('user AS u')
                           ->select('u.sl')
                           ->where('role_id',4)
                           ->where('company_id',$exam_code->company_id)
                           ->where('designation_id',$exam_code->designation_id)
                           ->where('typing_status','inactive')
                           ->where('attended_typing_test',null)
                           ->orderBy('sl','asc')
                           ->count();


       }elseif($exam_code->exam_type == 'aptitude_test')
       {

        $total_candidate_number = DB::table('user AS u')
                        ->select('u.sl')
                        ->where('role_id',4)
                        ->where('company_id',$exam_code->company_id)
                        ->where('designation_id',$exam_code->designation_id)
                        ->where('aptitude_status','inactive')
                        ->where('attended_aptitude_test',null)
                        ->orderBy('sl','asc')
                        ->count();

       }


       return json_encode([$total_candidate_number]);

    }



}