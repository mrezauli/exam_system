<?php
/**
 * Created by PhpStorm.
 * User: shajjad
 * Date: 3/18/2017
 * Time: 12:39 AM
 */

namespace Modules\Exam;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FileDownloadPermission extends Model
{

    protected $table = 'file_download_permission';

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