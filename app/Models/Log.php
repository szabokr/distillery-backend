<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Log extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'type', 'content', 'created_at', 'updated_at'];
}
