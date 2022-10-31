<?php

namespace App\Http\Controllers\SoldProducts;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Models\Palinka_storage;
use App\Models\Sold_product;
use App\Models\SoldProductStatistics;
use Illuminate\Http\Request;

class SoldProductController extends Controller
{
    use LoggerTrait;

    public $model = Sold_product::class;

    public function list(Request $request)
    {
        return $this->model::get();
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->model::$createRules);
        $palinkaStorage = Palinka_storage::where('fruit_id', $data['fruit_id'])->first();

        if ($palinkaStorage == null) {
            return response()->json([
                'success' => false,
                'message' => "Nincs raktáron ilyen típusú pálinka!"
            ], 422);
        }
        if ($palinkaStorage['quantity'] - $data['quantity'] < 0) {
            return response()->json([
                'success' => false,
                'message' => "A raktáron nincs elég pálinka ebből a fajtából!"
            ], 422);
        }
        $palinkaStorage['quantity'] -= $data['quantity'];
        $data['expenditure'] = $palinkaStorage['expenditure'];
        $data['date'] = date('Y-m-d');
        $content = "Eladott termék felvitele: \nGyümölcs: " . $data['fruit_id'] . "\nMennyiség: " . $data['quantity'] . "\nEladási ár: " . $data['price'] . "\nKiadás: " . $data['expenditure'];

        ($palinkaStorage['quantity'] == $palinkaStorage['quantity'] - $data['quantity']) ? "" : $content .= "\n\nPálinka raktár módosítása: \nMennyiség: " . $palinkaStorage['quantity'] . " => " . $palinkaStorage['quantity'] - $data['quantity'];
        $SoldProductStatistics = SoldProductStatistics::where('fruit_id', $data['fruit_id'])->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->first();
        if ($SoldProductStatistics == null) {
            $SoldProductStatistics = SoldProductStatistics::make();
            $SoldProductStatistics['fruit_id'] = $data['fruit_id'];
        }
        $SoldProductStatistics['quantity'] += $data['quantity'];
        $SoldProductStatistics['income'] += $data['price'] * $data['quantity'];
        $SoldProductStatistics['expenditure'] += $data['expenditure'] * $data['quantity'];
        $SoldProductStatistics->save();
        $model = $this->model::make();
        
        $model->fill($data);
        $palinkaStorage->save();
        $this->Logger(10, $content);
        $model->save();
        return ["success" => true];
    }

    public function delete(Request $request, $id)
    {
        $model = $this->model::find($id);
        if (!$model) throw new \Exception('A rekord nem található!');
        $palinkaStorage = Palinka_storage::where('fruit_id', $model['fruit_id'])->first();
        $palinkaStorage['quantity'] += $model['quantity'];
        $content = "Eladott termék felvitele: \nGyümölcs: " . $model['fruit_id'] . "\nMennyiség: " . $model['quantity'] . "\nEladási ár: " . $model['price'] . "\nKiadás: " . $model['expenditure'] . "\nStátusz: " . $model['status'];
        ($palinkaStorage['quantity'] == $palinkaStorage['quantity'] + $model['quantity']) ? "" : $content .= "\n\nPálinka raktár módosítása: \nMennyiség: " . $palinkaStorage['quantity'] . " => " . $palinkaStorage['quantity'] + $model['quantity'];

        $SoldProductStatistics = SoldProductStatistics::whereYear('created_at', substr($model->created_at, 0, 4))->whereMonth('created_at', substr($model->created_at, 5, 8))->where('fruit_id', $model->fruit_id)->first();
        $SoldProductStatistics['quantity'] -= $model['quantity'];
        $SoldProductStatistics['income'] -= $model['price'] * $model['quantity'];
        $SoldProductStatistics['expenditure'] -= $model['expenditure'] * $model['quantity'];
        $SoldProductStatistics->save();

        $this->Logger(11, $content);
        $palinkaStorage->save();


        $model->delete();
        return ["success" => true];
    }
}
