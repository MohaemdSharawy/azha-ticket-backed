<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $table = 'attachments';
    protected $fillable = [
        'form_id',
        'module_id',
        'file',
        'deleted'
    ];
    public $timestamps = false;
}
