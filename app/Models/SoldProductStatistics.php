<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $fruit_id
 * @property integer $quantity
 * @property integer $income
 * @property integer $expenditure
 * @property string $created_at
 * @property string $updated_at
 * @property Fruit $fruit
 */
class SoldProductStatistics extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['fruit_id', 'quantity', 'income', 'expenditure', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fruit()
    {
        return $this->belongsTo('App\Models\Fruit');
    }
}
