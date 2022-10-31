<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $fruit_id
 * @property integer $fruit_price
 * @property integer $fruit_quantity
 * @property integer $mash
 * @property integer $sugar
 * @property integer $pectin_breaker
 * @property integer $water
 * @property integer $yeast
 * @property boolean $cooked
 * @property string $created_at
 * @property string $updated_at
 * @property CookingForHire[] $cookingForHires
 * @property Fruit $fruit
 */
class Mash_storage extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['fruit_id', 'fruit_price', 'fruit_quantity', 'mash', 'sugar', 'pectin_breaker', 'water', 'yeast', 'cooked', 'created_at', 'updated_at'];

    public static $createRules = [
        'fruit_id' => 'required',
        'fruit_price' => 'required',
        'mash' => 'required',
        'sugar' => 'required',
        'pectin_breaker' => 'required',
        'water' => 'required',
        'yeast' => 'required',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cookingForHires()
    {
        return $this->hasMany('App\Models\CookingForHire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fruit()
    {
        return $this->belongsTo('App\Models\Fruit');
    }
}
