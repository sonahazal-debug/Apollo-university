<?php

namespace App\Http\Requests;

use App\Models\Seo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSeoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seo_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'keywords' => [
                'string',
                'nullable',
            ],
        ];
    }
}
