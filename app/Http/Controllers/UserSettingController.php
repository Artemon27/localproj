<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSetting;

class UserSettingController extends Controller
{
    public function toggle(Request $request, $id)
    {
        try {
            $model = app()->make($this->modelName)->where('user_id', '=', $id)->firstOrNew(['user_id' => $id]);
            $model->setAttribute($request->input('field'), $request->input('value'));
            $model->save();
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'msg' => 'Состояние изменено', 'state' => $model->getAttribute($request->input('field'))]);
    }    
    protected $modelName = UserSetting::class;
}
