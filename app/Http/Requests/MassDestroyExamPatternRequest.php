<?php

namespace App\Http\Requests;

use App\Models\ExamPattern;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyExamPatternRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('exam_pattern_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:exam_patterns,id',
        ];
    }
}
