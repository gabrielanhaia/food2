<?php

namespace App\Http\Requests\V1;

use App\Enums\QuestionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class responsible for validating the requests to create a new form.
 *
 * @package App\Http\Requests
 */
class CreateFormRequest extends FormRequest
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
            'name' => 'required|unique:forms,name|string|max:255',
            'description' => 'nullable|string',
            'introduction' => 'nullable|string',
            'start_publish' => 'nullable|date_format:Y-m-d',
            'end_publish' => 'nullable|date_format:Y-m-d',
            'questions' => 'required|array',
            'questions.*.description' => 'required|string',
            'questions.*.mandatory' => 'required|boolean',
            'questions.*.type' => 'required|' . QuestionTypeEnum::formValidationString()
        ];
    }
}
