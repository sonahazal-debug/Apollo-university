<?php

namespace App\Http\Requests;

use App\Models\HeadScript;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHeadScriptRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('head_script_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'script' => [
                'string',
                'nullable',
            ],
        ];
    }
}
