<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $fruit_name
 * @property string $created_at
 * @property string $updated_at
 * @property CookingForHire[] $cookingForHires
 * @property MashStorage[] $mashStorages
 * @property PalinkaStorage[] $palinkaStorages
 * @property SoldProduct[] $soldProducts
 */
class Fruit extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['fruit_name', 'created_at', 'updated_at'];

    public static $createRules = [
        'fruit_name' => 'required|unique:fruits|max:30',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cookingForHires()
    {
        return $this->hasMany('App\Models\CookingForHire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mashStorages()
    {
        return $this->hasMany('App\Models\MashStorage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palinkaStorages()
    {
        return $this->hasMany('App\Models\PalinkaStorage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soldProducts()
    {
        return $this->hasMany('App\Models\SoldProduct');
    }
}
