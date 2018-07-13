<?php
/**
 * Created by PhpStorm.
 * User: shajjad
 * Date: 3/31/2017
 * Time: 7:55 PM
 */

namespace App\Http\Requests;
use App\Http\Requests\Request;


class AptitudeExamRequest extends Request
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
        return [
            // 'name' => 'required|max:64'
        ];
    }

}