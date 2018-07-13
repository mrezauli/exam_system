<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 5/3/2017
 * Time: 5:26 PM
 */

namespace App\Http\Requests;
use App\Http\Requests\Request;


class AnswerSheetCheckingRequest extends Request
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