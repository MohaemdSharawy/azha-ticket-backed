<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailViewer extends Model
{
    use HasFactory;
    protected $table = 'mail_viewer';
    protected $fillable =  [
        'mail_id',
        'uid'
    ];

    public function Users()
    {
        return $this->belongsTo(User::class, 'uid');
    }
}
