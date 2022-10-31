<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $fruit_id
 * @property integer $mash_storage_id
 * @property integer $mash
 * @property integer $number_of_cooking
 * @property float $vodka
 * @property float $unadjusted_palinka
 * @property float $finished_palinka
 * @property integer $alcohol_degree
 * @property integer $original_alcohol_degree
 * @property integer $temperature
 * @property float $used_distilled_water
 * @property integer $income
 * @property integer $expenditure
 * @property integer $profit
 * @property boolean $own
 * @property string $created_at
 * @property string $updated_at
 * @property MashStorage $mashStorage
 * @property Fruit $fruit
 */
class Cooking_for_hire extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['fruit_id', 'mash_storage_id', 'mash', 'number_of_cooking', 'vodka', 'unadjusted_palinka', 'finished_palinka', 'alcohol_degree', 'original_alcohol_degree', 'temperature', 'used_distilled_water', 'income', 'expenditure', 'profit', 'own', 'created_at', 'updated_at'];

    public static $createRules = [
        'fruit_id' => 'required',
        'mash' => 'required',
        'vodka' => 'required',
        'unadjusted_palinka' => 'required',
        'alcohol_degree' => 'required',
        'original_alcohol_degree' => 'required',
        'temperature' => 'required',
        'own' => 'required',
    ];

    public static $ownCreateRules = [
        'mash_storage_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mashStorage()
    {
        return $this->belongsTo('App\Models\MashStorage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fruit()
    {
        return $this->belongsTo('App\Models\Fruit');
    }
}
