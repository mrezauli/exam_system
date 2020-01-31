<?php

namespace Modules\Reports\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Helpers\LogFileHelper;
use App\Http\Requests;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Exam\Examination;
use Dompdf\Dompdf;
use Illuminate\Pagination\LengthAwarePaginator;


class ExaminationSummaryReportController extends Controller
{

    public function examination_summary_report(){

        $page_title = 'Examination Summary Report';

        $status = 1;

        $header = $passed_count = $failed_count = $expelled_count = $cancelled_count = $total_pass = $total_fail = $total_count = $bangla_speed = '';

        $exam_dates_string = '';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $total_organizations = '';

        $total_no_of_candidates = '';


        return view('reports::examination_summary_report.index', compact('page_title','company_list','designation_list','status','header','exam_dates_string','passed_count','failed_count','expelled_count','cancelled_count','absent_count','total_count','total_pass','total_fail','bangla_speed','roll_wise','total_organizations','total_no_of_candidates'));




    }



    public function generate_examination_summary_report(Request $request){

        $page_title = 'Examination Summary Report';

        $status = '2';

        $exam_code = Input::get('exam_code');
        $company_id = Input::get('company_id');
        $designation_id = Input::get('designation_id');
        $from_date = Input::get('from_date');
        $to_date = Input::get('to_date');
        $bangla_speed = Input::get('bangla_speed');
        $word_pass_marks = Input::get('word_pass_marks');
        $excel_pass_marks = Input::get('excel_pass_marks');
        $ppt_pass_marks = Input::get('ppt_pass_marks');


        $validator = Validator::make($request->all(), [
            'bangla_speed' => 'integer',
        ]);
        
        // dd($bangla_speed);


        if ($validator->fails()) {

            Session::flash('danger', "Pass Marks must be an integer.");
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }



        $makeComparer = function($criteria) {

          $comparer = function ($first, $second) use ($criteria) {

            foreach ($criteria as $key => $orderType) {
                
        // normalize sort direction

              $orderType = strtolower($orderType);

            if ($first->{$key} < $second->{$key}) {

                return $orderType === "asc" ? -1 : 1;

            } else if ($first->{$key} > $second->{$key}) {

                return $orderType === "asc" ? 1 : -1;

            }
        }

        // all elements were equal
        return 0;

        };

        return $comparer;

        };



        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();




        $model = DB::table( 'user AS u' )
        ->select('u.sl','u.sl as no_of_candidates','u.roll_no','u.id as user_id','u.exam_date','u.exam_type','c.company_name','c.address_one','c.address_two','c.address_three','c.address_four')
                ->leftJoin( 'company as c', 'c.id', '=', 'u.company_id')
                ->whereNotNull('u.exam_date')
                ->orderBy('u.sl');




        if(isset($company_id) && !empty($company_id)){
            $model = $model->where('u.company_id','=',$company_id);
            
        }

        if(isset($designation_id) && !empty($designation_id)){
            $model = $model->where('u.designation_id','=',$designation_id);
        }

        if($from_date == '' && $to_date != ''){

            $model = $model->where('u.exam_date','=',$to_date);
        }

        if($from_date != '' && $to_date == ''){

            $model = $model->where('u.exam_date','=',$from_date);

        }

        if($from_date != '' && $to_date != ''){

            $model = $model->whereBetween('u.exam_date', array($from_date, $to_date));

        }





        $all_model = $model->select(DB::raw('count(*) as no_of_candidates,exam_type,exam_date,company_name'))->groupBy('company_id')->groupBy('exam_type')->groupBy('exam_date')->orderBy('company_name','asc')->orderBy('exam_type')->get();

        //$all_model = $model->get();

        $header = $model->first();

        $exam_dates = collect($model->get())->groupBy('exam_date')->keys()->toArray();

        $exam_dates_string = implode(',',$exam_dates);



        $criteria = ['company_name'=>'asc','exam_type'=>'desc','exam_date'=>'asc'];

        $all_model = collect($all_model);

        $comparer = $makeComparer($criteria);

        $all_model = $all_model->sort($comparer);

  


        $total_organizations = count($all_model->groupBy('company_name')->map(function ($people) {
            return $people->count();
        })->all());



        $total_no_of_candidates = $all_model->reduce(function ($carry,$item) {

            return $carry + $item->no_of_candidates;
        });

        


     
     




       // $model = new LengthAwarePaginator(array_slice($model->toArray(), $offset, $perPage, true), count($model->toArray()), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);


        return view('reports::examination_summary_report.index', compact('page_title','status','company_id','designation_id','exam_date','company_list','designation_list','model','group','word_question_no','excel_question_no','ppt_question_no','all_model','header','all_group','from_date','to_date','exam_dates_string','question_marks','passed_count','failed_count','expelled_count','cancelled_count','absent_count','total_count','bangla_speed','word_pass_marks','excel_pass_marks','ppt_pass_marks','header_all','roll_wise','makeComparer','total_organizations','total_no_of_candidates'));


    }

}