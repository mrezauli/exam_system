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


class OrganizationDetails extends Model
{
    protected $table = 'organization_application_dtls';

    protected $guarded = [];

    public function relAppOrgMst(){
        return $this->belongsTo('Modules\Application\OrganizationMaster', 'org_app_mst_id');
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