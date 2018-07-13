<?php

namespace Modules\Question;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QBankAptitudeTest extends Model
{
    protected $table = 'qbank_aptitude_test';

    protected $guarded = [];


    public function qselection_aptitude_question(){
        return $this->hasOne('Modules\Question\QSelectionAptitudeTest', 'qbank_aptitude_id', 'id');
    }

    public function question_sets(){
        return $this->belongsToMany('Modules\Question\QuestionPaperSet', 'question_set_qbank_aptitude_test','question_set_id', 'qbank_aptitude_id');
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