<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 12/12/2016
 * Time: 2:01 PM
 */

Route::group(array('prefix'=>'question','modules'=>'question', 'namespace' => 'Modules\question\Controllers','middleware'=>['auth','access_control:question']), function() {

    include 'routes_adnan_question.php';

    Route::get('aptitude', [
        'as' => 'aptitude',
        'uses' => 'AptitudeTestController@index'
    ]);

});