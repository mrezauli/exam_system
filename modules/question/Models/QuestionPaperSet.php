<?php

namespace Modules\Question;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionPaperSet extends Model
{
    protected $table = 'question_paper_set';

    protected $guarded = [];

    public function aptitude_questions(){
        return $this->belongsToMany('Modules\Question\QBankAptitudeTest', 'question_set_qbank_aptitude_test', 'question_set_id', 'qbank_aptitude_id')->withPivot('question_mark','status')->withTimestamps();;
    }


    public function qselection_aptitude_test(){
        return $this->hasMany('Modules\Question\QSelectionAptitudeTest', 'question_set_id', 'id');
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