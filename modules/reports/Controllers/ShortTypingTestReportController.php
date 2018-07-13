<?php

namespace Modules\Reports\Controllers;

use Modules\Exam\Helpers\StdClass;
use Illuminate\Http\Request;
use App\Helpers\LogFileHelper;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use Session;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Modules\Admin\ExamTime;
use Modules\Exam\Examination;
use Dompdf\Dompdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;



class ShortTypingTestReportController extends Controller
{


    public function typing_test_report(){


        $page_title = 'Typing Test Report (Short)';
        $bangla_speed = $english_speed = $passed_count = $failed_count = $show_count = $remarks = '';


        
        $status = 1;

        $header = '';

        $exam_dates_string = '';

        $model_all = collect([]);

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','typing_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();

        return view('reports::short_typing_test_report.index', compact('page_title','company_list','designation_list','exam_code_list','status','header','exam_dates_string','model_all','bangla_speed','english_speed','passed_count','failed_count','show_count','remarks'));


    }

 


    public function generate_typing_test_report(Request $request){


        $page_title = 'Typing Test Report (Short)';

        $status = 2;


        $exam_code = Input::get('exam_code','');
        $company_id = Input::get('company_id');
        $designation_id = Input::get('designation_id');
        $exam_date_from = Input::get('exam_date_from');
        $exam_date_to = Input::get('exam_date_to');


        $bangla_speed = Input::get('bangla_speed');
        $english_speed = Input::get('english_speed');
        $remarks = Input::get('remarks');




        $validator = Validator::make($request->all(), [
            'bangla_speed' => 'required|integer',
            'english_speed' => 'required|integer',
        ]);


        if ($validator->fails()) {

            Session::flash('danger', "The bangla speed and english speed field must be an integer.");
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }




        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','typing_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();



        $header = DB::table( 'qselection_typing_test AS q' )
                    ->select('e.exam_date','c.company_name','c.address','d.designation_name')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->leftJoin( 'company as c', 'e.company_id', '=', 'c.id')
                    ->leftJoin( 'designation as d', 'e.designation_id', '=', 'd.id');



        $model = DB::table( 'user AS u' )
         ->select('u.id','u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','t.id AS exam_id','u.id as user_id','e.company_id','e.designation_id','e.exam_code_name','e.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.accuracy')
         ->leftJoin( 'exam_code as e', 'e.id', '=', 'u.typing_exam_code_id')         
        ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
        ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
        ->orderBy('u.id');


        if ($exam_code != ''){

            $model = $model->where('e.exam_code_name','=',$exam_code);
            $header = $header->where('e.exam_code_name','=',$exam_code);
            
        }else{

            if(isset($company_id) && !empty($company_id)){

                $model = $model->where('e.company_id','=',$company_id);
            }

            if(isset($designation_id) && !empty($designation_id)){

                $model = $model->where('e.designation_id','=',$designation_id);

            }


            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }

        }

        
        $model_collection = collect($model->get());

        $exam_dates = $model_collection->groupBy('exam_date')->keys()->map(function ($values, $key) {

            return implode('-', array_reverse(explode('-', $values)));

        })->toArray();


        $exam_dates_string = implode(',',$exam_dates);



        $header = $header->first();
                         
        $model = collect($model->get())->groupBy('user_id');



        if (isset($model[''])) {

            foreach ($model[''] as $value) {

               $array = [$value];

               $model->push($array);
           }

       }
        

        unset($model['']);





        function round_to_integer($number){
           
           if (is_integer($number)) {

               return $number;

           }
            
           $parts = explode(".",$number);
        
           if (isset($parts[1]) && (int)$parts[1] >= 5) {

               return $parts[0] + 1;

           }else{

               return $number;

           }

        }


        // dd($model);

        $model->each(function ($values, $key)use($bangla_speed,$english_speed) {

            // $values = collect($values);
            $null_object = StdClass::fromArray();
            

            $grouped_by_exam_type = $values->groupBy('exam_type');
            
            $bangla = $grouped_by_exam_type->get('bangla',[$null_object])[0];

            $english = $grouped_by_exam_type->get('english',[$null_object])[0];
            

            $bangla_time = isset($bangla->exam_time) ? $bangla->exam_time - 1: 1;

            $english_time = isset($bangla->exam_time) ? $bangla->exam_time - 1: 1;


            $bangla_exam_time = $bangla_speed;

            //$english_exam_time = isset($english->exam_time) ? $english->exam_time: 1;
            $english_exam_time = $english_speed;

            $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;

            $bangla_wpm = round($bangla_corrected_words/$bangla_time,1);

            $bangla_wpm = round_to_integer($bangla_wpm);            

            $english_corrected_words = $english->typed_words - $english->inserted_words;

            $english_wpm = round($english_corrected_words/$english_time,1);

            $english_wpm = round_to_integer($english_wpm);            

            $values->total_typing_speed = $bangla_wpm + $english_wpm;



            if(! $values->lists('attended_typing_test')->contains('true')){

                $values->remarks = 'Absent';

            }elseif($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed){

                $values->remarks = 'Pass';

            }else{

                $values->remarks = 'Fail';
                
            }

            // dd($values);

        });   


        $passed = $model->filter(function ($value) {
            return $value->remarks == "Pass";
        })->sortByDesc(function ($values, $key) {
            return $values->total_typing_speed;
        });


        $failed = $model->filter(function ($value) {
            return $value->remarks == "Fail";
        })->sortByDesc(function ($values, $key) {
            return $values->total_typing_speed;
        });


        $absent = $model->filter(function ($value) {
            return $value->remarks == "Absent";
        })->sortByDesc(function ($values, $key) {
            return $values->total_typing_speed;
        });


        $passed_count = $passed->count();

        $failed_count = $failed->count();



        if ($remarks == 'passed') {
            $model = $passed;
            $show_count = 'Pass:' . ' ' . $passed_count;
        }

        if ($remarks == 'failed') {
            $model = $failed;
            $show_count = 'Fail:' . ' ' . $failed_count;

        }

        if ($remarks == 'all') {
            $model = $passed->merge($failed);
        }


        
        $model_all = $model;





        $page = Input::get('page', 1);


        $perPage = 1000;
        $offset = ($page * $perPage) - $perPage;


        $model = new LengthAwarePaginator(array_slice($model->toArray(), $offset, $perPage, true), count($model->toArray()), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);


        return view('reports::short_typing_test_report.index', compact('page_title','status','company_id','designation_id','exam_code','exam_date','exam_time','company_list','designation_list','exam_code_list','model','model_all','bangla_speed','english_speed','remarks','exam_date_from','exam_date_to','header','exam_dates_string','passed_count','failed_count','show_count'));

    }




        public function typing_test_report_pdf($company_id, $designation_id, $exam_date_from, $exam_date_to, $bangla_speed, $english_speed){


            $header = DB::table( 'qselection_typing_test AS q' )
                        ->select('q.exam_date','c.company_name','c.address','d.designation_name')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id')
                        ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id');

                        

            $model = DB::table( 'user AS u' )
                     ->select('u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','t.id AS exam_id','t.user_id','u.company_id','u.designation_id','u.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.accuracy')
                    ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
                    ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->orderBy('u.id'); 




            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('e.company_id','=',$company_id);
                $header = $header->where('e.company_id','=',$company_id);
            }


            if(isset($designation_id) && !empty($designation_id)){
                $model = $model->where('e.designation_id','=',$designation_id);
                $header = $header->where('e.designation_id','=',$designation_id);
            }


            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }


            $model = collect($model->get())->groupBy('user_id');

            
            if (isset($model[''])) {

                foreach ($model[''] as $value) {

                    $array = [$value];

                    $model->push($array);
                }

            }

            unset($model['']);

            $header = $header->first();


            $html = '

    <style>

    th span{
        word-wrap:break-word !important;    
        font-family: Arial, Helvetica, sans-serif;
    }

    tr th span{

    display:inline-block !important;
    margin-top:1px !important;
    margin-left:3px !important;

    }

    .tbl1 {
       margin-left: -20px !important;
       margin-right: -20px !important;

       border: 1px solid #333;
       width: 100%;
    }

    .tbl1 tr th,.tbl1 tr td {
        border: 1px solid #333;
        text-align: center;
        font-size: 13px;
    }

    .tbl1 thead tr th:empty{
        border-right:none !important;
        border-top:none !important;
    }   

    .tbl1 thead:first-child tr,.tbl1 thead tr th.no-border{
        border-bottom:0 !important;
    }

    .no-border span{
        display:block;
        position:absolute;
        top:18px;
        left:auto;
        right:auto;
   
    }

    .report_img{
        height: 100px!important;
        text-align: center!important;
        padding: 15px 10px 18px 10px!important;
    }

    .report_img2{
        height: 10px!important;
        text-align: left!important;
        padding: 5px 2px 8px 2px!important;
    }

    .panel, .panel-body{
        width: 100%;
    }

    .tbl1 thead th{
        padding: 7px 5px;
        font-weight: 500;
        color: #000;
        text-align: center !important;     
    }

    .tbl1 tbody td{
        padding: 5px 3px;
        font-weight: 500;
        color: #000;
        text-align: center !important;    
    }

    .table-name{
        white-space: nowrap;
    }

    td.details table tr td, .dataTable tr:last-child {
        border-bottom: 1px solid #ccc !important;
        background: #e9f7ff;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #fff;
    }

    .header{
        font-size: 16px;
        text-align: center;
        max-width: 250px;
        margin: 5px auto;
    }

    .header-section{
        margin-bottom: 20px;
    }
 

    </style>';

                $html = $html.'

                <div class="header-section">
                    <p class="header">' . $header->company_name . '</p>
                    <p class="header">' . $header->address . '</p>
                    <p class="header">Designation: ' . $header->designation_name . '</p>
                    <p class="header">Exam Date: ' . $header->exam_date . '</p>
                </div>
                <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-responsive no-spacing tbl1">

                    <thead>
                    <tr>
                        <th class="no-border"> <div>SL.</div> </th>
                        <th class="no-border"> <div>Roll No.</div> </th>
                        <th class="no-border table-name-header"> <div>Name</div> </th>
                        <th colspan="4">Bangla in 10 minutes</th>
                        <th colspan="4">English in 10 minutes</th>
                        <th class="no-border"> <div>Remarks</div> </th>
                        
                    </tr>
                    </thead>

                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Typed Word</th>
                        <th>Wrong Word</th>
                        <th>Corrected Word</th>
                        <th>Word/ Minute</th>

                        <th>Typed Word</th>
                        <th>Wrong Word</th>
                        <th>Corrected Word</th>
                        <th>Word/ Minute</th>
                        <th></th>
                    </tr>
                    </thead><tbody>';
                    $i = 0;
                    foreach($model as $values)
                    {

                        $i++; 


                        $values = collect($values);
                        

                        $grouped_by_exam_type = $values->groupBy('exam_type');
                        

                        $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0]:StdClass::fromArray();

                        $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0]:StdClass::fromArray();
                        
                        $bangla_exam_time = isset($bangla->exam_time) ? $bangla->exam_time: 1;

                        $english_exam_time = isset($english->exam_time) ? $english->exam_time: 1;

                        $bangla_wpm = $bangla->typed_words/$bangla_exam_time;

                        $english_wpm = $english->typed_words/$english_exam_time;
                        
                        

                        if(! $values->lists('attended_typing_test')->contains('true')){

                            $remark = 'Absent';

                        }elseif($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed){

                            $remark = 'Pass';

                        }else{

                            $remark = 'Fail';

                        }
                        

                        $html = $html . "
                        <tr class='gradeX'>
                                                   
                            <td>" . $i . "</td>
                            <td>" . $values[0]->roll_no . "</td>
                            <td class='table-name'>" . $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name . "</td>
                            <td>" . (isset($bangla->typed_words) ? $bangla->typed_words : '0') . "</td>
                            <td>" . (isset($bangla->inserted_words) ? $bangla->inserted_words : '0') . "</td>
                            <td>" . ($bangla->typed_words - $bangla->inserted_words) . "</td>
                            <td>" . $bangla->typed_words/$bangla_exam_time . "</td>

                            <td>" . (isset($english->typed_words) ? $english->typed_words : '0') . "</td>
                            <td>" . (isset($english->inserted_words) ? $english->inserted_words : '0') . "</td>
                            <td>" . ($english->typed_words - $english->inserted_words) . "</td>
                            <td>" . $english->typed_words/$english_exam_time . "</td>
                            <td>" . $remark . "</td>

                           
                        </tr>";
                   }


                $html = $html.'</tbody></table>';
            

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream('exam_system.pdf',array('Attachment'=>0));


        }




        public function typing_test_details($bangla_exam_id ,$english_exam_id){

            $page_title= 'Typing Test Information';

            $bangla_text = Examination::findOrNew($bangla_exam_id);
            $english_text = Examination::findOrNew($english_exam_id);

            $user_id = empty($bangla_text->user_id) ? $english_text->user_id : $bangla_text->user_id; 


            $user = User::with('relCompany','relDesignation')->find($user_id);


            return view('reports::short_typing_test_report.typing_test_details', compact('page_title','bangla_text','english_text','user'));

        }

        public function edit_typing_test_details($id){

           
            // $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name
                                $data = User::with('typing_test_result','typing_exam_code')->where('id',$id)->first(); 
                                


                                $name = trim($data->username . ' ' . $data->middle_name . ' ' . $data->last_name);

                                $exam_code = $data->typing_exam_code->exam_code_name;

                                $roll_no = $data->roll_no;



                                $bangla = $data->typing_test_result()->where('exam_type','bangla')->first();
                                $english = $data->typing_test_result()->where('exam_type','english')->first();
                                
                                // dd($bangla);

                                // $bangla_exam_id = $bangla->exam_id;

                                // $bangla_typed_words = $bangla->typed_words;

                                // $bangla_wrong_words = $bangla->inserted_words;

                                // $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;


                                // $english_typed_words = $english->typed_words;

                                // $english_wrong_words = $english->inserted_words;

                                // $english_corrected_words = $english->typed_words - $english->inserted_words;

                                // $data = collect(['bangla_typed_words'=>$bangla_typed_words,'id'=>'3','bangla_exam_id'=>$bangla_exam_id]);


                                  

            // $user_id = empty($bangla_text->user_id) ? $english_text->user_id : $bangla_text->user_id; 


            // $user = User::with('relCompany','relDesignation')->find($user_id);

                                // dd($dataz);
           return view('reports::short_typing_test_report.edit_typing_test_details', compact('data','bangla','english','name','exam_code','roll_no'));

        }

        public function update_typing_test_details(Requests\ExamRequest $request, $id){

            // dd($request->all());

            $bangla = collect($request->only('bangla_total_words','bangla_typed_words','bangla_corrected_words'));

            $english = collect($request->only('english_total_words','english_typed_words','english_corrected_words'));

            // dd($bangla);


            $bangla_input = $bangla->keys()->map(function ($item, $key) {
            
               return str_replace("bangla_","",$item);
               
           })->all();

            

            $bangla_input = array_combine($bangla_input,$bangla->all());

            $bangla_data['typed_words'] = $bangla_input['typed_words'];

            $bangla_data['deleted_words'] = $bangla_input['total_words'] - $bangla_input['corrected_words'];

            $bangla_data['inserted_words'] = $bangla_input['typed_words'] - $bangla_input['corrected_words'];




            $english_input = $english->keys()->map(function ($item, $key) {
            
               return str_replace("english_","",$item);
               
           })->all();



            $english_input = array_combine($english_input,$english->all());

            $english_data['typed_words'] = $english_input['typed_words'];

            $english_data['deleted_words'] = $english_input['total_words'] - $english_input['corrected_words'];

            $english_data['inserted_words'] = $english_input['typed_words'] - $english_input['corrected_words'];
            
        

            // dd($input);


            $bangla_exam_id = $request->only('bangla_exam_id');

            $english_exam_id = $request->only('english_exam_id');

           

            $bangla_model = Examination::where('id',$bangla_exam_id)->first();

            $english_model = Examination::where('id',$english_exam_id)->first();

            // $input = $request->all();
            // dd($model);
            /*$company_group_id= $request->get('company_group_id');
            $company_group = CompanyGroup::find($company_group_id);
            $company_group_name = $company_group->group_name;
            $input['company_group_name'] = $company_group_name;*/



            // $company_name = Input::get('company_name');
            // $company_name_upper_case = ucwords($company_name);
            // $input['company_name'] = $company_name_upper_case;

            DB::beginTransaction();
            try {
                $bangla_model->update($bangla_data);
                $english_model->update($english_data);
                DB::commit();
                Session::flash('message', "Successfully Updated");
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
            }
            return redirect()->back();

            return redirect()->back();

            return view('reports::short_typing_test_report.update_typing_test_details', compact($id));

        }

        public function typing_test_manual_checking_details($bangla_exam_id, $english_exam_id){

            $page_title= 'Typing Test Information';

            $bangla_text = Examination::findOrNew($bangla_exam_id);
            $english_text = Examination::findOrNew($english_exam_id);

            $user_id = empty($bangla_text->user_id) ? $english_text->user_id : $bangla_text->user_id; 
            

            $user = User::with('relCompany','relDesignation')->find($user_id);


            return view('reports::short_typing_test_report.typing_test_manual_checking_details', compact('page_title','bangla_text','english_text','user'));

        }



        public function all_graph_report(){

            $page_title= 'All Graph Report';

            
            $exam_code = Input::get('exam_code');
            $company_id = Input::get('company_id');
            $designation_id = Input::get('designation_id');
            $exam_date_from = Input::get('exam_date_from');
            $exam_date_to = Input::get('exam_date_to');
            $bangla_speed = Input::get('bangla_speed');
            $english_speed = Input::get('english_speed');
            $remarks = Input::get('remarks');




            $header = DB::table( 'qselection_typing_test AS q' )
                        ->select('e.exam_date','c.company_name','c.address','d.designation_name')
                        ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id');
                        


            $model = DB::table( 'user AS u' )
                     ->select('u.roll_no','u.roll_no','u.started_exam','u.attended_typing_test','t.id AS exam_id','t.user_id','e.company_id','e.designation_id','e.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.original_text','t.answered_text')
                    ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
                    ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->orderBy('u.id'); 


        if ($exam_code != ''){

            $model = $model->where('e.exam_code_name','=',$exam_code);
            $header = $header->where('e.exam_code_name','=',$exam_code);

        }else{

            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('e.company_id','=',$company_id);
                $header = $header->where('e.company_id','=',$company_id);
            }

            if(isset($designation_id) && !empty($designation_id)){
                $model = $model->where('e.designation_id','=',$designation_id);
                $header = $header->where('e.designation_id','=',$designation_id);
            }

            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }


        }

            $model = collect($model->get())->groupBy('user_id');

            unset($model['']);

            $model->each(function ($values, $key)use($bangla_speed,$english_speed) {

                // $values = collect($values);
                $null_object = StdClass::fromArray();
                

                $grouped_by_exam_type = $values->groupBy('exam_type');
                
                $bangla = $grouped_by_exam_type->get('bangla',[$null_object])[0];

                $english = $grouped_by_exam_type->get('english',[$null_object])[0];
                

                
                $exam_time = isset($bangla->exam_time) ? $bangla->exam_time: 1;
                $bangla_exam_time = $bangla_speed;

                //$english_exam_time = isset($english->exam_time) ? $english->exam_time: 1;
                $english_exam_time = $english_speed;

                $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;


                // dd($bangla_exam_time);

                $bangla_wpm = round($bangla_corrected_words/$exam_time,3);

                $english_corrected_words = $english->typed_words - $english->inserted_words;

                $english_wpm = round($english_corrected_words/$exam_time,3);

                $values->total_typing_speed = $bangla_wpm + $english_wpm;



                if(! $values->lists('attended_typing_test')->contains('true')){

                    $values->remarks = 'Absent';

                }elseif($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed){

                    $values->remarks = 'Pass';

                }else{

                    $values->remarks = 'Fail';
                    
                }

                // dd($values);

            });   


            $passed = $model->filter(function ($value) {
                return $value->remarks == "Pass";
            })->sortByDesc(function ($values, $key) {
                return $values->total_typing_speed;
            });


            $failed = $model->filter(function ($value) {
                return $value->remarks == "Fail";
            })->sortByDesc(function ($values, $key) {
                return $values->total_typing_speed;
            });


            $absent = $model->filter(function ($value) {
                return $value->remarks == "Absent";
            })->sortByDesc(function ($values, $key) {
                return $values->total_typing_speed;
            });


            if ($remarks == 'passed') {
                $model = $passed;
            }

            if ($remarks == 'failed') {
                $model = $failed;
            }

            if ($remarks == 'all') {
                $model = $passed->merge($failed)->merge($absent);
            }


            return view('reports::short_typing_test_report.all_graph_report', compact('page_title','model','user'));

        }


















}