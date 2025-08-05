<?php

namespace App\Http\Requests;

use App\Models\ResultManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateResultManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('result_management_edit');
    }

    public function rules()
    {
        return [
            'total_questions' => [
                'string',
                'nullable',
            ],
            'total_attempted' => [
                'string',
                'nullable',
            ],
            'total_correct' => [
                'string',
                'nullable',
            ],
            'total_wrong' => [
                'string',
                'nullable',
            ],
            'score' => [
                'string',
                'nullable',
            ],
            'rank' => [
                'string',
                'nullable',
            ],
        ];
    }
}
