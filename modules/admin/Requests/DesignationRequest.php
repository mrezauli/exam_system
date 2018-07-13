<?php


namespace App\Http\Requests;
use App\Http\Requests\Request;

class DesignationRequest extends Request
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
            'designation_name' => 'required|max:256|unique:designation,designation_name,'.$id.',id,status,active',
        ];

    }
}