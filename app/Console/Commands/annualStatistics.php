<?php

namespace App\Console\Commands;

use App\Http\Traits\MailerTrait;
use App\Models\Cooking_for_hire_statistic;
use App\Models\Fruit;
use App\Models\SoldProductStatistics;
use App\Models\User;
use Illuminate\Console\Command;

class annualStatistics extends Command
{
    use MailerTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'annualStatistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Éves statisztika kiküldése';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mailData = [
            'date' => date('Y') . ". évi",
        ];
        $yearCookingStatistics = Cooking_for_hire_statistic::where('own', 0)->whereYear('created_at', date('Y'))->get()->toArray();
        // dd($yearCookingStatistics);
        if ($yearCookingStatistics != []) {
            $data = $yearCookingStatistics[0];
            $data['expenditure'] = $yearCookingStatistics[0]['used_gas_price'] + $yearCookingStatistics[0]['used_electricity_price'] + $yearCookingStatistics[0]['used_distilled_water_price'] + $yearCookingStatistics[0]['used_antifoam_price'];;
            for ($i = 1; $i < count($yearCookingStatistics); $i++) {
                $data['number_of_cooking'] += $yearCookingStatistics[$i]['number_of_cooking'];
                $data['mash'] += $yearCookingStatistics[$i]['mash'];
                $data['vodka'] += $yearCookingStatistics[$i]['vodka'];
                $data['unadjusted_palinka'] += $yearCookingStatistics[$i]['unadjusted_palinka'];
                $data['finished_palinka'] += $yearCookingStatistics[$i]['finished_palinka'];
                $data['income'] += $yearCookingStatistics[$i]['income'];
                $data['expenditure'] += $yearCookingStatistics[$i]['used_gas_price'] + $yearCookingStatistics[$i]['used_electricity_price'] + $yearCookingStatistics[$i]['used_distilled_water_price'] + $yearCookingStatistics[$i]['used_antifoam_price'];
                $data['used_gas'] += $yearCookingStatistics[$i]['used_gas'];
                $data['used_gas_price'] += $yearCookingStatistics[$i]['used_gas_price'];
                $data['used_electricity'] += $yearCookingStatistics[$i]['used_electricity'];
                $data['used_electricity_price'] += $yearCookingStatistics[$i]['used_electricity_price'];
                $data['used_distilled_water'] += $yearCookingStatistics[$i]['used_distilled_water'];
                $data['used_distilled_water_price'] += $yearCookingStatistics[$i]['used_distilled_water_price'];
                $data['used_antifoam'] += $yearCookingStatistics[$i]['used_antifoam'];
                $data['used_antifoam_price'] += $yearCookingStatistics[$i]['used_antifoam_price'];
            }


            $mailData += [
                'number_of_cooking' => $data['number_of_cooking'],
                "mash" => $data['mash'],
                "vodka" => $data['vodka'],
                "unadjusted_palinka" => $data['unadjusted_palinka'],
                "finished_palinka" => $data['finished_palinka'],
                "income" => $data['income'],
                'expenditure' => $data['expenditure'],
                'profit' => $data['income'] - $data['expenditure'],
                "used_gas" => $data['used_gas'],
                "used_gas_price" => $data['used_gas_price'],
                "used_electricity" => $data['used_electricity'],
                "used_electricity_price" => $data['used_electricity_price'],
                "used_distilled_water" => $data['used_distilled_water'],
                "used_distilled_water_price" => $data['used_distilled_water_price'],
                "used_antifoam" => $data['used_antifoam'],
                "used_antifoam_price" => $data['used_antifoam_price'],
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

        $yearCookingStatistics = Cooking_for_hire_statistic::where('own', 1)->whereYear('created_at', date('Y'))->get()->toArray();
        if ($yearCookingStatistics != []) {
            $data = $yearCookingStatistics[0];
            $data['expenditure'] = $yearCookingStatistics[0]['used_gas_price'] + $yearCookingStatistics[0]['used_electricity_price'] + $yearCookingStatistics[0]['used_distilled_water_price'] + $yearCookingStatistics[0]['used_antifoam_price'];;
            for ($i = 1; $i < count($yearCookingStatistics); $i++) {
                $data['number_of_cooking'] += $yearCookingStatistics[$i]['number_of_cooking'];
                $data['mash'] += $yearCookingStatistics[$i]['mash'];
                $data['vodka'] += $yearCookingStatistics[$i]['vodka'];
                $data['unadjusted_palinka'] += $yearCookingStatistics[$i]['unadjusted_palinka'];
                $data['finished_palinka'] += $yearCookingStatistics[$i]['finished_palinka'];
                $data['income'] += $yearCookingStatistics[$i]['income'];
                $data['expenditure'] += $yearCookingStatistics[$i]['used_gas_price'] + $yearCookingStatistics[$i]['used_electricity_price'] + $yearCookingStatistics[$i]['used_distilled_water_price'] + $yearCookingStatistics[$i]['used_antifoam_price'];
                $data['used_gas'] += $yearCookingStatistics[$i]['used_gas'];
                $data['used_gas_price'] += $yearCookingStatistics[$i]['used_gas_price'];
                $data['used_electricity'] += $yearCookingStatistics[$i]['used_electricity'];
                $data['used_electricity_price'] += $yearCookingStatistics[$i]['used_electricity_price'];
                $data['used_distilled_water'] += $yearCookingStatistics[$i]['used_distilled_water'];
                $data['used_distilled_water_price'] += $yearCookingStatistics[$i]['used_distilled_water_price'];
                $data['used_antifoam'] += $yearCookingStatistics[$i]['used_antifoam'];
                $data['used_antifoam_price'] += $yearCookingStatistics[$i]['used_antifoam_price'];
                $data['fruit_price'] += $yearCookingStatistics[$i]['fruit_price'];
                $data['sugar'] += $yearCookingStatistics[$i]['sugar'];
                $data['sugar_price'] += $yearCookingStatistics[$i]['sugar_price'];
                $data['pectin_breaker'] += $yearCookingStatistics[$i]['pectin_breaker'];
                $data['pectin_breaker_price'] += $yearCookingStatistics[$i]['pectin_breaker_price'];
                $data['yeast_price'] += $yearCookingStatistics[$i]['yeast_price'];
                $data['yeast_price'] += $yearCookingStatistics[$i]['yeast_price'];
            }
            $mailData += [
                'number_of_cooking_own' => $data['number_of_cooking'],
                "mash_own" => $data['mash'],
                "vodka_own" => $data['vodka'],
                "unadjusted_palinka_own" => $data['unadjusted_palinka'],
                "finished_palinka_own" => $data['finished_palinka'],
                'expenditure_own' => $data['expenditure'],
                "used_gas_own" => $data['used_gas'],
                "used_gas_price_own" => $data['used_gas_price'],
                "used_electricity_own" => $data['used_electricity'],
                "used_electricity_price_own" => $data['used_electricity_price'],
                "used_distilled_water_own" => $data['used_distilled_water'],
                "used_distilled_water_price_own" => $data['used_distilled_water_price'],
                "used_antifoam_own" => $data['used_antifoam'],
                "used_antifoam_price_own" => $data['used_antifoam_price'],
                "fruit_price_own" => $data['fruit_price'],
                "sugar_own" => $data['sugar'],
                "sugar_price_own" => $data['sugar_price'],
                "pectin_breaker_own" => $data['pectin_breaker'],
                "pectin_breaker_price_own" => $data['pectin_breaker_price'],
                "yeast_own" => $data['yeast'],
                "yeast_price_own" => $data['yeast_price'],
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
        $soldProductStatistics = SoldProductStatistics::whereYear('created_at', date('Y'))->get();
        if ($soldProductStatistics != null) {
            $fruit_id = SoldProductStatistics::whereYear('created_at', date('Y'))->get()->groupBy('fruit_id');
            $count = count($fruit_id);
            $soldProductContent = "";
            for ($i = 0; $i < $count; $i++) {
                $fruit_id = $soldProductStatistics[$i]['fruit_id'];
                $quantity = 0;
                $income = 0;
                $expenditure = 0;

                for ($j = 0; $j < count($soldProductStatistics); $j++) {
                    if ($soldProductStatistics[$i]['fruit_id'] == $soldProductStatistics[$j]['fruit_id']) {
                        // dd(($soldProductStatistics[0]['price']));
                        $quantity += $soldProductStatistics[$j]['quantity'];
                        $income += $soldProductStatistics[$j]['income'];
                        $expenditure += $soldProductStatistics[$j]['expenditure'];
                    }
                }

                $soldProductContent .= "<tr><td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . Fruit::find($fruit_id)->fruit_name . "</td>" . "<td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . $quantity . " l</td>" . "<td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . $income . " Ft</td>" . "<td style='border-bottom:1px dotted black; border-right:1px dotted black;'>" . $expenditure . " Ft</td>" . "<td style='border-bottom:1px dotted black;'>" . $income - $expenditure . " Ft</td></tr>\n";
            }
            $mailData +=
                [
                    'soldProductContent' => $soldProductContent,
                ];
            $users = User::where('status', 1)->get();
            $users = User::where('status', 1)->get();
            foreach ($users as $key => $value) {
                $mailData += [
                    'email' => $value['email'],
                    'name' => $value['name'],
                ];
                $this->sendMail('cooking_for_hire_statistics', $value['email'], $mailData);
                $this->sendMail('sold_product_statistics', $value['email'], $mailData);
            }
        }
    }
}
