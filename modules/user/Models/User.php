<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'username','middle_name','last_name','email','password','auth_key','access_token','csrf_token','ip_address','company_id','department_id','last_visit','role_id','expire_date','status','remember_token', 'duplicate_lead'
    ];*/

    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    //check permission
    public function can_access($permission = null){

        return !is_null($permission)  && $this->checkPermission($permission);
    }

    //check if the permission matches with any permission user has
    protected function checkPermission($perm){
        $perm = str_replace(":","", $perm );

        $permissions = $this->getAllPermissionFromAllRoles();
        $permissionArray = is_array($perm) ? $perm : array($perm);


        return array_intersect($permissions, $permissionArray);
    }


//Get All permission slugs from all permission of all roles

    protected function getAllPermissionFromAllRoles(){
        $permissionsArray = [];
        $permissions = $this->relRole->load('permissions')->fetch('permissions')->toArray();

        return array_map('strtolower', array_unique(array_flatten(array_map(function($permission){
            return array_pluck($permission, 'route_url');

        }, $permissions))));
    }




    public function relCompany(){
        return $this->belongsTo('Modules\Admin\Company', 'company_id', 'id');
    }

    public function relDesignation(){
        return $this->belongsTo('Modules\Admin\Designation', 'designation_id', 'id');
    }

    public function typing_exam_code(){
        return $this->belongsTo('Modules\Admin\ExamCode', 'typing_exam_code_id', 'id');
    }

    public function aptitude_exam_code(){
        return $this->belongsTo('Modules\Admin\ExamCode', 'aptitude_exam_code_id', 'id');
    }

    public function typing_test_result(){
        return $this->hasMany('Modules\Exam\Examination', 'user_id', 'id');
    }

    public function aptitude_test_result(){
        return $this->hasMany('Modules\Exam\AptitudeExamResult', 'user_id', 'id');
    }



/*This function only used for getting role information*/
    public function relRoleInfo(){
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function relRole(){
        return $this->belongsToMany('App\Role');
    }

    public function relDepartment(){
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }

    public function relPoppingEmail(){
        return $this->hasMany('Modules\Admin\PoppingEmail');
    }

    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'

    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = Auth::user()->id;
            }
        });
    }
}
