<?php

namespace App\Http\Requests;

use App\Models\CategoryManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCategoryManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('category_management_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'required',
            ],
        ];
    }
}
