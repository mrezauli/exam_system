<?php

/**
 * Created by PhpStorm.
 * User: shajjad
 * Date: 2/28/2017
 * Time: 10:29 PM
 */
namespace App\Http\Requests;
use App\Http\Requests\Request;

class OrganizationMasterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        //if($this->method() == 'PATCH')
        //{
        // Update operation, exclude the record with id from the validation:
        //$company_name_rule = 'required|max:64|unique:company,id';
        //}else{
        // $company_name_rule = 'required|max:64|unique:company';
        //}

        return [
            //'company_name' => $company_name_rule,
            //'company_type' => 'required|max:64'
        ];
    }

}