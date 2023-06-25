<?php

use App\Jobs\NewLineCountRemoveJob;
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 12/12/2016
 * Time: 2:01 PM
 */

Route::group(array('prefix'=>'exam','modules'=>'exam', 'namespace' => 'Modules\exam\Controllers','middleware'=>['auth','access_control:exam']), function() {

    include 'routes_adnan_crm.php';

    Route::get('aptitude-exams', [
        'as' => 'aptitude-exams',
        'uses' => 'AptitudeTestController@index'
    ]);

    Route::get('aptitude-question', [
        'as' => 'aptitude-question',
        'uses' => 'AptitudeTestController@aptitude_question'
    ]);


    Route::any('down-new-doc/{selection_id}/{qbank_aptitude_id}', [
        'as' => 'down-new-doc',
        'uses' => 'AptitudeTestController@download_new_doc'
    ]);

    Route::any('down-csv-file/{selection_id}/{qbank_aptitude_id}', [
        'as' => 'down-csv-file',
        'uses' => 'AptitudeTestController@down_csv_file'
    ]);

    Route::any('down-ppt-file/{selection_id}/{qbank_aptitude_id}', [
        'as' => 'down-ppt-file',
        'uses' => 'AptitudeTestController@down_ppt_file'
    ]);

    Route::any('answer-submit', [
        'as' => 'answer-submit',
        'uses' => 'AptitudeTestController@answer_submit'
    ]);

    Route::any('answer-redownload/{aptitude_exam_result_id}/{qbank_aptitude_id}', [
        'as' => 'answer-redownload',
        'uses' => 'AptitudeTestController@answer_redownload'
    ]);

    Route::any('answer-re-submit/{aptitude_exam_result_id}', [
        'as' => 'answer-re-submit',
        'uses' => 'AptitudeTestController@answer_re_submit'
    ]);


    Route::any("aptitude-congratulation", [
        "as"   => "aptitude-congratulation",
        "uses" => "AptitudeTestController@aptitude_congratulation"
    ]);

    Route::any("file-upload", [
        "as"   => "file-upload",
        "uses" => "AptitudeTestController@file_upload"
    ]);

    Route::any("ajax-get-file-upload-info", [
        "as"   => "ajax-get-file-upload-info",
        "uses" => "AptitudeTestController@ajax_get_file_upload_info"
    ]);

    /*--------------Examiner Selection-----------------*/


    Route::any('examiner-selection', [
        'as' => 'examiner-selection',
        'uses' => 'ExaminerController@index'
    ]);

    Route::get('create-examiner', [
        'as' => 'create-examiner',
        'uses' => 'ExaminerController@create'
    ]);

    Route::any("store-examiner", [
        "as"   => "store-examiner",
        "uses" => "ExaminerController@store"
    ]);

    Route::any("view-examiner/{id}", [
        "as"   => "view-examiner",
        "uses" => "ExaminerController@show"
    ]);

    Route::any("edit-examiner/{id}", [
        "as"   => "edit-examiner",
        "uses" => "ExaminerController@edit"
    ]);

    Route::any("update-examiner/{id}", [
        "as"   => "update-examiner",
        "uses" => "ExaminerController@update"
    ]);

    Route::any("delete-examiner/{id}", [
        "as"   => "delete-examiner",
        "uses" => "ExaminerController@delete"
    ]);

    /*--------------Examiner Selection-----------------*/

    /*--------------Examination Process-----------------*/


    Route::any('exam-process', [
        'as' => 'exam-process',
        'uses' => 'ExamProcessController@index'
    ]);

    Route::get('create-process', [
        'as' => 'create-process',
        'uses' => 'ExamProcessController@create'
    ]);

    Route::any('start-process', [
        'as' => 'start-process',
        'uses' => 'ExamProcessController@start_process'
    ]);

    Route::any('deactivate-process/{id}', [
        'as' => 'deactivate-process',
        'uses' => 'ExamProcessController@deactivate_process'
    ]);

    Route::any('reactivate-process/{id}', [
        'as' => 'reactivate-process',
        'uses' => 'ExamProcessController@reactivate_process'
    ]);


    /*--------------Examination Process-----------------*/

    /*--------------Answer Sheet Checking-----------------*/


    Route::any('answer-checking', [
        'as' => 'answer-checking',
        'uses' => 'AnswerSheetCheckingController@index'
    ]);

    Route::any('start-checking/{company_id?}/{designation_id?}/{exam_code_id?}/{exam_date?}/{shift?}', [
        'as' => 'start-checking',
        'uses' => 'AnswerSheetCheckingController@create'
    ]);

    Route::any('next-answer-sheet/{company_id?}/{designation_id?}/{exam_code_id?}/{exam_date?}/{shift?}', [
        'as' => 'next-answer-sheet',
        'uses' => 'AnswerSheetCheckingController@next_answer_sheet'
    ]);

    Route::any('store-marks', [
        'as' => 'store-marks',
        'uses' => 'AnswerSheetCheckingController@store'
    ]);

    Route::any("next-checking/{company_id}/{designation_id}/{exam_code_id}/{exam_date}/{shift}", [
        "as"   => "next-checking",
        "uses" => "AnswerSheetCheckingController@create"
    ]);

    Route::any('download-candidate-answersheet/{id}', [
        'as' => 'download-candidate-answersheet',
        'uses' => 'AnswerSheetCheckingController@download_candidate_answersheet'
    ]);



    /*--------------Answer Sheet Checking-----------------*/




});