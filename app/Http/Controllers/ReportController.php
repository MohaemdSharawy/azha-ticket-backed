<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\Ticket;
use App\Models\status;
use App\Traits\General;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use App\Models\Service;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function top_ten_index()
    {
        $hotels = Hotels::whereIn('id',  $this->getUserHotel())->get();
        return view('reports.index_top_ten', compact('hotels'));
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
        if ($request->report_type == 'department_report') {
            $mpdf->WriteHtml($this->departmentReport($request));
        } else if ($request->report_type == 'top_ten') {
            $mpdf->WriteHtml($this->topTen($request));
        } else {

            $mpdf->WriteHtml($this->DailyReport($request));
        }
        // $mpdf->WriteHtml($this->DailyReport($request));
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

        $departments = Ticket::select('to_dep')->where(['hid' => $request->hid, 'deleted' => 0])->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->distinct('to_dep')->get();
        $department_count = [];
        $department_names = [];
        $department_count_guest =  [];
        foreach ($departments as $department) {
            $department_name =  Department::find($department->to_dep);
            $count_of_Ticket  = Ticket::where(['to_dep' => $department->to_dep, 'hid' => $request->hid, 'deleted' => 0])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->whereIn('type_id', [2, 3, 4, 5, 8, 9])->count();
            $count_of_guest_ticket = Ticket::where(['to_dep' => $department->to_dep, 'hid' => $request->hid, 'deleted' => 0, 'type_id' => 1,])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->count();

            array_push($department_count, $count_of_Ticket);
            array_push($department_names, $department_name->dep_name);
            array_push($department_count_guest, $count_of_guest_ticket);
        }
        // dd($request->from_date);
        $admin_request =  Ticket::with(['facility', 'to_department', 'services', 'status'])
            ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
            ->where(['hid' => $request->hid, 'deleted' => 0])->whereIn('type_id', [2, 3, 4, 5, 8, 9])->get();

        $guest_request =  Ticket::with(['facility', 'to_department', 'services', 'status'])
            ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)

            ->where(['type_id' => 1, 'hid' => $request->hid, 'deleted' => 0])->get();




        $hotel = Hotels::find($request->hid);
        // dd($hotel->logo);
        $title =  'Details GSC Report ';
        $from_title = ' From:' . $request->from_date;
        $to_title = ' To : ' . $request->to_date;
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

    private function topTen(Request $request)
    {
        $admin = [];
        $guest = [];
        $hotel = Hotels::find($request->hid);
        $currentMonth = date('Y-m', strtotime($request->from_date));
        $previousMonth = date("Y-m", strtotime("-1 month", strtotime($request->from_date)));
        $currentMonthName = date('M', strtotime($request->from_date));
        $previousMonthName = date("M", strtotime("-1 month", strtotime($request->from_date)));
        $admin_services = Ticket::select('service_id', DB::raw('COUNT(service_id) as count'),)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '{$currentMonth}'")
            ->groupBy('service_id')
            ->orderByDesc('count')
            ->where(['hid' => $request->hid,  'deleted' => 0])
            ->whereIn('type_id', [2, 3, 4, 5, 8, 9])
            ->limit(10)
            ->get();
        foreach ($admin_services as $key => $admin_service) {
            $admin[$key]['service_id'] = $admin_service->service_id;
            $admin[$key]['service_name']  =  Service::find($admin_service->service_id)->name;
            $admin[$key]['current'] = $admin_service->count;
            $admin[$key]['previous'] =  Ticket::where(['service_id' => $admin_service->service_id])
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '{$previousMonth}'")->whereIn('type_id', [2, 3, 4, 5, 8, 9])->where(['hid' => $request->hid,  'deleted' => 0])->count();
        }
        $gust_services = Ticket::select('service_id', DB::raw('COUNT(service_id) as count'))
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '{$currentMonth}'")
            ->groupBy('service_id')
            ->orderByDesc('count')
            ->where(['type_id' => 1, 'hid' => $request->hid,  'deleted' => 0])
            ->limit(10)
            ->get();
        foreach ($gust_services as $key => $gust_service) {
            $guest[$key]['service_id'] = $gust_service->service_id;
            $guest[$key]['service_name']  =  Service::find($gust_service->service_id)->name;
            $guest[$key]['current'] = $gust_service->count;
            $guest[$key]['previous'] =  Ticket::where(['service_id' => $gust_service->service_id])
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '{$previousMonth}'")->where(['type_id' => 1, 'hid' => $request->hid,  'deleted' => 0])->count();
        }

        $title =  'Top 10 Report';
        $from_title =  $request->from_date;
        $to_title = $request->to_date;

        return view('reports.tickets.top_ten_report', compact(
            'title',
            'hotel',
            'from_title',
            'to_title',
            'currentMonthName',
            'previousMonthName',
            'admin',
            'guest'
        ));
    }

    private function topTenYearly()
    {
    }

    private function workerPerformance()
    {
    }

    public function index_department()
    {
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->get();
        $departments =  Department::all();
        $status = status::all();
        return view('reports.index_department_report', compact('hotels', 'departments', 'status'));
    }

    private  $department_query;

    private function departmentReport($request)
    {

        $show_counter  = true;
        $stats_count =  0;
        $confirmed =  0;
        $completed = 0;
        $in_progress  = 0;
        $not_start = 0;

        $ticket_query = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
            ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
            ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid);

        if ($request->status_id) {
            $ticket_query->where(['status_id' => $request->status_id]);
            $show_counter = false;
            $stats_count = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid)->where('status_id',  $request->status_id)->count();
        }


        $tickets_hotel =  $ticket_query->get()->groupBy(function ($data) {
            return $data->hotels->code;
        });


        $department = Department::find($request->dep_id);
        $title = $department->dep_name . '  Summary Report';

        if (!$request->status_id) {
            $confirmed = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid)->where('status_id', 4)->count();
            $completed = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid)->where('status_id', 3)->count();
            $in_progress = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid)->where('status_id', 2)->count();
            $not_start = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
                ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
                ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid)->where('status_id', 1)->count();
        }


        $title =  'Department  Report (' . $department->dep_name . ')';
        $from_title = ' From:' . $request->from_date;
        $to_title = ' To : ' . $request->to_date;
        return view('reports.tickets.department_pdf', compact(
            'tickets_hotel',
            'title',
            'confirmed',
            'in_progress',
            'completed',
            'not_start',
            'from_title',
            'to_title',
            'show_counter',
            'stats_count'
            // 'tasks',
        ));
    }


    public function excel_department(Request $request)
    {


        /////Start Sheet Version/ /////
        // $ticket_query = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
        //     ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
        //     ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid);


        // $tickets_hotel =  $ticket_query->get()->groupBy(function ($data) {
        //     return $data->hotels->code;
        // });



        // $spreadsheet = new Spreadsheet();
        // $sheetIndex = 0;

        // foreach ($tickets_hotel as $groupName => $groupTicket) {
        //     $spreadsheet->createSheet();
        //     $spreadsheet->setActiveSheetIndex($sheetIndex);

        //     $spreadsheet->getActiveSheet()->setTitle($groupName);

        //     $row = 1;
        //     foreach ($groupTicket as $ticket) {

        //         if ($row  == 1) {
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "ID");
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'Hotel Name');
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'Service');
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'Task Name');
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $row, 'Size');
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 'status');
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 'Create');
        //         } else {
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $ticket->id);
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $ticket->hotels->hotel_name);
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $ticket->services->name);
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $ticket->design_task);
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $ticket->status->name);
        //             $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $ticket->created_at);
        //         }
        //         $row++;
        //     }
        //     $sheetIndex++;
        // }

        // $writer = new Xlsx($spreadsheet);

        ////////End Sheet Version ////////


        $ticket_query = Ticket::with(['facility', 'to_department', 'services', 'status', 'hotels'])
            ->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)
            ->where(['to_dep' => $request->dep_id, 'deleted' => 0])->whereIn('hid', $request->hid);


        $tickets_hotel =  $ticket_query->get();



        $spreadsheet = new Spreadsheet();
        $sheetIndex = 0;

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex($sheetIndex);

        $spreadsheet->getActiveSheet()->setTitle('Tickets');

        $row = 1;
        foreach ($tickets_hotel as $ticket) {

            if ($row  == 1) {
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "ID");
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'Hotel Code');
                // $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'Service');
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'Task Name');
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $row, 'Size');
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 'status');
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 'Create');
            } else {
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $ticket->id);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $ticket->hotels->code);
                // $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $ticket->services->name);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $ticket->design_task);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $ticket->status->name);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $ticket->created_at);
            }
            $row++;
        }
        $sheetIndex++;


        $writer = new Xlsx($spreadsheet);




        // $sheet = $spreadsheet->getActiveSheet();
        // $activeWorksheet->setCellValue('A1', 'Hello World !');

        // $row = 1;
        // foreach ($tickets_hotel as $ticket) {
        //     if ($row  == 1) {
        //         $sheet->setCellValueByColumnAndRow(1, $row, 'Id');
        //         $sheet->setCellValueByColumnAndRow(2, $row, 'Hotel');
        //     } else {
        //         $sheet->setCellValueByColumnAndRow(1, $row, $ticket->id);
        //         $sheet->setCellValueByColumnAndRow(2, $row, $ticket->hotels->hotel_name);
        //     }
        //     $row++;
        // }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Ticket.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean();
        $writer->save('php://output');
    }

    public function index_annul_report()
    {
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->get();
        return view('reports.annual_index', compact('hotels'));
    }

    public function annual_service(Request $request)
    {


        $mpdf = new Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetWatermarkText('Sunrise Ticket');
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHtml($this->annul_data($request->hid));
        // $mpdf->WriteHtml($this->topTen($request));

        // if ($request->type == 'Daily Report') {
        // } elseif ($request->type == 'Top 10') {
        //     $mpdf->WriteHtml($this->topTen());
        // }
        $mpdf->setFooter('{PAGENO}');
        $mpdf->Output();
    }


    private function annul_data($hotel_id)
    {
        $services  =  Service::where(['deleted' => 0, 'disable' => 0])->get();
        $months =  ['Jan', 'Feb', 'Mar',  'Apr',  'May', 'Jun', 'Jul',  'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $hotel =  Hotels::find($hotel_id);
        return view('reports.tickets.annuel_service', compact('services', 'hotel_id', 'months', 'hotel'));
    }
}
