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



class TemplateAttachment extends Model
{

    protected $table = 'template_attachment';

    protected $guarded = [];

    public function relAppOrgDtls(){
        return $this->belongsTo('Modules\Application\OrganizationDetails', 'org_app_dtls_id');
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