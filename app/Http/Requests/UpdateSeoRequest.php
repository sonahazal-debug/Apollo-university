<?php

namespace App\Http\Requests;

use App\Models\Seo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSeoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seo_edit');
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
