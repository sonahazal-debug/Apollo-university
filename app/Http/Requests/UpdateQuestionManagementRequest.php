<?php

namespace App\Http\Requests;

use App\Models\QuestionManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuestionManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_management_edit');
    }

    public function rules()
    {
        return [
            'option_1_image' => [
                'string',
                'nullable',
            ],
            'option_2_image' => [
                'string',
                'nullable',
            ],
            'terms' => [
                'string',
                'nullable',
            ],
            'difficulty_level' => [
                'string',
                'nullable',
            ],
        ];
    }
}
