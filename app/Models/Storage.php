<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $key
 * @property float $value
 * @property string $updated_at
 */
class Storage extends Model
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
