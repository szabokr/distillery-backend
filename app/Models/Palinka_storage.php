<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $fruit_id
 * @property float $quantity
 * @property integer $sale_price
 * @property integer $profit
 * @property integer $expenditure
 * @property string $created_at
 * @property string $updated_at
 * @property Fruit $fruit
 */
class Palinka_storage extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['fruit_id', 'quantity', 'sale_price', 'profit', 'expenditure', 'created_at', 'updated_at'];

    public static $createRules = [
        'fruit_id' => 'required',
        'quantity' => 'required',
        'expenditure' => 'required',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fruit()
    {
        return $this->belongsTo('App\Models\Fruit');
    }
}
