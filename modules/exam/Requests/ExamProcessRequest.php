<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/22/2017
 * Time: 12:42 PM
 */

namespace App\Http\Requests;
use App\Http\Requests\Request;


class ExamProcessRequest extends Request
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
            'exam_code_id' => 'required',
            'sl_from' => 'required',
            'sl_to' => 'required',
        ];
    }

}