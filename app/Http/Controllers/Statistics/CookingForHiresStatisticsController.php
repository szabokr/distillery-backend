<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Cooking_for_hire;
use App\Models\Cooking_for_hire_statistic;
use App\Models\Param;
use Illuminate\Http\Request;

class CookingForHiresStatisticsController extends Controller
{
    public function list(Request $request)
    {
        $query = $request->query();
        // $params = Param::get();
        // $capacity = $params[10]['value'] * 0.8;
        if ($request->has('year') && $request->has('month')) {
            $cookingForHireStatistics = Cooking_for_hire_statistic::where('own', 0)->whereYear('created_at', $query['year'])->whereMonth('created_at', $query['month'])->get()[0];
            unset($cookingForHireStatistics['id'], $cookingForHireStatistics['own'], $cookingForHireStatistics['date'], $cookingForHireStatistics['created_at'], $cookingForHireStatistics['updated_at']);
            // $cookingForHireStatistics['number_of_cooking'] = ceil($cookingForHireStatistics['mash'] / $capacity) + ceil($cookingForHireStatistics['unadjusted_palinka'] / $capacity);
            $cookingForHireStatistics['expenditure'] = $cookingForHireStatistics['used_gas_price'] + $cookingForHireStatistics['used_electricity_price'] + $cookingForHireStatistics['used_distilled_water_price'] + $cookingForHireStatistics['used_antifoam_price'];
            $cookingForHireStatistics['profit'] = $cookingForHireStatistics['income'] - ($cookingForHireStatistics['used_gas_price'] + $cookingForHireStatistics['used_electricity_price'] + $cookingForHireStatistics['used_distilled_water_price'] + $cookingForHireStatistics['used_antifoam_price']);
            return $cookingForHireStatistics;
        }
        $cookingForHireStatistics = Cooking_for_hire_statistic::where('own', 0)->get()->toArray();
        if ($request->has('year') && !$request->has('month')) {
            $cookingForHireStatistics = Cooking_for_hire_statistic::where('own', 0)->whereYear('created_at', $query['year'])->get()->toArray();
        }
        if ($cookingForHireStatistics != null) {
            for ($i = 0; $i < count($cookingForHireStatistics); $i++) {
                unset($cookingForHireStatistics[$i]['id'], $cookingForHireStatistics[$i]['own'], $cookingForHireStatistics[$i]['created_at'], $cookingForHireStatistics[$i]['updated_at'], $cookingForHireStatistics[$i]['date']);
            }
            $dataStatistics = $cookingForHireStatistics[0];
            $plusDataStatistics['expenditure'] = $cookingForHireStatistics[0]['used_gas_price'] + $cookingForHireStatistics[0]['used_electricity_price'] + $cookingForHireStatistics[0]['used_distilled_water_price'] + $cookingForHireStatistics[0]['used_antifoam_price'];
            $plusDataStatistics['profit'] = $cookingForHireStatistics[0]['income'] - ($cookingForHireStatistics[0]['used_gas_price'] + $cookingForHireStatistics[0]['used_electricity_price'] + $cookingForHireStatistics[0]['used_distilled_water_price'] + $cookingForHireStatistics[0]['used_antifoam_price']);
            unset($cookingForHireStatistics[0]);
            foreach ($cookingForHireStatistics as $index => $value) {
                foreach ($dataStatistics as $key => $dataValue) {
                    $dataStatistics[$key] += $cookingForHireStatistics[$index][$key];
                }
                $plusDataStatistics['expenditure'] += $cookingForHireStatistics[$index]['used_gas_price'] + $cookingForHireStatistics[$index]['used_electricity_price'] + $cookingForHireStatistics[$index]['used_distilled_water_price'] + $cookingForHireStatistics[$index]['used_antifoam_price'];
                $plusDataStatistics['profit'] += $cookingForHireStatistics[$index]['income'] - ($cookingForHireStatistics[$index]['used_gas_price'] + $cookingForHireStatistics[$index]['used_electricity_price'] + $cookingForHireStatistics[$index]['used_distilled_water_price'] + $cookingForHireStatistics[$index]['used_antifoam_price']);
            }
            return array_merge($dataStatistics, $plusDataStatistics);
        }
    }
}
