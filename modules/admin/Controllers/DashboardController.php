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


class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       return view('admin::dashboard.index');
    }

}