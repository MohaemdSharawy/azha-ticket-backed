<?php

namespace App\Console\Commands;

use App\Mail\GscDaily;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Mpdf\Mpdf;


class GscDepartment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gsc:department';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->departments() as $department) {
            $this->generateReport($department->id, $department->dep_name);
            $this->SendMails($department->id, $department->dep_name);
        }
    }
    //
    //     Get Notified Department
    //
    private function departments()
    {
        return Department::where(['deleted' => 0, 'notify' => 1])->get();
    }
    //
    //          Create Report
    //
    //
    private function generateReport($department_id, $department_name)
    {

        $mpdf = new Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetWatermarkText('Sunrise Ticket');
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHtml($this->departmentReport($department_id));
        $mpdf->setFooter('{PAGENO}');
        $mpdf->Output('public/department_report/' . $department_name . '.pdf', 'F');
    }


    private function departmentReport($department_id)
    {

        $ticket_query = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->where(['to_dep' => $department_id, 'deleted' => 0]);




        $tickets_hotel =  $ticket_query->get()->groupBy(function ($data) {
            return $data->hotels->hotel_name;
        });


        $department = Department::find($department_id);
        $title = $department->dep_name . '  Summary Report';
        $confirmed = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->where(['to_dep' => $department_id, 'deleted' => 0])->where('status_id', 4)->count();
        $completed = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->where(['to_dep' => $department_id, 'deleted' => 0])->where('status_id', 3)->count();
        $in_progress = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->where(['to_dep' => $department_id, 'deleted' => 0])->where('status_id', 2)->count();
        $not_start = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))
            ->where(['to_dep' => $department_id, 'deleted' => 0])->where('status_id', 1)->count();

        $title =  'Department  Report (' . $department->dep_name . ')';
        $from_title = ' From:' . date('Y-m-d', strtotime('-1 day'));
        $to_title = ' To : ' . date('Y-m-d', strtotime('-1 day'));
        return view('reports.tickets.department_pdf', compact(
            'tickets_hotel',
            'title',
            'confirmed',
            'in_progress',
            'completed',
            'not_start',
            'from_title',
            'to_title'
        ));
    }



    private function get_user_department_ids(int $department_id)
    {
        $users = UserDepartment::where(['dep_id' => $department_id])->pluck('user_id')->toArray();
        return $users;
    }

    private function get_user_emails($department_id)
    {
        return User::whereIn('id', $this->get_user_department_ids($department_id))->get()->whereNotNull('email')->pluck('email')->toArray();
    }


    private function SendMails($department_id, $department_name)
    {
        $data['attach'] = [public_path('department_report/' . $department_name . '.pdf')];
        $data['subject'] =  'Department Report ' . date('Y-m-d', strtotime('-1 day')) . ' ' . $department_name;
        $data['url'] = 'https://tickets.sunrise-resorts.com';
        $data['to'] = $this->get_user_emails($department_id);
        // $data['to'] = ['mohamed.sharawy@sunrise-resorts.com'];
        $data['message']  = 'Department Report ' . date('Y-m-d', strtotime('-1 day'));
        if (count($data['to']) > 0   && file_exists(public_path('department_report/' . $department_name . '.pdf'))) {
            Mail::send(new GscDaily($data));
        }
    }
}
