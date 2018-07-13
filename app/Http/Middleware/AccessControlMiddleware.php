<?php

namespace App\Http\Middleware;

use Closure;

class AccessControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    protected $module;


    public function allow_routes($page,$role_id, $routes)
    {
       

        $user = auth()->user();

        if (! $user) {
            return false;
        }

        $current_route = \Route::current()->getName();



        if ($page == $this->module && $role_id == $user->role_id) {

                if (! in_array($current_route, $routes)) {

                    abort(404,'Not Authorized.');

                }

        }

    }




    public function deny_routes($page,$role_id, $routes)
    {
       

        $user = auth()->user();

        if (! $user) {
            return false;
        }

        $current_route = \Route::current()->getName();



        if ($page == $this->module && $role_id == $user->role_id) {

                if (in_array($current_route, $routes)) {

                    abort(404,'Not Authorized.');

                }

        }

    }







    public function allow_controllers($page,$role_id, $controllers)
    {


        $user = auth()->user();

        $current_controller = \Route::current()->getAction()['controller'];

        $array = explode('@', $current_controller);

        $array = explode('\\', $array[0]);

        $current_controller = array_pop($array);


        if ($page == $this->module && $role_id == $user->role_id && $controllers != $current_controller) {

             if (! in_array($current_controller, $controllers)) {

                    abort(404,'Not Authorized.');

                }

        }

    }





    public function handle($request, Closure $next, $module)
    {


        $this->module = $module;



        $this->allow_routes('admin',4, []);
        $this->allow_routes('admin',5, ['company','view-company','edit-company','update-company']);
        $this->allow_routes('admin',6, ['ajax-get-exam-code']);



        $this->allow_routes('application',4, []);
        $this->allow_routes('application',5, ['organization-file-upload','received-email-organization-file-upload','excel-format','create-organization-file-upload','create-organization-template','ajax-organization-print-preview-data','store-organization-file-upload','store-organization-template']);
        $this->allow_routes('application',6, []);




        $this->allow_controllers('exam',4,['TypingTestController','AptitudeTestController']);
        $this->allow_controllers('exam',5,[]);
        $this->allow_controllers('exam',6, ['AnswerSheetCheckingController']);





        $this->allow_routes('question',4, []);
        $this->allow_routes('question',5, []);
        $this->allow_routes('question',6, []);



        $this->deny_routes('reports',1, ['edit-typing-test-details','update-typing-test-details']);
        $this->allow_routes('reports',4, []);
        $this->allow_routes('reports',5, []);
        $this->allow_routes('reports',6, []);




        $this->allow_routes('user',4, ['user-logout']);
        $this->allow_routes('user',5, ['user-logout']);
        $this->allow_routes('user',6, ['user-logout','user-list','show-user','edit-user','update-user']);






        return $next($request);
    }
}
 