<?php

/**
 * Created by PhpStorm.
 * User: shajjad
 * Date: 2/28/2017
 * Time: 10:28 PM
 */
namespace Modules\Application;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrganizationMaster extends Model
{

    protected $table = 'organization_application_mst';

    protected $guarded = [];

    public function company(){
        return $this->belongsTo('Modules\Admin\Company', 'company_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function relAppOrgDtls(){
        return $this->hasOne('Modules\Application\OrganizationDetails', 'org_app_mst_id');
    }

    public function relAttachment(){
        return $this->hasMany('Modules\Application\ApplicationAttachment', 'org_app_mst_id');
    }

    public function relExtraInformation(){
        return $this->hasMany('Modules\Application\TemplateExtraInformation', 'org_app_mst_id','id');
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