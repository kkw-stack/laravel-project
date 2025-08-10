<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'ticket' => ['required', 'integer', 'exists:tickets,id'],
            'use_docent' => ['required', 'boolean'],
            'select_date' => ['required', 'date'],
            'select_time' => ['required', 'date_format:i:s'],
            'visitors' => ['required', 'array'],
        ];
    }
}
