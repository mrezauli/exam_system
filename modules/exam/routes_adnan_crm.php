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

Route::any('ajax-get-answered-text', [
    'as' => 'ajax-get-answered-text',
    'uses' => 'CandidateReExamController@ajax_get_answered_text'
]);

Route::any('ajax-get-remarks', [
    'as' => 'ajax-get-remarks',
    'uses' => 'CandidateReExamController@ajax_get_remarks'
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



    /*--------------Answer Sheet Review-----------------*/


    Route::any('answer-sheet-review', [
        'as' => 'answer-sheet-review',
        'uses' => 'AnswerSheetReviewController@index'
    ]);

    Route::any('start-review/{company_id?}/{designation_id?}/{exam_code_id?}/{exam_date?}/{shift?}', [
        'as' => 'start-review',
        'uses' => 'AnswerSheetReviewController@create'
    ]);

    Route::any('next-answer-sheet/{company_id?}/{designation_id?}/{exam_code_id?}/{exam_date?}/{shift?}', [
        'as' => 'next-answer-sheet',
        'uses' => 'AnswerSheetReviewController@next_answer_sheet'
    ]);

    Route::any('store-review-marks', [
        'as' => 'store-review-marks',
        'uses' => 'AnswerSheetReviewController@store'
    ]);

    Route::any("next-review/{company_id}/{designation_id}/{exam_code_id}/{exam_date}/{shift}", [
        "as"   => "next-review",
        "uses" => "AnswerSheetReviewController@create"
    ]);

    Route::any('download-candidate-answersheet/{id}', [
        'as' => 'download-candidate-answersheet',
        'uses' => 'AnswerSheetReviewController@download_candidate_answersheet'
    ]);



    /*--------------Answer Sheet Review-----------------*/

