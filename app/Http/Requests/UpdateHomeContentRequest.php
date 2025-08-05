<?php

namespace App\Http\Requests;

use App\Models\HomeContent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHomeContentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('home_content_edit');
    }

    public function rules()
    {
        return [
            'image' => [
               
                'nullable',
            ],
            'content' => [
                'string',
                'nullable',
            ],
        ];
    }
}
