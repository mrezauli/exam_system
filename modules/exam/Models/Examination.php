<?php


namespace Modules\Exam;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Exam\Helpers\CustomCollection;

class Examination extends Model
{
    protected $table = 'typing_exam_result';

    protected $guarded = [];



    public function user(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function qselection_typing_test(){
        return $this->belongsTo('Modules\Question\QSelectionTypingTest', 'qselection_typing_id', 'id');
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



    public function newCollection(array $models = Array())
        {
            return new CustomCollection($models);
        }



}