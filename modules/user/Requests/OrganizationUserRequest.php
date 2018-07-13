<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;

class OrganizationUserRequest extends Request
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
        

        $id = Request::input('id')?Request::input('id'):'';

        // print_r($id);exit;

        if($id == null)
        {

            return [
                'email'   => 'required|unique:user,email,' . $id
            ];

        }else{
            return [

            ];

        }






    }
}