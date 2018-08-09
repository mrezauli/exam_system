<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Question\Controllers;
require public_path() . '/assets/cloudconvert/vendor/autoload.php';
use COM;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Modules\Question\QBankAptitudeTest;
use App\Http\Requests;
use DB;
use URL;
use Session;
use Input;
use \CloudConvert\Api;
use \CloudConvert\Process;
use GuzzleHttp\Client as GuzzleClient;


class QBankAptitudeTestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */


    public function index()
    {


 
        $page_title = "Aptitude Test Question";
        $ms_word_data = QBankAptitudeTest::where('question_type','word')->orderBy('id','desc')->where('status','active')->get();
        $ms_excel_data = QBankAptitudeTest::where('question_type','excel')->orderBy('id','desc')->where('status','active')->get();
        $ms_ppt_data = QBankAptitudeTest::where('question_type','ppt')->orderBy('id','desc')->where('status','active')->get();
        //Session::flash('tab','word');
        return view('question::qbank_aptitude_test.index', compact('ms_word_data','ms_excel_data','ms_ppt_data', 'page_title'));

    }


    public function create_ms_word()
    {

        $page_title = "Aptitude Test Question";
        return view('question::qbank_aptitude_test.create-ms-word',compact('page_title'));

    }
    public function create_ms_excel()
    {

        $page_title = "Aptitude Test Question";
        return view('question::qbank_aptitude_test.create-ms-excel',compact('page_title'));

    }
    public function create_ms_ppt()
    {

        $page_title = "Aptitude Test Question";
        return view('question::qbank_aptitude_test.create-ms-ppt',compact('page_title'));

    }

    public function store(Requests\QBankAptitudeTestRequest $request)
    {
        //exit("working");
        $orginal_file_path = '';
        $image_file_path = '';
        $input_format = '';
        $input = $request->except('file');


        if($input['question_type'] == 'word'){

            $orginal_folder_path = public_path() . '/question_files/org_doc_files';
            $image_folder_path = public_path() . '/question_files/image_doc_files';
            $orginal_relative_path = 'question_files/org_doc_files';
            $image_relative_path = 'question_files/image_doc_files';
            $input_format = 'docx';

        }elseif($input['question_type'] == 'excel') {

            $orginal_folder_path = public_path() . '/question_files/org_excel_files';
            $image_folder_path = public_path() . '/question_files/image_excel_files';
            $orginal_relative_path = 'question_files/org_excel_files';
            $image_relative_path = 'question_files/image_excel_files';
            $input_format = 'xlsx';

        }elseif($input['question_type'] == 'ppt') {

            $orginal_folder_path = public_path() . '/question_files/org_ppt_files';
            $image_folder_path = public_path() . '/question_files/image_ppt_files';
            $orginal_relative_path = 'question_files/org_ppt_files';
            $image_relative_path = 'question_files/image_ppt_files';
            $input_format = 'pptx';

        }


        $files = $request->file('file');


        $client = new \GuzzleHttp\Client(['verify' => public_path() . '/assets/cacert.pem.txt' ]);


        //$api = new Api("jE0BIWAbAEdn90a5rNz52EcyR9eQQp6j68LSOKkGBojP8-FOdoQiTP42LuQvxh9OEyxmJATizW47Cf59iw-X_g");

        $api = new Api("Lyu0UGEhGNeOB5A34_KA1luyidAvMqdTcR19bY3iFSLGAGYa_qfZe5MgoZUCysZCSaEfWruycr8c33bCvX4EwA",$client);
        $random_number = rand(100, 700);

        foreach ($files as $file) {
             
            $filename = $file->getClientOriginalName();
            $filename_without_extension = explode('.', $filename)[0];
            $file_extension = explode('.', $filename)[1];

            //add random number to each file and create relative paths
            $generated_original_file_name = $filename_without_extension . '-' . $random_number . '.' . $file_extension;
            $generated_image_file_name = $filename_without_extension . '-' . $random_number . '.html';

            $orginal_file_path = $orginal_folder_path . '/' . $generated_original_file_name;
            $image_file_path = $image_folder_path . '/' . $generated_image_file_name;
            $orginal_relative_file_path = $orginal_relative_path . '/' . $generated_original_file_name;
            $image_relative_file_path = $image_relative_path . '/' . $generated_image_file_name;
            
// dd($generated_image_file_name);

            // $file->move($orginal_folder_path,$generated_original_file_name);

            $file->move($image_folder_path,$generated_image_file_name);


            // dd($orginal_file_path);
            // $api->convert([
            //         'inputformat' => $input_format,
            //         'outputformat' => 'html',
            //         'input' => 'upload',
            //         'file' => fopen('file://' . $orginal_file_path, 'r'),
            //     ])
            //     ->wait()
            //     ->download('file://' . $image_file_path);




            // $word = new COM("word.application") or die("ERROR: Unable to instantiate Word");

            // echo "Loaded Word, version {$word->Version}\
            // ";

            // //bring it to front
            // $word->Visible = 1;

            // //Set $FilePath and $DocFileName
            // //$FilePath = "D:\saju2";
            // $FilePath = "/var/www/html/rems-test";
            // $DocFilename = $orginal_file_path;

            // $stat = $word->Documents->Open(realpath("$DocFilename")) or die ("ERROR: Could not open Word Doc");

            // $word->Documents[1]->SaveAs("$FilePath", 17);
            // $word->Documents[1]->Close();

            // //closing word
            // $word->Quit();

            // //free the object
            // $word = null;




                $values[] = ['title' => $input['title'],
                          'question_type' => $input['question_type'],
                          'original_file_path'=>$orginal_relative_file_path,
                          'image_file_path'=>$image_relative_file_path,
                          'status' => 'active'];

        }





        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            foreach ($values as $value) {
    
                QBankAptitudeTest::create($value);
    
            }

            DB::commit();
            Session::flash('tab',$input['question_type']);
            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
        }

        return redirect()->route('qbank-aptitude-test');
    }

    public function show($id)
    {

//return file_get_contents(URL::asset('question_files/image_doc_files/rots-660.html'));
//return 'ddd.html';
        $page_title = 'View Aptitude Speed Test Question';

        $question = QBankAptitudeTest::where('id',$id)->first();


        return view('question::qbank_aptitude_test.view', compact('question','page_title'));
    }


    public function edit($id)
    {   

        $data = QBankAptitudeTest::find($id);

        $page_title = 'Update Aptitude Question Informations';

        return view('question::qbank_aptitude_test.edit', compact('data','page_title'));
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

        $input = $request->only('aptitude_question');
        $model = QBankAptitudeTest::find($id);
        
        $input['aptitude_question'] = $input['aptitude_question'][0];

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

        return redirect()->route('qbank-aptitude-test');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = QBankAptitudeTest::findOrFail($id);

        $question_found_in_pivot_table = DB::table( 'question_set_qbank_aptitude_test' )
                                            ->where( 'qbank_aptitude_id', $id)
                                            ->first();
                            
         
        if ($question_found_in_pivot_table) {

            Session::flash('error', "A question paper has already been created with this question.");
            return redirect()->back();

        }


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