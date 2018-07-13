<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 12/10/2016
 * Time: 11:25 AM
 */


/**Product Group**/

Route::get('dashboard', [
    'as' => 'dashboard',
    'uses' => 'DashboardController@index'
]);




/**Product Group**/

Route::get('product-group', [
    'as' => 'product-group',
    'uses' => 'ProductGroupController@index'
]);

Route::any("store-product-group", [
    "as"   => "store-product-group",
    "uses" => "ProductGroupController@store"
]);

Route::any("view-product-group/{id}", [
    "as"   => "view-product-group",
    "uses" => "ProductGroupController@show"
]);

Route::any("edit-product-group/{id}", [
    "as"   => "edit-product-group",
    "uses" => "ProductGroupController@edit"
]);

Route::any("update-product-group/{id}", [
    "as"   => "update-product-group",
    "uses" => "ProductGroupController@update"
]);

Route::any("delete-product-group/{id}", [
    "as"   => "delete-product-group",
    "uses" => "ProductGroupController@delete"
]);




/**Product**/

Route::get('product', [
    'as' => 'product',
    'uses' => 'ProductController@index'
]);

Route::any("store-product", [
    "as"   => "store-product",
    "uses" => "ProductController@store"
]);

Route::any("view-product/{id}", [
    "as"   => "view-product",
    "uses" => "ProductController@show"
]);

Route::any("edit-product/{id}", [
    "as"   => "edit-product",
    "uses" => "ProductController@edit"
]);

Route::any("update-product/{id}", [
    "as"   => "update-product",
    "uses" => "ProductController@update"
]);

Route::any("delete-product/{id}", [
    "as"   => "delete-product",
    "uses" => "ProductController@delete"
]);




/**Client Existing Product**/

Route::get('client-existing-product', [
    'as' => 'client-existing-product',
    'uses' => 'ClientExistingProductController@index'
]);

Route::any("store-client-existing-product", [
    "as"   => "store-client-existing-product",
    "uses" => "ClientExistingProductController@store"
]);

Route::any("view-client-existing-product/{id}", [
    "as"   => "view-client-existing-product",
    "uses" => "ClientExistingProductController@show"
]);

Route::any("edit-client-existing-product/{id}", [
    "as"   => "edit-client-existing-product",
    "uses" => "ClientExistingProductController@edit"
]);

Route::any("update-client-existing-product/{id}", [
    "as"   => "update-client-existing-product",
    "uses" => "ClientExistingProductController@update"
]);

Route::any("delete-client-existing-product/{id}", [
    "as"   => "delete-client-existing-product",
    "uses" => "ClientExistingProductController@delete"
]);

Route::any("delete-client-existing-product-all/{id}", [
    "as"   => "delete-client-existing-product-all",
    "uses" => "ClientExistingProductController@deleteAll"
]);



/**Lead Category**/

Route::get('lead-category', [
    'as' => 'lead-category',
    'uses' => 'LeadCategoryController@index'
]);

Route::any("store-lead-category", [
    "as"   => "store-lead-category",
    "uses" => "LeadCategoryontroller@store"
]);

Route::any("view-lead-category/{id}", [
    "as"   => "view-lead-category",
    "uses" => "LeadCategoryController@show"
]);

Route::any("edit-lead-category/{id}", [
    "as"   => "edit-lead-category",
    "uses" => "LeadCategoryController@edit"
]);

Route::any("update-lead-category/{id}", [
    "as"   => "update-lead-category",
    "uses" => "LeadCategoryController@update"
]);

Route::any("delete-lead-category/{id}", [
    "as"   => "delete-lead-category",
    "uses" => "LeadCategoryController@delete"
]);









/**Designation**/

Route::get('designation', [
    'as' => 'designation',
    'uses' => 'DesignationController@index'
]);

Route::any("store-designation", [
    "as"   => "store-designation",
    "uses" => "DesignationController@store"
]);

Route::any("view-designation/{id}", [
    "as"   => "view-designation",
    "uses" => "DesignationController@show"
]);

Route::any("edit-designation/{id}", [
    "as"   => "edit-designation",
    "uses" => "DesignationController@edit"
]);

Route::any("update-designation/{id}", [
    "as"   => "update-designation",
    "uses" => "DesignationController@update"
]);

Route::any("delete-designation/{id}", [
    "as"   => "delete-designation",
    "uses" => "DesignationController@delete"
]);









/**Job Area**/

Route::get('job-area', [
    'as' => 'job-area',
    'uses' => 'JobAreaController@index'
]);

Route::any("store-job-area", [
    "as"   => "store-job-area",
    "uses" => "JobAreaController@store"
]);

Route::any("view-job-area/{id}", [
    "as"   => "view-job-area",
    "uses" => "JobAreaController@show"
]);

Route::any("edit-job-area/{id}", [
    "as"   => "edit-job-area",
    "uses" => "JobAreaController@edit"
]);

Route::any("update-job-area/{id}", [
    "as"   => "update-job-area",
    "uses" => "JobAreaController@update"
]);

Route::any("delete-job-area/{id}", [
    "as"   => "delete-job-area",
    "uses" => "JobAreaController@delete"
]);





/**Job Area**/



Route::any("view-task-reminder", [
    "as"   => "view-task-reminder",
    "uses" => "TaskReminderController@show"
]);

Route::any("edit-task-reminder", [
    "as"   => "edit-task-reminder",
    "uses" => "TaskReminderController@edit"
]);

Route::any("update-task-reminder/{id}", [
    "as"   => "update-task-reminder",
    "uses" => "TaskReminderController@update"
]);










/**Industry**/

Route::get('industry', [
    'as' => 'industry',
    'uses' => 'IndustryController@index'
]);

Route::any("store-industry", [
    "as"   => "store-industry",
    "uses" => "IndustryController@store"
]);

Route::any("view-industry/{id}", [
    "as"   => "view-industry",
    "uses" => "IndustryController@show"
]);

Route::any("edit-industry/{id}", [
    "as"   => "edit-industry",
    "uses" => "IndustryController@edit"
]);

Route::any("update-industry/{id}", [
    "as"   => "update-industry",
    "uses" => "IndustryController@update"
]);

Route::any("delete-industry/{id}", [
    "as"   => "delete-industry",
    "uses" => "IndustryController@delete"
]);



/**Currency**/

Route::get('exam-code', [
    'as' => 'exam-code',
    'uses' => 'ExamCodeController@index'
]);

Route::any("store-exam-code", [
    "as"   => "store-exam-code",
    "uses" => "ExamCodeController@store"
]);

Route::any("create-exam-code", [
    "as"   => "create-exam-code",
    "uses" => "ExamCodeController@create"
]);

Route::any("view-exam-code/{id}", [
    "as"   => "view-exam-code",
    "uses" => "ExamCodeController@show"
]);

Route::any("edit-exam-code/{id}", [
    "as"   => "edit-exam-code",
    "uses" => "ExamCodeController@edit"
]);

Route::any("update-exam-code/{id}", [
    "as"   => "update-exam-code",
    "uses" => "ExamCodeController@update"
]);

Route::any("delete-exam-code/{id}", [
    "as"   => "delete-exam-code",
    "uses" => "ExamCodeController@delete"
]);


Route::any("ajax-get-exam-code/{id}", [
    "as"   => "ajax-get-exam-code",
    "uses" => "ExamCodeController@ajax_get_exam_code"
]);

Route::any("ajax-get-exam-process-code/{id}", [
    "as"   => "ajax-get-exam-process-code",
    "uses" => "ExamCodeController@ajax_get_exam_process_code"
]);

Route::any("ajax-get-total-candidate-number/{id}", [
    "as"   => "ajax-get-total-candidate-number",
    "uses" => "ExamCodeController@ajax_get_total_candidate_number"
]);






/**Company Group**/

Route::get('company-group', [
    'as' => 'company-group',
    'uses' => 'CompanyGroupController@index'
]);

Route::any("store-company-group", [
    "as"   => "store-company-group",
    "uses" => "CompanyGroupController@store"
]);

Route::any("view-company-group/{id}", [
    "as"   => "view-company-group",
    "uses" => "CompanyGroupController@show"
]);

Route::any("edit-company-group/{id}", [
    "as"   => "edit-company-group",
    "uses" => "CompanyGroupController@edit"
]);

Route::any("update-company-group/{id}", [
    "as"   => "update-company-group",
    "uses" => "CompanyGroupController@update"
]);

Route::any("delete-company-group/{id}", [
    "as"   => "delete-company-group",
    "uses" => "CompanyGroupController@delete"
]);





/**Exam Time**/

    Route::get('exam-time', [
        'as' => 'exam-time',
        'uses' => 'ExamTimeController@index'
    ]);

    Route::any("update-exam-time", [
        "as"   => "update-exam-time",
        "uses" => "ExamTimeController@update"
    ]);









//ajax request


Route::any("get-client-existing-product/{id}", [
    "as"   => "get-client-existing-product",
    "uses" => "ClientExistingProductController@get_client_existing_product"
]);

Route::any("get-client-existing-product-task/{id}", [
    "as"   => "get-client-existing-product-task",
    "uses" => "ClientExistingProductController@get_client_existing_product_task"
]);