<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 12/12/2016
 * Time: 2:01 PM
 */

Route::group(array('prefix'=>'application','modules'=>'application', 'namespace' => 'Modules\application\Controllers','middleware'=>['auth','access_control:application']), function() {

    include 'routes_adnan_application.php';


    /********Organization File Upload Applications*************/

    Route::any('organization-file-upload', [
        'as' => 'organization-file-upload',
        'uses' => 'OrganizationFileUploadController@index'
    ]);

    Route::any('received-email-organization-file-upload', [
        'as' => 'received-email-organization-file-upload',
        'uses' => 'OrganizationFileUploadController@received_email_index'
    ]);

    Route::any("create-organization-file-upload", [
        //"middleware" => "acl_access:company",
        "as"   => "create-organization-file-upload",
        "uses" => "OrganizationFileUploadController@create"
    ]);

    Route::any("store-organization-file-upload", [
        "as"   => "store-organization-file-upload",
        "uses" => "OrganizationFileUploadController@store"
    ]);

    Route::any("view-organization-file-upload/{received}/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "view-organization-file-upload",
        "uses" => "OrganizationFileUploadController@show"
    ]);

    Route::any("edit-organization-file-upload/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "edit-organization-file-upload",
        "uses" => "OrganizationFileUploadController@edit"
    ]);

    Route::any("update-organization-file-upload/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "update-organization-file-upload",
        "uses" => "OrganizationFileUploadController@update"
    ]);

    Route::any("delete-organization-file-upload-attachment/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "delete-application-org-attachment",
        "uses" => "OrganizationFileUploadController@delete_attachment_file"
    ]);

        /********Organization Template Applications*************/

    Route::any('organization-template', [
        'as' => 'organization-template',
        'uses' => 'OrganizationTemplateController@index'
    ]);

    Route::any("create-organization-template", [
        //"middleware" => "acl_access:company",
        "as"   => "create-organization-template",
        "uses" => "OrganizationTemplateController@create"
    ]);

    Route::any("store-organization-template", [
        "as"   => "store-organization-template",
        "uses" => "OrganizationTemplateController@store"
    ]);

    Route::any("view-organization-template/{received}/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "view-organization-template",
        "uses" => "OrganizationTemplateController@show"
    ]);

    Route::any("edit-organization-template/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "edit-organization-template",
        "uses" => "OrganizationTemplateController@edit"
    ]);

    Route::any("update-organization-template/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "update-organization-template",
        "uses" => "OrganizationTemplateController@update"
    ]);

    Route::any("delete-organization-template-attachment/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "delete-organization-template-attachment",
        "uses" => "OrganizationTemplateController@delete_attachment_file"
    ]);



    Route::any('ajax-organization-preview-data', [
        'as' => 'ajax-organization-preview-data',
        'uses' => 'OrganizationTemplateController@ajax_preview_data'
    ]);

    Route::any('ajax-organization-print-preview-data', [
        'as' => 'ajax-organization-print-preview-data',
        'uses' => 'OrganizationTemplateController@ajax_print_preview_data'
    ]);

    Route::any('ajax-organization-delete-print-preview-data', [
        'as' => 'ajax-organization-delete-print-preview-data',
        'uses' => 'OrganizationTemplateController@ajax_delete_print_preview_data'
    ]);

    


        /********Bcc File Upload Applications*************/

    Route::any('bcc-file-upload', [
        'as' => 'bcc-file-upload',
        'uses' => 'BccFileUploadController@index'
    ]);

    Route::any('received-email-bcc-file-upload', [
        'as' => 'received-email-bcc-file-upload',
        'uses' => 'BccFileUploadController@received_email_index'
    ]);

    Route::any("create-bcc-file-upload", [
        //"middleware" => "acl_access:company",
        "as"   => "create-bcc-file-upload",
        "uses" => "BccFileUploadController@create"
    ]);

    Route::any("store-bcc-file-upload", [
        "as"   => "store-bcc-file-upload",
        "uses" => "BccFileUploadController@store"
    ]);

    Route::any("view-bcc-file-upload/{received}{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "view-bcc-file-upload",
        "uses" => "BccFileUploadController@show"
    ]);

    Route::any("edit-bcc-file-upload/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "edit-bcc-file-upload",
        "uses" => "BccFileUploadController@edit"
    ]);

    Route::any("update-bcc-file-upload/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "update-bcc-file-upload",
        "uses" => "BccFileUploadController@update"
    ]);

    Route::any("delete-bcc-file-upload-attachment/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "delete-application-org-attachment",
        "uses" => "BccFileUploadController@delete_attachment_file"
    ]);

        /********Bcc Template Applications*************/

    Route::any('bcc-template', [
        'as' => 'bcc-template',
        'uses' => 'BccTemplateController@index'
    ]);

    Route::any("create-bcc-template", [
        //"middleware" => "acl_access:company",
        "as"   => "create-bcc-template",
        "uses" => "BccTemplateController@create"
    ]);

    Route::any("store-bcc-template", [
        "as"   => "store-bcc-template",
        "uses" => "BccTemplateController@store"
    ]);

    Route::any("view-bcc-template/{received}/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "view-bcc-template",
        "uses" => "BccTemplateController@show"
    ]);

    Route::any("edit-bcc-template/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "edit-bcc-template",
        "uses" => "BccTemplateController@edit"
    ]);

    Route::any("update-bcc-template/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "update-bcc-template",
        "uses" => "BccTemplateController@update"
    ]);

    Route::any("delete-bcc-template-attachment/{id}", [
        //"middleware" => "acl_access:company",
        "as"   => "delete-bcc-template-attachment",
        "uses" => "BccTemplateController@delete_attachment_file"
    ]);




    Route::any('preview-email-template', [
        'as' => 'preview-email-template',
        'uses' => 'BccTemplateController@preview'
    ]);

    Route::any('ajax-bcc-preview-data', [
        'as' => 'ajax-bcc-preview-data',
        'uses' => 'BccTemplateController@ajax_preview_data'
    ]);

    Route::any('ajax-bcc-print-preview-data', [
        'as' => 'ajax-bcc-print-preview-data',
        'uses' => 'BccTemplateController@ajax_print_preview_data'
    ]);

    Route::any('ajax-bcc-delete-print-preview-data', [
        'as' => 'ajax-bcc-delete-print-preview-data',
        'uses' => 'BccTemplateController@ajax_delete_print_preview_data'
    ]);


    /********Candidate list Format Download*************/

    Route::any('excel-format', [
        'as' => 'excel-format',
        'uses' => 'OrganizationTemplateController@excel_format'
    ]);





});