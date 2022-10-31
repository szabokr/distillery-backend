<?php

namespace App\Http\Controllers\params;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Models\Fruit;
use Illuminate\Http\Request;

class FruitController extends Controller
{
    use LoggerTrait;

    public $model = Fruit::class;

    public function list(Request $request)
    {
        return $this->model::get();
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->model::$createRules);
        $model = $this->model::make();
        $model->fill($data);
        $model->save();
        return ["success" => true];
    }


    //TUDO: UPDATE Migration írása
    // public function delete(Request $request, $id)
    // {
    //     $model = $this->model::find($id);
    //     if (!$model) throw new \Exception('A rekord nem található!');
    //     $model->delete();
    //     return ["success" => true];
    // }
}
