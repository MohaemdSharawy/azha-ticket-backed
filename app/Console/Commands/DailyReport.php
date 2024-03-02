<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Mail;
use App\Models\MailSetup;
use App\Mail\GscDaily;

class DailyReport extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gsc:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Report And Send To Mail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hotels = Hotels::where(['deleted' => 0])->get();
        foreach ($hotels as $hotel) {
            $mpdf = new Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetWatermarkText('Sunrise Ticket');
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->WriteHtml($this->DailyReport($hotel->id));
            $mpdf->setFooter('{PAGENO}');
            $mpdf->Output('public/gsc_report/' . $hotel->hotel_name . '.pdf', 'F');
            $this->SendMails($hotel);
        }
    }

    private function DailyReport($hid)
    {


        $departments = Ticket::select('to_dep')->where(['hid' => $hid])->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->distinct('to_dep')->get();
        $department_count = [];
        $department_names = [];
        $department_count_guest =  [];
        foreach ($departments as $department) {
            $department_name =  Department::find($department->to_dep);
            $count_of_Ticket  = Ticket::where(['to_dep' => $department->to_dep, 'hid' => $hid, 'deleted' => 0])
                ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))
                ->whereIn('type_id', [2, 3, 4, 5, 8, 9])->count();
            $count_of_guest_ticket = Ticket::where(['to_dep' => $department->to_dep, 'hid' => $hid, 'deleted' => 0, 'type_id' => 1,])
                ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))
                ->count();

            array_push($department_count, $count_of_Ticket);
            array_push($department_names, $department_name->dep_name);
            array_push($department_count_guest, $count_of_guest_ticket);
        }
        $admin_request =  Ticket::with(['facility', 'to_department', 'services', 'status'])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->where(['hid' => $hid])->whereIn('type_id', [2, 3, 4, 5, 8, 9])->get();
        $guest_request =  Ticket::with(['facility', 'to_department', 'services', 'status'])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))
            ->where(['type_id' => 1, 'hid' => $hid])->get();




        $hotel = Hotels::find($hid);


        $title =  'Details GSC Report ';
        $from_title = ' From:' .  date('Y-m-d', strtotime('-1 day'));
        $to_title = ' To : ' .  date('Y-m-d', strtotime('-1 day'));
        return view('reports.tickets.Daily_Report', compact(
            'department_count',
            'admin_request',
            'guest_request',
            'department_names',
            'hotel',
            'title',
            'from_title',
            'to_title',
            'department_count_guest'
        ));
    }


    private function SendMails($hotel)
    {
        $data['attach'] = [public_path('gsc_report/' . $hotel->hotel_name . '.pdf')];
        $data['url'] = 'https://tickets.sunrise-resorts.com';
        $data['to'] = MailSetup::where(['hid' => $hotel->id])->pluck('mail')->toArray();
        // $data['to'] = ['hany.hisham@sunrise-resorts.com'];
        $data['message']  = 'Daily Report ' . date('Y-m-d', strtotime('-1 day'));
        $data['subject'] =  'Gsc Daily ' . date('Y-m-d', strtotime('-1 day')) . ' ' . $hotel->code;
        if (count($data['to']) > 0   && file_exists(public_path('gsc_report/' . $hotel->hotel_name . '.pdf'))) {
            Mail::send(new GscDaily($data));
        }
    }
}
