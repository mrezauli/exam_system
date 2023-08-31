<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 11/24/2016
 * Time: 12:40 PM
 */

Route::group(array('prefix'=>'admin','modules'=>'Admin', 'namespace' => 'Modules\Admin\Controllers','middleware'=>['auth','access_control:admin']), function() {

    include 'routes_adnan.php';


    /**Company**/

    Route::get("organization", [
        //"middleware" => "acl_access:company",
        "as"   => "company",
        "uses" => "CompanyController@index"
    ]);

    Route::any("store-organization", [
        //"middleware" => "acl_access:store-company",
        "as"   => "store-company",
        "uses" => "CompanyController@store"
    ]);

    Route::any("view-organization/{id}", [
        //"middleware" => "acl_access:view-company/{id}",
        "as"   => "view-company",
        "uses" => "CompanyController@show"
    ]);

    Route::any("edit-organization/{id}", [
        //"middleware" => "acl_access:edit-company/{id}",
        "as"   => "edit-company",
        "uses" => "CompanyController@edit"
    ]);

    Route::any("update-organization/{id}", [
        //"middleware" => "acl_access:update-company/{id}",
        "as"   => "update-company",
        "uses" => "CompanyController@update"
    ]);

    Route::any("delete-organization/{id}", [
        //"middleware" => "acl_access:delete-company/{id}",
        "as"   => "delete-company",
        "uses" => "CompanyController@delete"
    ]);


    /***************Designation********************/

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


    /********Question Setup Typing*************/

    // Route::get("question-typing", [
    //     //"middleware" => "acl_access:company",
    //     "as"   => "question-typing",
    //     "uses" => "QTypingMasterController@index"
    // ]);

    // Route::any("create-qtmaster", [
    //     "as"   => "create-qtmaster",
    //     "uses" => "QTypingMasterController@create"
    // ]);

    // Route::any("store-qtmaster", [
    //     "as"   => "store-qtmaster",
    //     "uses" => "QTypingMasterController@store"
    // ]);

    // Route::any("view-qtmaster/{id}", [
    //     "as"   => "view-qtmaster",
    //     "uses" => "QTypingMasterController@show"
    // ]);

    // Route::any("edit-qtmaster/{id}", [
    //     "as"   => "edit-qtmaster",
    //     "uses" => "QTypingMasterController@edit"
    // ]);

    // Route::any("update-qtmaster/{id}", [
    //     "as"   => "update-qtmaster",
    //     "uses" => "QTypingMasterController@update"
    // ]);

    // Route::any("delete-qtmaster/{id}", [
    //     "as"   => "delete-qtmaster",
    //     "uses" => "QTypingMasterController@delete"
    // ]);







});