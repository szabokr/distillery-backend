<?php

namespace App\Http\Controllers\Params;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Param;

class ParamController extends Controller
{
    public $model = Param::class;

    public function list(Request $request)
    {
        return $this->model::get();
    }

    public function update(Request $request, $id)
    {
        $model = $this->model::find($id);
        $data = $request->validate($this->model::$updateRules);
        $model->value = $data['value'];
        $model->fill($data);
        $model->save();
        return ["success" => true];
    }
}
