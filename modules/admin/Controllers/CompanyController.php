<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 1:45 PM
 */

namespace Modules\Admin\Controllers;

use Modules\Admin\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Modules\Admin\Helpers\CamelCase;


class CompanyController extends Controller
{
    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pageTitle = "Organization Information";

        $user_role = Session::get('role_title');
        $company_id = Session::get('company_id');

        if($user_role == 'admin' || $user_role == 'super-admin')
        {
            $data = Company::where('status','!=','cancel')->orderBy('id', 'desc')->get();
        }
        else
        {
            $data = Company::where('status','!=','cancel')->where('id',$company_id)->orderBy('id', 'desc')->get();
        }



        return view('admin::company.index', compact('data', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CompanyRequest $request)
    {

        $input= $request->all();
        $input['status']= 'active';

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            Company::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {//print_r($id);exit;
        $pageTitle = 'Organization Information';

        $data = Company::where('id',$id)->first();

        return view('admin::company.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Organization Information';

        $data = Company::where('id',$id)->first();


        return view('admin::company.edit', compact('data', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CompanyRequest $request, $id)
    {

        $model = Company::where('id',$id)->first();
        $input = $request->all();

        /*$company_group_id= $request->get('company_group_id');
        $company_group = CompanyGroup::find($company_group_id);
        $company_group_name = $company_group->group_name;
        $input['company_group_name'] = $company_group_name;*/



        // $company_name = Input::get('company_name');
        // $company_name_upper_case = ucwords($company_name);
        // $input['company_name'] = $company_name_upper_case;

        DB::beginTransaction();
        try {
            $model->update($input);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = Company::findOrFail($id);

        DB::beginTransaction();
        try {
          
            $model->status = 'cancel';
            
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");

        } catch(\Exception $e) {
            DB::rollback();
            //Session::flash('danger',$e->getMessage());
            Session::flash('danger',"Couldn't Delete Successfully. Please Try Again.");
        }
        return redirect()->back();
    }

    public function get_ajax_exchange_rate(){

        $input_curr_id = Input::get('currency_id');

        try{
            $curr_data = Currency::where('id',$input_curr_id)->first();

            if($curr_data){
                return  Response::make($curr_data['exchange_rate']);
            }
        }catch(\Exception $e){
            return  Response::make($e->getMessage());
        }
    }
}