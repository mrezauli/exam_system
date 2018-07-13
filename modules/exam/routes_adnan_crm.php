<?php

/**Typing Exam**/

Route::get('candidate-re-exam', [
    'as' => 'candidate-re-exam',
    'uses' => 'CandidateReExamController@index'
]);

Route::any('update-candidate-re-exam', [
    'as' => 'update-candidate-re-exam',
    'uses' => 'CandidateReExamController@update'
]);

Route::any('ajax-get-main-exam-type', [
    'as' => 'ajax-get-main-exam-type',
    'uses' => 'CandidateReExamController@ajax_get_main_exam_type'
]);




Route::get('typing-exams', [
    'as' => 'typing-exams',
    'uses' => 'TypingTestController@index'
]);


Route::get('welcome-typing-exam', [
    'as' => 'welcome-typing-exam',
    'uses' => 'TypingTestController@welcome'
]);

Route::get('create-exam/{id}', [
    'as' => 'create-exam',
    'uses' => 'TypingTestController@create'
]); 

Route::any("store-exam", [
    "as"   => "store-exam",
    "uses" => "TypingTestController@store"
]);

Route::any("view-exam/{id}", [
    "as"   => "view-exam",
    "uses" => "TypingTestController@show"
]);

Route::any("edit-exam/{id}", [
    "as"   => "edit-exam",
    "uses" => "TypingTestController@edit"
]);

Route::any("update-exam/{id}", [
    "as"   => "update-exam",
    "uses" => "TypingTestController@update"
]);

Route::any("delete-exam/{id}", [
    "as"   => "delete-exam",
    "uses" => "TypingTestController@delete"
]);


Route::any("start-typing-exam/{exam_type}", [
    "as"   => "start-typing-exam",
    "uses" => "TypingTestController@start"
]);

Route::any("submit-typing-exam/{exam_type}", [
    "as"   => "submit-typing-exam",
    "uses" => "TypingTestController@submit"
]);




Route::any("show-result", [
    "as"   => "show-result",
    "uses" => "TypingTestController@show_result"
]);

