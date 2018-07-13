<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 2/15/2017
 * Time: 4:12 PM
 */

namespace Modules\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QTypingMaster extends Model
{
    protected $table = 'typing_question_master';

    protected $guarded = [];

    public function company(){
        return $this->belongsTo('Modules\Admin\Company', 'company_id', 'id');
    }

    public function designation(){
        return $this->belongsTo('Modules\Admin\Designation', 'designation_id', 'id');
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