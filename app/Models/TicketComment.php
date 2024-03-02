<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;
    protected $table = 'ticket_comment';
    protected $fillable = [
        'uid',
        'ticket_id',
        'comment',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'uid');
    }


    public function CommentAttachment()
    {
        return $this->hasMany(Attachment::class, 'form_id')->where('module_id', 9);
    }

    public function Ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
