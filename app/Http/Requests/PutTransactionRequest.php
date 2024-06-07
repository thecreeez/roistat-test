<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email:rfc,dns'],
            'phone' => ['required', 'digits:11', 'numeric'],
            'price' => ['required', 'numeric', 'min:1'],
            'isVisitLong' => ['min:0','max:1','size:1'],
        ];
    }
}
