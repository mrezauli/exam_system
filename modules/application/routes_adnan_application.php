<?php

/********BCC Applications*************/

Route::get('application-bcc', [
    'as' => 'application-bcc',
    'uses' => 'ApplicationBccController@index'
]);

Route::get("application-bcc-form", [
    //"middleware" => "acl_access:company",
    "as"   => "application-bcc-form",
    "uses" => "ApplicationBccController@create"
]);

Route::any("store-application-bcc", [
    "as"   => "store-application-bcc",
    "uses" => "ApplicationBccController@store"
]);

Route::get("application-bcc-view/{id}", [
    //"middleware" => "acl_access:company",
    "as"   => "application-bcc-view",
    "uses" => "ApplicationBccController@show"
]);
