<?php

namespace App\Http\Controllers\Storages;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    use LoggerTrait;

    public $model = Storage::class;

    public function list(Request $request)
    {
        return $this->model::get();
    }
    //TODO: FRONTEND HOGY TUDJA MAJD KÜLDENI AZ IDT
    public function create(Request $request)
    {
        $model = $this->model::find($request->id);
        $data = $request->validate($this->model::$createRules);

        $content = array(
            0 => 5,
            1 => 1,
            2 => 50,
            1 => 1,
        );

        $data['value'] = $model->value + $request->value * $content[$request->id - 1];
        $model->fill($data);
        $model->save();
        return ["success" => true];
        $content = "Raktár elem felvitele: \nElemneve: " . $data['name'] . "\nMennyisége: ";
        $this->Logger(9, $content);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model::find($id);
        $data = $request->validate($this->model::$updateRules);

        $content = array(
            0 => 5,
            1 => 1,
            2 => 50,
            1 => 1,
        );

        $data['value'] = $model->value + $request->value * $content[$id - 1];
        $model->fill($data);
        $model->save();
        return ["success" => true];
    }
}
