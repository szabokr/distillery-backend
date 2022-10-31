<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $mail_key
 * @property string $sender
 * @property string $subject
 * @property string $content
 */
class MailContents extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['mail_key', 'sender', 'subject', 'content'];
}
