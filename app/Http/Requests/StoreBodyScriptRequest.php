<?php

namespace App\Http\Requests;

use App\Models\BodyScript;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBodyScriptRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('body_script_create');
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
