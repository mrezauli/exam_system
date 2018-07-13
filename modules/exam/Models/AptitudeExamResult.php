<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 3/23/2017
 * Time: 3:49 PM
 */

namespace Modules\Exam;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AptitudeExamResult extends Model
{

    protected $table = 'aptitude_exam_result';

    protected $guarded = [];


    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function qsel_apt_test(){
        return $this->belongsTo('Modules\Question\QSelectionAptitudeTest', 'qselection_aptitude_id', 'id');
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