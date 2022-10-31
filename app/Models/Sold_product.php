<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $fruit_id
 * @property float $quantity
 * @property integer $price
 * @property integer $profit
 * @property integer $expenditure
 * @property string $created_at
 * @property string $updated_at
 * @property Fruit $fruit
 */
class Sold_product extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['fruit_id', 'quantity', 'price', 'profit', 'expenditure', 'date', 'created_at', 'updated_at'];

    public static $createRules = [
        'fruit_id' => 'required',
        'quantity' => 'required',
        'price' => 'required',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fruit()
    {
        return $this->belongsTo('App\Models\Fruit');
    }
}
