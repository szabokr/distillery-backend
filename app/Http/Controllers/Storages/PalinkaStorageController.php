<?php

namespace App\Http\Controllers\storages;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Models\Fruit;
use App\Models\Palinka_storage;
use Illuminate\Http\Request;

class PalinkaStorageController extends Controller
{
    use LoggerTrait;

    public $model = Palinka_storage::class;

    public function list(Request $request)
    {
        return $this->model::where('quantity', '>', 0)->get();
    }

    // public function create(Request $request)
    // {
    //     $data = $request->validate($this->model::$createRules);

    //     $model = $this->model::make();
    //     $model->fill($data);
    //     $model->save();
    //     return ["success" => true];
    // }

    public function delete(Request $request, $id)
    {
        $model = $this->model::find($id);
        if (!$model) throw new \Exception('A rekord nem található!');
        $content = "Pálinka raktár elemének eltávolítása: \nGyümölcs: " . $model['fruit_id'] . "\nMennyiség: " . $model['quantity'];
        $this->Logger(8, $content);
        $model->delete();
        return ["success" => true];
    }
}

//TODO: CRON JOB HA LECSÖKKEN AZ X LIMIT ALÁ AKKOR EMAIL AZONNAL AMUGY MEG HAVI STATISZTIKA EMAIL.
