<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\Ticket;
use App\Traits\General;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;


class ReportController extends Controller
{
    use General;


    public function index()
    {
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->get();
        return view('reports.index_ticket_reports', compact('hotels'));
    }


    public function index_worker()
    {
        $hotels = Hotels::whereIn('id',  $this->getUserHotel())->get();
        return view('reports.index_worker_reports', compact('hotels'));
    }



    public function TicketReports(Request $request)
    {

        $mpdf = new Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetWatermarkText('Sunrise Ticket');
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHtml($this->DailyReport($request));
        // $mpdf->WriteHtml($this->topTen($request));

        // if ($request->type == 'Daily Report') {
        // } elseif ($request->type == 'Top 10') {
        //     $mpdf->WriteHtml($this->topTen());
        // }
        $mpdf->setFooter('{PAGENO}');
        $mpdf->Output();
    }

    // public function

    private function DailyReport(Request $request)
    {
        //from -- to   -- hid
        // whereDate('created_at', '>=', $this->filters['from']);
        // whereDate('created_at', '<=', $this->filters['to']);

        // ->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->from_date)))->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->from_date)))

        // $from = date('Y-m-d', strtotime($request->from_data . ' - 1 days'));
        // $to = date('Y-m-d', strtotime($request->to_data . ' + 1 days'));
        // dd(date('Y-m-d', strtotime($request->from_date)));
        // ->whereBetween('created_at', [$from, $to]);

        $departments = Ticket::select('to_dep')->where(['hid' => $request->hid])->distinct('to_dep')->get();
        $department_count = [];
        $department_names = [];
        foreach ($departments as $department) {
            $department_name =  Department::find($department->to_dep);
            $count_of_Ticket  = Ticket::where(['to_dep' => $department->to_dep, 'hid' => $request->hid])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->count();
            array_push($department_count, $count_of_Ticket);
            array_push($department_names, $department_name->dep_name);
        }
        // dd($request->from_date);
        $admin_request =  Ticket::with(['facility', 'to_department', 'services', 'status'])
            ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)

            ->where(['hid' => $request->hid])->whereIn('type_id', [2, 3, 4])->get();
        $guest_request =  Ticket::with(['facility', 'to_department', 'services', 'status'])
            ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)

            ->where(['type_id' => 1, 'hid' => $request->hid])->get();




        $hotel = Hotels::find($request->hid);

        return view('reports.tickets.Daily_Report', compact(
            'department_count',
            'admin_request',
            'guest_request',
            'department_names',
            'hotel',
        ));
    }

    private function topTen(Request $request)
    {
        // dd();
        $current_month  = Ticket::where(['hid' => $request->hid])->whereMonth('created_at', $request->month)
            ->whereYear('created_at', date('Y'))->select('service_id', DB::raw('count(*) as service_count'))
            ->groupBy('service_id')->orderByDesc('service_count')->limit(10)->get();
    }

    private function topTenYearly()
    {
    }

    private function workerPerformance()
    {
    }
}
