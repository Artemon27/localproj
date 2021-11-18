<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class offHoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'=>'exists:users,id',
            'data.*.days'=> ['integer'],
            'data.*.PVT'=> ['integer'],
            'data.*.INV'=> ['integer'],
            'data.*.OB'=> ['integer'],
        ];
    }
}
