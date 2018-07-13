<?php



/**QBankTypingTest**/

Route::get('qbank-typing-test', [
    'as' => 'qbank-typing-test',
    'uses' => 'QBankTypingTestController@index'
]);

Route::get('create-qbank-typing-test', [
    'as' => 'create-qbank-typing-test',
    'uses' => 'QBankTypingTestController@create'
]); 

Route::any("store-qbank-typing-test", [
    "as"   => "store-qbank-typing-test",
    "uses" => "QBankTypingTestController@store"
]);

Route::any("view-qbank-typing-test/{id}", [
    "as"   => "view-qbank-typing-test",
    "uses" => "QBankTypingTestController@show"
]);

Route::any("edit-qbank-typing-test/{id}", [
    "as"   => "edit-qbank-typing-test",
    "uses" => "QBankTypingTestController@edit"
]);

Route::any("update-qbank-typing-test/{id}", [
    "as"   => "update-qbank-typing-test",
    "uses" => "QBankTypingTestController@update"
]);

Route::any("delete-qbank-typing-test/{id}", [
    "as"   => "delete-qbank-typing-test",
    "uses" => "QBankTypingTestController@delete"
]);






/**QBankAptitudeTest**/

Route::get('qbank-aptitude-test', [
    'as' => 'qbank-aptitude-test',
    'uses' => 'QBankAptitudeTestController@index'
]);

Route::get('create-qbank-aptitude-test', [
    'as' => 'create-qbank-aptitude-test',
    'uses' => 'QBankAptitudeTestController@create'
]);
Route::get('create-qbank-aptitude-test-word', [
    'as' => 'create-qbank-aptitude-test-word',
    'uses' => 'QBankAptitudeTestController@create_ms_word'
]);
Route::get('create-qbank-aptitude-test-excel', [
    'as' => 'create-qbank-aptitude-test-excel',
    'uses' => 'QBankAptitudeTestController@create_ms_excel'
]);
Route::get('create-qbank-aptitude-test-ppt', [
    'as' => 'create-qbank-aptitude-test-ppt',
    'uses' => 'QBankAptitudeTestController@create_ms_ppt'
]);

Route::any("store-qbank-aptitude-test", [
    "as"   => "store-qbank-aptitude-test",
    "uses" => "QBankAptitudeTestController@store"
]);

Route::any("view-qbank-aptitude-test/{id}", [
    "as"   => "view-qbank-aptitude-test",
    "uses" => "QBankAptitudeTestController@show"
]);

Route::any("edit-qbank-aptitude-test/{id}", [
    "as"   => "edit-qbank-aptitude-test",
    "uses" => "QBankAptitudeTestController@edit"
]);

Route::any("update-qbank-aptitude-test/{id}", [
    "as"   => "update-qbank-aptitude-test",
    "uses" => "QBankAptitudeTestController@update"
]);

Route::any("delete-qbank-aptitude-test/{id}", [
    "as"   => "delete-qbank-aptitude-test",
    "uses" => "QBankAptitudeTestController@delete"
]);





/**QSelectionTypingTest**/

Route::get('qselection-typing-test', [
    'as' => 'qselection-typing-test',
    'uses' => 'QSelectionTypingTestController@index'
]);

Route::get('create-qselection-typing-test', [
    'as' => 'create-qselection-typing-test',
    'uses' => 'QSelectionTypingTestController@create'
]); 

Route::any("store-qselection-typing-test/{action?}", [
    "as"   => "store-qselection-typing-test",
    "uses" => "QSelectionTypingTestController@store"
]);

Route::any("view-qselection-typing-test/{id}", [
    "as"   => "view-qselection-typing-test",
    "uses" => "QSelectionTypingTestController@show"
]);

Route::any("edit-qselection-typing-test/{id}", [
    "as"   => "edit-qselection-typing-test",
    "uses" => "QSelectionTypingTestController@edit"
]);

Route::any("update-qselection-typing-test/{id}", [
    "as"   => "update-qselection-typing-test",
    "uses" => "QSelectionTypingTestController@update"
]);

Route::any("delete-qselection-typing-test/{id}", [
    "as"   => "delete-qselection-typing-test",
    "uses" => "QSelectionTypingTestController@delete"
]);






/**QSelectionAptitudeTest**/

Route::get('qselection-aptitude-test', [
    'as' => 'qselection-aptitude-test',
    'uses' => 'QSelectionAptitudeTestController@index'
]);

Route::get('create-qselection-aptitude-test', [
    'as' => 'create-qselection-aptitude-test',
    'uses' => 'QSelectionAptitudeTestController@create'
]); 

Route::any("store-qselection-aptitude-test", [
    "as"   => "store-qselection-aptitude-test",
    "uses" => "QSelectionAptitudeTestController@store"
]);

Route::any("view-qselection-aptitude-test/{id}", [
    "as"   => "view-qselection-aptitude-test",
    "uses" => "QSelectionAptitudeTestController@show"
]);

Route::any("edit-qselection-aptitude-test/{id}", [
    "as"   => "edit-qselection-aptitude-test",
    "uses" => "QSelectionAptitudeTestController@edit"
]);

Route::any("update-qselection-aptitude-test/{id}", [
    "as"   => "update-qselection-aptitude-test",
    "uses" => "QSelectionAptitudeTestController@update"
]);

Route::any("delete-qselection-aptitude-test/{id}", [
    "as"   => "delete-qselection-aptitude-test",
    "uses" => "QSelectionAptitudeTestController@delete"
]);

Route::any('ajax-print-qselection-aptitude-question', [
    'as' => 'ajax-print-qselection-aptitude-question',
    'uses' => 'QSelectionAptitudeTestController@ajax_print_qselection_aptitude_question'
]);

Route::any('ajax-delete-print-qselection-aptitude-question', [
    'as' => 'ajax-delete-print-qselection-aptitude-question',
    'uses' => 'QSelectionAptitudeTestController@ajax_delete_print_qselection_aptitude_question'
]);







/**QBankTypingTest**/

Route::get('question-paper-set', [
    'as' => 'question-paper-set',
    'uses' => 'QuestionPaperSetController@index'
]);

Route::any('create-question-paper-set', [
    'as' => 'create-question-paper-set',
    'uses' => 'QuestionPaperSetController@create'
]); 

Route::any("store-question-paper-set", [
    "as"   => "store-question-paper-set",
    "uses" => "QuestionPaperSetController@store"
]);

Route::any("view-question-paper-set/{id}", [
    "as"   => "view-question-paper-set",
    "uses" => "QuestionPaperSetController@show"
]);

Route::any("edit-question-paper-set/{id}", [
    "as"   => "edit-question-paper-set",
    "uses" => "QuestionPaperSetController@edit"
]);

Route::any("update-question-paper-set/{id}", [
    "as"   => "update-question-paper-set",
    "uses" => "QuestionPaperSetController@update"
]);

Route::any("delete-question-paper-set/{id}", [
    "as"   => "delete-question-paper-set",
    "uses" => "QuestionPaperSetController@delete"
]);