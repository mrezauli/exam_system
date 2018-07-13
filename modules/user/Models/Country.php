<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 2/15/16
 * Time: 11:41 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;


class Country extends Model
{

    protected $table = 'country';

    protected $hidden = ['code', 'title'];

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