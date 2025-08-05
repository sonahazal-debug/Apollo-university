<?php

namespace App\Http\Requests;

use App\Models\ExamManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreExamManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('exam_management_create');
    }

    public function rules()
    {
        return [
            'test_type' => [
                'string',
                'nullable',
            ],
            'exam_name' => [
                'string',
                'nullable',
            ],
            'start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'end_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
