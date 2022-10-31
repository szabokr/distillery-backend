<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Fruit;
use App\Models\Sold_product;
use App\Models\SoldProductStatistics;
use Illuminate\Http\Request;

class SoldProductsStatisticsController extends Controller
{
    public function list(Request $request)
    {
        $query = $request->query();
        $data = [];
        if ($request->has('year')) {
            $soldProductStatistics = SoldProductStatistics::whereYear('created_at', $query['year'])->get();
            $fruit_id = SoldProductStatistics::whereYear('created_at', $query['year'])->get()->groupBy('fruit_id');
        }

        if ($request->has('month')) {
            if (!$request->has('year') && $request->has('month')) {
                $query['year'] = date('Y');
            }
            $soldProductStatistics = SoldProductStatistics::whereYear('created_at', $query['year'])->whereMonth('created_at', $query['month'])->get();
            $fruit_id = SoldProductStatistics::whereYear('created_at', $query['year'])->whereMonth('created_at', $query['month'])->get()->groupBy('fruit_id');
        }

        if (!$request->has('year') && !$request->has('month')) {
            $soldProductStatistics = SoldProductStatistics::get();
            $fruit_id = SoldProductStatistics::get()->groupBy('fruit_id');
        }
        for ($i = 0; $i < count($fruit_id); $i++) {
            $data[$i]['fruit_id'] = $soldProductStatistics[$i]['fruit_id'];
            $data[$i]['quantity'] = 0;
            $data[$i]['income'] = 0;
            $data[$i]['expenditure'] = 0;

            for ($j = 0; $j < count($soldProductStatistics); $j++) {
                if ($soldProductStatistics[$i]['fruit_id'] == $soldProductStatistics[$j]['fruit_id']) {
                    // dd(($soldProductStatistics[0]['price']));
                    $data[$i]['quantity'] += $soldProductStatistics[$j]['quantity'];
                    $data[$i]['income'] += $soldProductStatistics[$j]['income'];
                    $data[$i]['expenditure'] += $soldProductStatistics[$j]['expenditure'];
                }
                $data[$i]['profit'] = $data[$i]['income'] - $data[$i]['expenditure'];
            }
        }
        return $data;
    }
}
