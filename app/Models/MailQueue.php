<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MailQueue extends Model
{
    use HasFactory;
    protected $table = 'mails_queues';
    protected $fillable = [
        'address', 'ticket_id', 'send', 'deleted'

    ];
    public $timestamps = false;

    public function cc()
    {
        return $this->hasMany(MailViewer::class, 'mail_id');
    }


    public static function mail_inbox()
    {
        return DB::table('mail_queue')->select('mail_queue.*', 'ticket.description')->where(function ($query) {
            $query->where('from', Auth::user()->email)
                ->orWhere('to', Auth::user()->email);
        })->where('mail_queue.deleted', 0)->leftJoin('ticket', 'ticket.id', '=', 'mail_queue.survey_id');
    }


    public static function mail_star()
    {
        return DB::table('mail_queue')->select('mail_queue.*', 'ticket.description')->where(function ($query) {
            $query->where('from', Auth::user()->email)
                ->orWhere('to', Auth::user()->email);
        })->where(['starred' => 1])->where('mail_queue.deleted', 0)->leftJoin('ticket', 'ticket.id', '=', 'mail_queue.survey_id');
    }

    public static function send_mail()
    {
        return DB::table('mail_queue')->select('mail_queue.*', 'ticket.description')->where('from', Auth::user()->email)
            ->where('mail_queue.deleted', 0)->leftJoin('ticket', 'ticket.id', '=', 'mail_queue.survey_id');
    }

    public static function deleted_mail()
    {
        return DB::table('mail_queue')->select('mail_queue.*', 'ticket.description')->where(function ($query) {
            $query->where('from', Auth::user()->email)
                ->orWhere('to', Auth::user()->email);
        })->where(['mail_queue.deleted' => 1])->leftJoin('ticket', 'ticket.id', '=', 'mail_queue.survey_id');
    }
}
