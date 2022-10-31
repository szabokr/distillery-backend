<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $own
 * @property integer $number_of_cooking
 * @property integer $mash
 * @property float $vodka
 * @property float $unadjusted_palinka
 * @property float $finished_palinka
 * @property integer $income
 * @property integer $used_gas
 * @property integer $used_gas_price
 * @property integer $used_electricity
 * @property integer $used_electricity_price
 * @property float $used_distilled_water
 * @property integer $used_distilled_water_price
 * @property float $used_antifoam
 * @property integer $used_antifoam_price
 * @property integer $fruit_price
 * @property integer $sugar
 * @property integer $sugar_price
 * @property integer $pectin_breaker
 * @property integer $pectin_breaker_price
 * @property integer $yeast
 * @property integer $yeast_price
 */
class Cooking_for_hire_statistic extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = [
        'own',
        'number_of_cooking',
        'mash',
        'vodka',
        'unadjusted_palinka',
        'finished_palinka',
        'income',
        'expenditure',
        'profit',
        'used_gas',
        'used_gas_price',
        'used_electricity',
        'used_electricity_price',
        'used_distilled_water',
        'used_distilled_water_price',
        'used_antifoam',
        'used_antifoam_price',
        'fruit_price',
        'sugar',
        'sugar_price',
        'pectin_breaker',
        'pectin_breaker_price',
        'yeast',
        'yeast_price'
    ];
}
