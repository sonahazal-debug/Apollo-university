<?php

namespace App\Http\Requests;

use App\Models\CategoryManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryManagementRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('category_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:category_managements,id',
        ];
    }
}
