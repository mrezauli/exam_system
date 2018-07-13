<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/18/2017
 * Time: 4:40 PM
 */

namespace App\Http\Requests;
use App\Http\Requests\Request;


class CandidateReExamRequest extends Request
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