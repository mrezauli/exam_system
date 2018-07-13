<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/22/2017
 * Time: 12:37 PM
 */

namespace Modules\Exam;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExamProcess extends Model
{

    protected $table = 'examination_process';

    protected $guarded = [];


    public function company(){
        return $this->belongsTo('Modules\Admin\Company', 'company_id', 'id');
    }

    public function designation(){
        return $this->belongsTo('Modules\Admin\Designation', 'designation_id', 'id');
    }

    public function exam_code(){
        return $this->belongsTo('Modules\Admin\ExamCode', 'exam_code_id', 'id');
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