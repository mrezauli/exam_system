<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuPanel extends Model
{
    protected $table = 'menu_panel';

    protected $fillable = [
        'menu_id',
        'menu_type',
        'menu_name',
        'route',
        'parent_menu_id',
        'icon_code',
        'menu_order',
        'status'
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
