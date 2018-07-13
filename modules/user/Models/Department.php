<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 3/2/16
 * Time: 3:46 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $table = 'department';

    protected $fillable = [
        'title','description','slug','status'
    ];

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