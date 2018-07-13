<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 1:46 PM
 */

namespace App\Http\Requests;
use App\Http\Requests\Request;



class CompanyRequest extends Request
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


        $id = $this->id ? $this->id : 'null';

        return [
            'company_name' => 'required|max:512|unique:company,company_name,'.$id.',id,status,active',
        ];





        // if($this->method() == 'PATCH')
        //   {
        //     // Update operation, exclude the record with id from the validation:
        //     $company_name_rule = 'required|max:64|unique:company,id';
        //   }else{
        //     $company_name_rule = 'required|max:64|unique:company';
        //   }

        // return [
        //     //'company_name' => $company_name_rule,
        //     //'company_type' => 'required|max:64'
        // ];
    }
}