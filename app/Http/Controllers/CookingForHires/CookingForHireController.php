<?php

namespace App\Http\Controllers\CookingForHires;

use App\Http\Controllers\Controller;
use App\Http\Traits\LoggerTrait;
use App\Models\Cooking_for_hire;
use App\Models\Cooking_for_hire_statistic;
use App\Models\Correction;
use App\Models\Fruit;
use App\Models\Mash_storage;
use App\Models\Palinka_storage;
use App\Models\Param;
use App\Models\Storage;
use Illuminate\Http\Request;

class CookingForHireController extends Controller
{
    use LoggerTrait;

    public $model = Cooking_for_hire::class;

    public function list(Request $request)
    {
        return $this->model::where('status', 1)->get();
    }


    public function create(Request $request)
    {
        $data = $request->validate($this->model::$createRules);
        //ASAD
        $params = Param::get();
        $correction = Correction::where('temperature', $request->temperature)->first()->correction;
        $data['finished_palinka'] = $data['unadjusted_palinka'] * ($data['original_alcohol_degree'] + $correction) / $data['alcohol_degree'];
        $capacity = $params[10]['value'] * 0.8;
        $data['number_of_cooking'] = ceil($data['mash'] / $capacity) + ceil($data['unadjusted_palinka'] / $capacity);
        $message = "Raktáron nincs elég";
        $distilledWater = Storage::where('key', 'distilled_water')->first();
        if (($distilledWater['value'] - ($data['finished_palinka'] - $data['unadjusted_palinka'])) < 0) {
            $message .= " desztilált víz,";
        }
        $antifoam = Storage::where('key', 'antifoam')->first();
        $fruit = Fruit::find($data['fruit_id']);
        $usedAntifoamPrice = 0;
        $usedAntifoam = 0;
        if (str_contains(strtolower($fruit['fruit_name']), 'meggy') || str_contains(strtolower($fruit['fruit_name']), 'cseresznye')) {
            if (($antifoam['value'] - 10 < 0)) {
                $message .= " habzásgátló,";
            }
            $usedAntifoamPrice = ($params[4]['value'] / 5 * 2) * ceil(($data['mash'] / 100));
            $usedAntifoam = 10 * ceil(($data['mash'] / 100));
            $antifoam['value'] -= 10 * ($data['mash'] / 100);
        }
        if ($message != "Raktáron nincs elég") {
            $message = substr($message, 0, -1) . "!";
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }
        $usedDistilledWater = $data['finished_palinka'] - $data['unadjusted_palinka'];
        $distilledWater['value'] -= $usedDistilledWater;

        $cookingPrice = $params[0]['value'];
        $distilledWaterPrice = $params[2]['value'] / 5;
        $gasPrice = $params[5]['value'];
        $electricityPrice = $params[6]['value'];
        $usedGas = $params[8]['value'];
        $usedElectricity = $params[9]['value'];

        $data['income'] = ($data['own'] == 0) ? $data['finished_palinka'] * $cookingPrice : 0;
        $data['expenditure'] = $usedAntifoamPrice + ($usedDistilledWater * $distilledWaterPrice) + $data['number_of_cooking'] * (($gasPrice * $usedGas + $electricityPrice * $usedElectricity));
        $ownCooked = $this->model::where('own', 1)->where('fruit_id', $data['fruit_id'])->get();
        $allExpenditure = 0;
        $allQuantity = 0;
        foreach ($ownCooked as  $value) {
            $allExpenditure += $value['expenditure'];
            $allQuantity += $value['finished_palinka'];
        }
        $cookingForHireStatistics = (Cooking_for_hire_statistic::where('own', $data['own'])->OrderBy('date', 'desc')->first());
        if ($cookingForHireStatistics == null || substr($cookingForHireStatistics->date, 0, 7) != substr(date('Y-m-d'), 0, 7)) {
            $cookingForHireStatistics = Cooking_for_hire_statistic::make();
        }
        $logCookingForHireStatisticsContent =
            "\nBérfőzés statisztika: " .
            "\nDátum: " . $cookingForHireStatistics['date'] .
            "\nCefre mennyisége: " . $cookingForHireStatistics['mash'] . " => " . $cookingForHireStatistics['mash'] + $data['mash'] .
            "\nVodka mennyisége: " . $cookingForHireStatistics['vodka'] . " => " . $cookingForHireStatistics['vodka'] + $data['vodka'] .
            "\nNem bekevert pálinka mennyisége: " . $cookingForHireStatistics['unadjusted_palinka'] . " => " . $cookingForHireStatistics['unadjusted_palinka'] + $data['unadjusted_palinka'] .
            "\nBekevert pálinka mennyisége: " . $cookingForHireStatistics['finished_palinka'] . " => " . $cookingForHireStatistics['finished_palinka'] + $data['finished_palinka'] .
            "\nElhasznált desztilált víz: " . $cookingForHireStatistics['used_distilled_water'] . " => " . $cookingForHireStatistics['used_distilled_water'] + $usedDistilledWater .
            "\nElhasznált desztilált víz ár: " . $cookingForHireStatistics['used_distilled_water'] . " => " . $cookingForHireStatistics['used_distilled_water_price'] + $usedDistilledWater * $distilledWaterPrice .
            "\nElhasznált habzásgátló: " . $cookingForHireStatistics['used_antifoam'] . " => " . $cookingForHireStatistics['used_antifoam'] + $usedAntifoam .
            "\nElhasznált habzásgátló ár: " . $cookingForHireStatistics['used_antifoam_price'] . " => " . $cookingForHireStatistics['used_antifoam_price'] + $usedAntifoamPrice .
            "\nBevétel: " . $cookingForHireStatistics['income'] . " => " . $cookingForHireStatistics['income'] + $data['income'] .
            "\nElhasznált gáz: " . $cookingForHireStatistics['used_gas'] . " => " . $cookingForHireStatistics['used_gas'] + $usedGas * $data['number_of_cooking'] .
            "\nElhasznált gáz ár: " . $cookingForHireStatistics['used_gas_price'] . " => " . $cookingForHireStatistics['used_gas_price'] + $usedGas * $data['number_of_cooking'] * $gasPrice .
            "\nElhasznált áram: " . $cookingForHireStatistics['used_electricity'] . " => " . $cookingForHireStatistics['used_electricity'] + $data['number_of_cooking'] * $usedElectricity .
            "\nElhasznált áram ár: " . $cookingForHireStatistics['used_electricity_price'] . " => " . $cookingForHireStatistics['used_electricity_price'] + $data['number_of_cooking'] * $usedElectricity * $electricityPrice;

        $cookingForHireStatistics['date'] = date('Y-m-d');
        $cookingForHireStatistics['mash'] += $data['mash'];
        $cookingForHireStatistics['vodka'] += $data['vodka'];
        $cookingForHireStatistics['unadjusted_palinka'] += $data['unadjusted_palinka'];
        $cookingForHireStatistics['finished_palinka'] += $data['finished_palinka'];
        $cookingForHireStatistics['used_distilled_water'] += $usedDistilledWater;
        $cookingForHireStatistics['used_distilled_water_price'] += $usedDistilledWater * $distilledWaterPrice;
        $cookingForHireStatistics['used_antifoam'] += $usedAntifoam;
        $cookingForHireStatistics['used_antifoam_price'] += $usedAntifoamPrice;
        $cookingForHireStatistics['income'] += $data['income'];
        $cookingForHireStatistics['number_of_cooking'] += $data['number_of_cooking'];
        $cookingForHireStatistics['used_gas'] += $usedGas * $data['number_of_cooking'];
        $cookingForHireStatistics['used_gas_price'] += $usedGas * $data['number_of_cooking'] * $gasPrice;
        $cookingForHireStatistics['used_electricity'] += $data['number_of_cooking'] * $usedElectricity;
        $cookingForHireStatistics['used_electricity_price'] += $data['number_of_cooking'] * $usedElectricity * $electricityPrice;
        $logPalinkaStorageContent = "";
        $logMashStorageContent = "";

        $cookingForHireStatistics['own'] = $data['own'];
        $content = "Bérfőzés felvitele: \nGyümölcs: " . $data['fruit_id'] . "\nCefre mennyisége: " . $data['mash'] . "\nVodka: " . $data['vodka'] . "\nKeveretlen pálinka: " . $data['unadjusted_palinka'] . "\nBekevert pálinka: " . $data['finished_palinka'] . "\nKívánt alkohol fok: " . $data['alcohol_degree'] . "\nEredeti alkoholfok: " . $data['original_alcohol_degree'] . "\nHőmérséklet" . $data['temperature'] . "\nBevétel: " . $data['income'] . "\nKiadás: " . $data['expenditure'];
        if ($data['own'] == 1) {
            $ownData = $request->validate($this->model::$ownCreateRules);
            $sugarPrice = $params[1]['value'];
            $pectinBreakerPrice = $params[3]['value'];
            $yeastPrice = $params[7]['value'];

            //TODO: LIST kell hogy a cooked =0 jelenjenek csak meg
            $mashStorage = Mash_storage::where('id', $ownData['mash_storage_id'])->where('cooked', 0)->first();
            $data['expenditure'] += $mashStorage['fruit_price'] + $mashStorage['sugar'] * $sugarPrice + $mashStorage['pectin_breaker'] * $pectinBreakerPrice + $mashStorage['yeast'] * $yeastPrice;
            $palinkaStorage = (Palinka_storage::where('fruit_id', $data['fruit_id'])->first() == null) ? Palinka_storage::make() : Palinka_storage::where('fruit_id', $data['fruit_id'])->first();

            $logPalinkaStorageContent = "\n\nPálinka raktár módosítása: \nMennyisége: " . $palinkaStorage['quantity'] . " => " . $palinkaStorage['quantity'] + $data['finished_palinka'] . "\nKiadás literenként: " . $palinkaStorage['expenditure'] . " => " . ($allExpenditure + $data['expenditure']) / ($data['finished_palinka'] + $allQuantity);
            $palinkaStorage->fruit_id = $data['fruit_id'];
            $palinkaStorage->quantity += $data['finished_palinka'];
            $palinkaStorage->expenditure = ($allExpenditure + $data['expenditure']) / ($data['finished_palinka'] + $allQuantity);
            $palinkaStorage->save();


            $logMashStorageContent = "\n\nCefre raktár: \nCefre azonosítója: " . $mashStorage['mash_storage_id'] . "\nKifőzve: " . $mashStorage['cooked'] . " => 1";
            $mashStorage['cooked'] = 1;
            $mashStorage->save();
            $data['mash_storage_id'] = $ownData['mash_storage_id'];

            $logCookingForHireStatisticsContent =
                "\nGyümölcs ára: " . $cookingForHireStatistics['fruit_price'] . " => " . $cookingForHireStatistics['fruit_price'] + $mashStorage['fruit_price'] .
                "\nCukor: " . $cookingForHireStatistics['sugar'] . " => " . $cookingForHireStatistics['sugar'] + $mashStorage['sugar'] .
                "\nCukor ára: " . $cookingForHireStatistics['sugar_price'] . " => " . $cookingForHireStatistics['sugar_price'] + $mashStorage['sugar'] * $sugarPrice .
                "\nPektinbontó: " . $cookingForHireStatistics['pectin_breaker'] . " => " . $cookingForHireStatistics['pectin_breaker'] + $mashStorage['pectin_breaker'] .
                "\nPektinbontó ára: " . $cookingForHireStatistics['pectin_breaker_price'] . " => " . $cookingForHireStatistics['pectin_breaker_price'] + $mashStorage['pectin_breaker'] * $pectinBreakerPrice .
                "\nÉlesztő: " . $cookingForHireStatistics['yeast'] . " => " . $cookingForHireStatistics['yeast'] + $mashStorage['yeast'] .
                "\nÉlesztő ára: " . $cookingForHireStatistics['yeast_price'] . " => " . $cookingForHireStatistics['yeast_price'] + $mashStorage['yeast'] * $yeastPrice;

            $cookingForHireStatistics['fruit_price'] += $mashStorage['fruit_price'];
            $cookingForHireStatistics['sugar'] += $mashStorage['sugar'];
            $cookingForHireStatistics['sugar_price'] += $mashStorage['sugar'] * $sugarPrice;
            $cookingForHireStatistics['pectin_breaker'] += $mashStorage['pectin_breaker'];
            $cookingForHireStatistics['pectin_breaker_price'] += $mashStorage['pectin_breaker'] * $pectinBreakerPrice;
            $cookingForHireStatistics['yeast'] += $mashStorage['yeast'];
            $cookingForHireStatistics['yeast_price'] += $mashStorage['yeast'] * $yeastPrice;
        }
        $content .= $logPalinkaStorageContent . $logMashStorageContent . $logCookingForHireStatisticsContent;
        $this->Logger(12, $content);
        $model = $this->model::make();
        $cookingForHireStatistics->save();
        $model->fill($data);
        $antifoam->save();
        $distilledWater->save();
        $model->save();
        return ["success" => true];
    }

    public function delete(Request $request, $id)
    {
        $model = $this->model::find($id);
        if (!$model) throw new \Exception('A rekord nem található!');
        $params = Param::get();
        $cookingForHireStatistics = Cooking_for_hire_statistic::where('own', $model['own'])->OrderBy('date', 'desc')->first();
        $distilledWater = storage::where('key', 'distilled_water')->first();
        $logStorageContent = "Raktár módosítása:\nDesztilált víz: " . $distilledWater['value'] . " => " . $distilledWater['value'] + $model['finished_palinka'] - $model['unadjusted_palinka'];
        $distilledWater['value'] -= $model['finished_palinka'] - $model['unadjusted_palinka'];
        $usedDistilledWater = $model['finished_palinka'] - $model['unadjusted_palinka'];

        $capacity = $params[10]['value'] * 0.8;
        $numberOfCooking = ceil($model['mash'] / $capacity) + ceil($model['unadjusted_palinka'] / $capacity);

        $cookingPrice = $params[0]['value'];
        $distilledWaterPrice = $params[2]['value'] / 5;
        $gasPrice = $params[5]['value'];
        $electricityPrice = $params[6]['value'];
        $usedGas = $params[8]['value'];
        $usedElectricity = $params[9]['value'];

        $logContent = "Bérfőzés törlése:" .
            "\nGyümölcs: " . $model['fruit_id'] .
            "\nCefre mennyisége: " . $model['mash'] .
            "\nNem bekevert mennyisége: " . $model['unadjusted_palinka'] .
            "\nBekevert mennyisége: " . $model['finished_palinka'] .
            "\nAlkohol fok: " . $model['alcohol_degree'] .
            "\nEredeti alkohol fok: " . $model['original_alcohol_degree'] .
            "\nHőmérséklet: " . $model['temperature'] .
            "\nBevétel: " . $model['income'] .
            "\nKiadás: " . $model['expenditure'] .
            "\nKidás: " . $model['expenditure'] .
            "\nSaját főzés: " . $model['own'];
        "\nCefre egyedi azonosítója: " . $model['mash_storage_id'];

        $fruit = Fruit::find($model['fruit_id']);
        $usedAntifoam = 0;
        $usedAntifoamPrice = 0;
        if (str_contains(strtolower($fruit['fruit_name']), 'meggy') || str_contains(strtolower($fruit['fruit_name']), 'cseresznye')) {
            $antifoam = Storage::where('key', 'antifoam')->first();
            $logStorageContent .= "\nHabzásgátló: " . $antifoam['value'] . " => " . $antifoam['value'] + ceil($model['mash'] / 100) * 10;
            $antifoam['value'] += ceil($model['mash'] / 100) * 10;
            $usedAntifoamPrice = ($params[4]['value'] / 5 * 2) * ceil(($model['mash'] / 100));
            $antifoam->save();
        }

        $cookingForHireStatistics['mash'] -= $model['mash'];
        $cookingForHireStatistics['vodka'] -= $model['vodka'];
        $cookingForHireStatistics['unadjusted_palinka'] -= $model['unadjusted_palinka'];
        $cookingForHireStatistics['finished_palinka'] -= $model['finished_palinka'];
        $cookingForHireStatistics['used_distilled_water'] -= $usedDistilledWater;
        $cookingForHireStatistics['used_distilled_water_price'] -= $usedDistilledWater * $distilledWaterPrice;
        $cookingForHireStatistics['used_antifoam'] -= $usedAntifoam;
        $cookingForHireStatistics['used_antifoam_price'] -= $usedAntifoamPrice;
        $cookingForHireStatistics['income'] -= $model['income'];
        $cookingForHireStatistics['used_gas'] -= $usedGas * $numberOfCooking;
        $cookingForHireStatistics['used_gas_price'] -= $usedGas * $numberOfCooking * $gasPrice;
        $cookingForHireStatistics['used_electricity'] -= $numberOfCooking * $usedElectricity;
        $cookingForHireStatistics['used_electricity_price'] -= $numberOfCooking * $usedElectricity * $electricityPrice;

        if ($model['own'] == 1) {
            $mashStorage = Mash_storage::find($model['mash_storage_id']);
            $logContent .= "\nKifőzve: " . $mashStorage['cooked'] . " => " . "0";
            $mashStorage['cooked'] = 0;

            $ownCooked = $this->model::where('own', 1)->where('fruit_id', $model['fruit_id'])->get();
            $allExpenditure = 0;
            $allQuantity = 0;
            foreach ($ownCooked as  $value) {
                $allExpenditure += $value['expenditure'];
                $allQuantity += $value['finished_palinka'];
            }

            $palinkaStorage = Palinka_storage::where('fruit_id', $model['fruit_id'])->OrderBy('created_at', 'desc')->first();
            $palinkaStorage->quantity -= $model['finished_palinka'];
            $palinkaStorage->expenditure = ($allExpenditure - $model['expenditure']) / ($allQuantity - $model['finished_palinka']);
            $palinkaStorage->save();

            $sugarPrice = $params[1]['value'];
            $pectinBreakerPrice = $params[3]['value'];
            $yeastPrice = $params[7]['value'];

            $cookingForHireStatistics['fruit_price'] -= $mashStorage['fruit_price'];
            $cookingForHireStatistics['sugar'] -= $mashStorage['sugar'];
            $cookingForHireStatistics['sugar_price'] -= $mashStorage['sugar'] * $sugarPrice;
            $cookingForHireStatistics['pectin_breaker'] -= $mashStorage['pectin_breaker'];
            $cookingForHireStatistics['pectin_breaker_price'] -= $mashStorage['pectin_breaker'] * $pectinBreakerPrice;
            $cookingForHireStatistics['yeast'] -= $mashStorage['yeast'];
            $cookingForHireStatistics['yeast_price'] -= $mashStorage['yeast'] * $yeastPrice;
            $mashStorage->save();
        }

        $this->logger(13, $logContent);
        $distilledWater->save();
        $cookingForHireStatistics->save();
        $model->delete();
        return ["success" => true];
    }
}
