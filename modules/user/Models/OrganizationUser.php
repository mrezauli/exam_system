<?php


namespace Modules\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationUser extends Model
{
    protected $table = 'organization_user_mstr';

    protected $guarded = [];



    public function user(){
        return $this->hasOne('App\User', 'created_by', 'id');
    }

    public function company(){
        return $this->hasOne('Modules\Admin\Company', 'company_id', 'id');
    }

    public function organization_user_dtls(){
        return $this->hasMany('Modules\User\OrganizationUserDtls', 'organization_exam_id', 'id');
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