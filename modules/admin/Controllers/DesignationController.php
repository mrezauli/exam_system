<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Designation;
use App\Http\Requests;

use DB;
use Session;
use Input;


class DesignationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title = "Name of the Post";
        $title = Input::get('title');
        $disabled = 'disabled';

        $data = Designation::where('designation_name', 'LIKE', '%'.$title.'%')->orderBy('id', 'desc')->where('status','!=','cancel')->get();
        return view('admin::designation.index', compact('data', 'page_title','disabled'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\DesignationRequest $request)
    {

        $input = $request->all();
        $input['status'] = 'active';
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            Designation::create($input);
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
        $page_title = 'View Name of the Post';
        $data = Designation::where('id',$id)->first();

        return view('admin::designation.view', ['data' => $data, 'page_title'=> $page_title]);
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
        $data = Designation::where('id',$id)->first();
        return view('admin::designation.edit', compact('data', 'page_title','disabled'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\DesignationRequest $request, $id)
    {
        $model = Designation::where('id',$id)->first();
        $input = $request->all();


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
        $model = Designation::findOrFail($id);
       
        DB::beginTransaction();
        try {

            $model->status = 'cancel';
           
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