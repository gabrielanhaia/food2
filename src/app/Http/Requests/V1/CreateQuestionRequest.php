<?php

namespace App\Http\Requests\V1;

use App\Enums\QuestionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateQuestionRequest
 * @package App\Http\Requests
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class CreateQuestionRequest extends FormRequest
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
            'form_id' => 'required|integer',
            'description' => 'required|string',
            'mandatory' => 'required|boolean',
            'type' => 'required|' . QuestionTypeEnum::formValidationString()
        ];
    }
}
