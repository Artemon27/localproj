<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HolidaysResource;

use Illuminate\Support\Facades\Validator;
use App\Models\User;

class HolidayController extends Controller
{
    public function show(Request $request) {
        $data = $request->json()->all();
        $rules = [
            'year' => 'required|integer|min:2020|max:2100'
        ];
        $validator = Validator::make($data, $rules);
        
        if ($validator->errors()->has('year')){
            $data['year'] = date('Y');
        }
        $user = $request->user();
        return HolidaysResource::collection($user->holidaysYear($data['year']));
    }
}
