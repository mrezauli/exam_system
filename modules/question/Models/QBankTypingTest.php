<?php


namespace Modules\Question;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QBankTypingTest extends Model
{
    protected $table = 'qbank_typing_test';

    protected $guarded = [];

    public function qselection_typing_question(){
            return $this->hasOne('Modules\Question\QSelectionTypingTest', 'qselection_typing_id', 'id');
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