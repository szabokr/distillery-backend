<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $key
 * @property integer $value
 * @property string $updated_at
 */
class Param extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['key', 'value', 'updated_at'];

    public static $updateRules = [
        'key' => 'required',
        'value' => 'required',
    ];
}
