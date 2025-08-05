<?php

namespace App\Http\Requests;

use App\Models\ExamPattern;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExamPatternRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('exam_pattern_edit');
    }

    public function rules()
    {
        return [
            'number_of_questions' => [
                
                'nullable',
            ],
            'correct_mark' => [
                
                'nullable',
            ],
            'negative_mark' => [
                
                'nullable',
            ],
            'max_attemt_q' => [
                
                'nullable',
            ],
            'is_compulsory' => [
                
                'nullable',
            ],
            'total_marks' => [
                
                'nullable',
            ],
            'total_questions' => [
                
                'nullable',
            ],
        ];
    }
}
