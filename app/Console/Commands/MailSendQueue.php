<?php

namespace App\Console\Commands;

use App\Mail\DesignRequestEmail;
use App\Models\MailQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailSendQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send_queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail In Queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        MailQueue::where(['send' => 0, 'deleted' => 0])->chunk(10, function ($queues) {
            foreach ($queues as $queue) {
                $data =  [
                    'subject' => 'Assigned  Ticket # ' . $queue->ticket_id,
                    'message' => 'You Assigned FOr Ticket #' . $queue->ticket_id . '<br> Waiting Your Response <br> Thank U',
                    'url'  => 'https://tickets.sunrise-resorts.com/ticket/show-model/' . $queue->ticket_id
                ];
                Mail::to($queue->address)->send(new DesignRequestEmail($data));
                $queue->send = 1;
                $queue->save();
            }
        });
    }
}
