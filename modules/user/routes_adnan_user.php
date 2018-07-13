<?php

/**Exam**/


Route::any('organization-user-list', [
    'as' => 'organization-user-list',
    'uses' => 'OrganizationUserController@index'
]);

Route::any('registration', [
    //'middleware' => 'acl_access:registration',
    'as' => 'registration',
    'uses' => 'OrganizationUserController@add_organization_user'
]);

Route::any('store-organization-user', [
    //'middleware' => 'acl_access:store-organization-user',
    'as' => 'store-organization-user',
    'uses' => 'OrganizationUserController@store_organization_user'
]);

Route::any('search-organization-user', [
    //'middleware' => 'acl_access:organization-user/search-organization-user',
    'as' => 'search-organization-user',
    'uses' => 'OrganizationUserController@search_organization_user'
]);

Route::any('show-organization-user/{id}', [
    //'middleware' => 'acl_access:organization-user/show-organization-user/{id}',
    'as' => 'show-organization-user',
    'uses' => 'OrganizationUserController@show_organization_user'
]);

Route::any('edit-organization-user/{id}', [
    //'middleware' => 'acl_access:organization-user/edit-organization-user/{id}',
    'as' => 'edit-organization-user',
    'uses' => 'OrganizationUserController@edit_organization_user'
]);

Route::any('update-organization-user/{id}', [
    //'middleware' => 'acl_access:organization-user/update-organization-user/{id}',
    'as' => 'update-organization-user',
    'uses' => 'OrganizationUserController@update_organization_user'
]);

Route::any('delete-organization-user/{id}', [
    //'middleware' => 'acl_access:organization-user/delete-organization-user/{id}',
    'as' => 'delete-organization-user',
    'uses' => 'OrganizationUserController@destroy_organization_user'
]);








Route::get('login', [
    'as' => 'login',
    'uses' => 'OrganizationAuthController@getLogin'
]);

Route::any('post-organization-user-login', [
    'as' => 'post-organization-user-login',
    'uses' => 'OrganizationAuthController@postLogin'
]);
?>