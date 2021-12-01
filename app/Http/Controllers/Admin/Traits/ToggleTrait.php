<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Http\Request;

trait ToggleTrait
{
    public function toggle(Request $request, $id)
    {
        try {
            $model = app()->make($this->modelName)->findOrFail($id);

            $model->setAttribute($request->input('field'), $request->input('value'));
            $model->save();
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'msg' => 'Состояние изменено', 'state' => $model->getAttribute($request->input('field'))]);
    }
}