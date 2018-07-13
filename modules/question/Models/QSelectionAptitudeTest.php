<?php

namespace Modules\Question;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QSelectionAptitudeTest extends Model
{
    protected $table = 'qselection_aptitude_test';

    protected $guarded = [];


    public function question_set(){
        return $this->belongsTo('Modules\Question\QuestionPaperSet', 'question_set_id', 'id');
    }

    public function qbank_aptitude_question(){
        return $this->belongsTo('Modules\Question\QBankAptitudeTest', 'qbank_aptitude_id', 'id');
    }


    public function company(){
        return $this->belongsTo('Modules\Admin\Company', 'company_id', 'id');
    }

    public function designation(){
        return $this->belongsTo('Modules\Admin\Designation', 'designation_id', 'id');
    }

    public function exam_code(){
        return $this->belongsTo('Modules\Admin\ExamCode', 'exam_code_id', 'id');
    }

    public function file_download(){
        return $this->hasMany('Modules\Exam\FileDownloadPermission', 'qselection_aptitude_id', 'id');
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