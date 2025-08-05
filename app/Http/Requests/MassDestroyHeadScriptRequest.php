<?php

namespace App\Http\Requests;

use App\Models\HeadScript;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHeadScriptRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('head_script_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:head_scripts,id',
        ];
    }
}
