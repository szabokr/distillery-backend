<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $temperature
 * @property float $correction
 */
class Correction extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['temperature', 'correction'];
}
