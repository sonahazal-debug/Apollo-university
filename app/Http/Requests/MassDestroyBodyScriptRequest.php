<?php

namespace App\Http\Requests;

use App\Models\BodyScript;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBodyScriptRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('body_script_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:body_scripts,id',
        ];
    }
}
