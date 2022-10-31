<?php

namespace App\Console\Commands;

use App\Http\Traits\MailerTrait;
use App\Models\Cooking_for_hire_statistic;
use App\Models\Fruit;
use App\Models\Param;
use App\Models\SoldProductStatistics;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Api;

class monthlyStatistics extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlyStatistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Havi statisztikák kiküldése';

    /**
     * Execute the console command.
     *
     * @return int
     */
    use MailerTrait;
    public function handle()
    {
        // dd(json_decode(Route::($request)));
        //TODO -1 data

        (date('m') - 1 == 0) ? $date = 1 : $date = date('m') - 1;

        $mailData = [
            'date' => date('Y.m') . ". havi",
        ];
        $mothlyCookingStatistics = Cooking_for_hire_statistic::where('own', 0)->whereMonth('created_at', $date + 1)->get()->toArray();
        if ($mothlyCookingStatistics != []) {
            $mailData += [
                'number_of_cooking' => $mothlyCookingStatistics[0]['number_of_cooking'],
                "mash" => $mothlyCookingStatistics[0]['mash'],
                "vodka" => $mothlyCookingStatistics[0]['vodka'],
                "unadjusted_palinka" => $mothlyCookingStatistics[0]['unadjusted_palinka'],
                "finished_palinka" => $mothlyCookingStatistics[0]['finished_palinka'],
                "income" => $mothlyCookingStatistics[0]['income'],
                'expenditure' => $mothlyCookingStatistics[0]['used_gas_price'] + $mothlyCookingStatistics[0]['used_electricity_price'] + $mothlyCookingStatistics[0]['used_distilled_water_price'] + $mothlyCookingStatistics[0]['used_antifoam_price'],
                "used_gas" => $mothlyCookingStatistics[0]['used_gas'],
                "used_gas_price" => $mothlyCookingStatistics[0]['used_gas_price'],
                "used_electricity" => $mothlyCookingStatistics[0]['used_electricity'],
                "used_electricity_price" => $mothlyCookingStatistics[0]['used_electricity_price'],
                "used_distilled_water" => $mothlyCookingStatistics[0]['used_distilled_water'],
                "used_distilled_water_price" => $mothlyCookingStatistics[0]['used_distilled_water_price'],
                "used_antifoam" => $mothlyCookingStatistics[0]['used_antifoam'],
                "used_antifoam_price" => $mothlyCookingStatistics[0]['used_antifoam_price'],
            ];
        } else {
            $mailData += [
                'number_of_cooking' => 0,
                "mash" => 0,
                "vodka" => 0,
                "unadjusted_palinka" => 0,
                "finished_palinka" => 0,
                "income" => 0,
                'expenditure' => 0,
                'profit' => 0,
                "used_gas" => 0,
                "used_gas_price" => 0,
                "used_electricity" => 0,
                "used_electricity_price" => 0,
                "used_distilled_water" => 0,
                "used_distilled_water_price" => 0,
                "used_antifoam" => 0,
                "used_antifoam_price" => 0,
            ];
        }

        $mothlyCookingStatistics = Cooking_for_hire_statistic::where('own', 1)->whereMonth('created_at', $date + 1)->get()->toArray();
        if ($mothlyCookingStatistics != []) {
            $mailData += [
                'number_of_cooking_own' => $mothlyCookingStatistics[0]['number_of_cooking'],
                "mash_own" => $mothlyCookingStatistics[0]['mash'],
                "vodka_own" => $mothlyCookingStatistics[0]['vodka'],
                "unadjusted_palinka_own" => $mothlyCookingStatistics[0]['unadjusted_palinka'],
                "finished_palinka_own" => $mothlyCookingStatistics[0]['finished_palinka'],
                "income_own" => $mothlyCookingStatistics[0]['income'],
                'expenditure_own' => $mothlyCookingStatistics[0]['used_gas_price'] + $mothlyCookingStatistics[0]['used_electricity_price'] + $mothlyCookingStatistics[0]['used_distilled_water_price'] + $mothlyCookingStatistics[0]['used_antifoam_price'],
                "used_gas_own" => $mothlyCookingStatistics[0]['used_gas'],
                "used_gas_price_own" => $mothlyCookingStatistics[0]['used_gas_price'],
                "used_electricity_own" => $mothlyCookingStatistics[0]['used_electricity'],
                "used_electricity_price_own" => $mothlyCookingStatistics[0]['used_electricity_price'],
                "used_distilled_water_own" => $mothlyCookingStatistics[0]['used_distilled_water'],
                "used_distilled_water_price_own" => $mothlyCookingStatistics[0]['used_distilled_water_price'],
                "used_antifoam_own" => $mothlyCookingStatistics[0]['used_antifoam'],
                "used_antifoam_price_own" => $mothlyCookingStatistics[0]['used_antifoam_price'],
                "fruit_price_own" => $mothlyCookingStatistics[0]['fruit_price'],
                "sugar_own" => $mothlyCookingStatistics[0]['sugar'],
                "sugar_price_own" => $mothlyCookingStatistics[0]['sugar_price'],
                "pectin_breaker_own" => $mothlyCookingStatistics[0]['pectin_breaker'],
                "pectin_breaker_price_own" => $mothlyCookingStatistics[0]['pectin_breaker_price'],
                "yeast_own" => $mothlyCookingStatistics[0]['yeast'],
                "yeast_price_own" => $mothlyCookingStatistics[0]['yeast_price'],
            ];
        } else {
            $mailData += [
                'number_of_cooking_own' => 0,
                "mash_own" => 0,
                "vodka_own" => 0,
                "unadjusted_palinka_own" => 0,
                "finished_palinka_own" => 0,
                "income_own" => 0,
                'expenditure_own' => 0,
                "used_gas_own" => 0,
                "used_gas_price_own" => 0,
                "used_electricity_own" => 0,
                "used_electricity_price_own" => 0,
                "used_distilled_water_own" => 0,
                "used_distilled_water_price_own" => 0,
                "used_antifoam_own" => 0,
                "used_antifoam_price_own" => 0,
                'fruit_price_own' => 0,
                'sugar_own' => 0,
                'sugar_price_own' => 0,
                'pectin_breaker_own' => 0,
                'pectin_breaker_price_own' => 0,
                'yeast_own' => 0,
                'yeast_price_own' => 0,
            ];
        }

        $soldProductStatistics = SoldProductStatistics::whereMonth('created_at', date('m'))->get();
        if ($soldProductStatistics != []) {

            $fruit_id = SoldProductStatistics::whereMonth('created_at', date('m'))->get()->groupBy('fruit_id');
            $count = count($fruit_id);
            $soldProductContent = "";
            for ($i = 0; $i < $count; $i++) {
                $fruit_id = $soldProductStatistics[$i]['fruit_id'];
                $quantity = 0;
                $income = 0;
                $expenditure = 0;

                for ($j = 0; $j < count($soldProductStatistics); $j++) {
                    if ($soldProductStatistics[$i]['fruit_id'] == $soldProductStatistics[$j]['fruit_id']) {
                        $quantity += $soldProductStatistics[$j]['quantity'];
                        $income += $soldProductStatistics[$j]['income'];
                        $expenditure += $soldProductStatistics[$j]['expenditure'];
                    }
                }

                $soldProductContent .= "<tr><td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . fruit::find($fruit_id)->fruit_name . "</td>" . "<td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . $quantity . " l</td>" . "<td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . $income . " Ft</td>" . "<td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . $expenditure . " Ft</td>" . "<td style='border-bottom:1px dotted black;'>" . $income - $expenditure . " Ft</td></tr>\n";
            }
            $users = User::where('status', 1)->get();
            foreach ($users as $key => $value) {
                $mailData += [
                    'soldProductContent' => $soldProductContent,
                    'email' => $value['email'],
                    'name' => $value['name'],
                ];
                $this->sendMail('cooking_for_hire_statistics', $value['email'], $mailData);
                $this->sendMail('sold_product_statistics', $value['email'], $mailData);
            }
        }
    }
}
