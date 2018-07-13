<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 2/16/2017
 * Time: 4:30 PM
 */

namespace Modules\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class QTypingDetails extends Model
{
    protected $table = 'typing_question_details';

    protected $guarded = [];



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