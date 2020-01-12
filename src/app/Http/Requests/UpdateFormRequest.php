<?php

namespace App\Http\Requests;

use App\Enums\QuestionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateFormRequest
 * @package App\Http\Requests
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class UpdateFormRequest extends FormRequest
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
            'name' => "required|string|max:255|unique:forms,name,{$this->id}",
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
