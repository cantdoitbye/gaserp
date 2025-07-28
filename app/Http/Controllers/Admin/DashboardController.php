<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\CancelledParcel;
use App\Models\User;
use App\Models\Rider;
use App\Models\ParcelRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Display a count of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        //
           

            $dateParams = filterDateParameters($r);
            $params = $dateParams['params'];
            $start = $dateParams['start'];
            $end = $dateParams['end'];
            $label = $dateParams['label'];

    
            $users = User::query();
        


       
        
         


            $users = dateFilter($users, $r, $start, $end);
          
           



            $params['total_users'] = $users->count();
   

    
            return view('panel.dashboard.index', $params);
      
    }

    public function dateFilter($query, $r, $start, $end) {
        if (isset($r->filterStartDate) && isset($r->filterEndDate) && $r->filterStartDate != '' && $r->filterEndDate != '') {
            $query->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end);
        }
        return $query;
    }

    public function getChartData($request, $query, $start, $end, $label) {
        if ($label == 'Today' || $label == 'Yesterday' || $label == 'Last 7 Days' || $label == 'Last 30 Days' || $label == 'This Month' || $label == 'Last Month' || $label == "Custom Range") {
            $query->groupBy(DB::raw('DATE(created_at)'));
            $query->orderBy(DB::raw('DATE(created_at)'));
        } elseif ($label == "This Year" || $label == "Last Year") {
            $query->groupBy(DB::raw('YEAR(created_at)'));
            $query->orderBy(DB::raw('YEAR(created_at)'));
        } elseif ($label == "Lifetime") {
            $query->groupBy(DB::raw('YEAR(created_at)'));
            $query->orderBy(DB::raw('YEAR(created_at)'));
        }
        $query->groupBy(DB::raw('DATE(created_at)'));
// $query->select(DB::raw('count(id) as count'), DB::raw('sum(amount) as sum'));

        $query->select(DB::raw('count(id) as count'),  DB::raw('sum(amount) as sum'), DB::raw('DATE(created_at) as date'));

        $result = $query->get()->toArray();
        
        $reportDate = $label;
        $reportStartDate = $start;
        $reportEndDate = $end;
        $rStart = '';
        $rEnd = '';
        $cat = [];
        $total = [];
        $ctotal = 0;
        if ($reportDate == "Today" || $reportDate == "Yesterday" || $reportDate == "Last 7 Days" || $reportDate == "Last 30 Days" || $reportDate == "Custom Range") {
            $date = date('Y-m-d', strtotime($reportStartDate));
            $end_date = date('Y-m-d', strtotime($reportEndDate));
            $rStart = date('D jS, M y', strtotime($date));
            $rEnd = $rEnd = " - " . date('D jS, M y', strtotime($end_date));
            while (strtotime($date) <= strtotime($end_date)) {
                $flag = 0;
                foreach ($result as $r) {
                    $val = date('Y-m-d', strtotime($r['date']));
                    if ($val == $date) {
                     
                        $cat[] = date('D jS, M y', strtotime($r['date']));
                        $ctotal = $ctotal + $r['sum'];
                        $total[] = $r['sum'];
//                        $total[] = $ctotal;
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0) {
                    $cat[] = date('D jS, M y', strtotime($date));
                    $total[] = 0;
//                    $total[] = $ctotal;
                }
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
        } elseif ($reportDate == 'This Month' || $reportDate == 'Last Month') {
            $start = Carbon::parse($reportStartDate)->startOfMonth()->format('j');
            $end = Carbon::parse($reportEndDate)->endOfMonth()->format('j');
            $rStart = Carbon::parse($reportStartDate)->startOfMonth()->format('jS M');
            $rEnd = " - " . Carbon::parse($reportEndDate)->endOfMonth()->format('jS M');
            if ($reportDate == 'This Month') {
                $start = Carbon::parse($reportStartDate)->startOfMonth()->format('j');
                $end = Carbon::parse($reportEndDate)->format('j');
                $rStart = Carbon::parse($reportStartDate)->startOfMonth()->format('jS M');
                $rEnd = " - " . Carbon::parse($reportEndDate)->format('jS M');
            }

            $month = date('Y-m', strtotime($reportStartDate));
            for ($i = $start; $i <= $end; $i++) {
                $curday = $month . "-" . $i;
                $flag = 0;
                foreach ($result as $r) {
                    $val = date('j', strtotime($r['date']));
                    if ($val == $i) {
                        $cat[] = date('D jS, M y', strtotime($r['date']));
                        $ctotal = $ctotal + $r['sum'];
                        $total[] = $r['sum'];
//                        $total[] = $ctotal;
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0) {
                    $cat[] = date('D jS, M y', strtotime($curday));
                    $total[] = 0;
//                    $total[] = $ctotal;
                }
            }
        } elseif ($reportDate == "This Year" || $reportDate == "Last Year") {
            $start = Carbon::parse($reportStartDate)->startOfYear()->format('n');
            $end = Carbon::parse($reportEndDate)->endOfYear()->format('n');
            if ($reportDate == "This Year") {
                $start = Carbon::parse($reportStartDate)->startOfYear()->format('n');
                $end = Carbon::parse($reportEndDate)->endOfMonth()->format('n');
            }
            $year = Carbon::parse($reportStartDate)->format('Y');
            $rStart = $year;
            $rEnd = '';
            for ($i = $start; $i <= $end; $i++) {
                $curday = $year . "-" . $i;
                $flag = 0;
                foreach ($result as $r) {
                    $val = date('n', strtotime($r['date']));
                    if ($val == $i) {
                        $cat[] = date('M,Y', strtotime($r['date']));
                        $ctotal = $ctotal + $r['sum'];
                        $total[] = $r['sum'];
//                        $total[] = $ctotal;
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0) {
                    $cat[] = date('M,Y', strtotime($curday));
                    $total[] = 0;
//                    $total[] = $ctotal;
                }
            }
        } elseif ($reportDate == "Lifetime") {

            $start = Carbon::parse($reportStartDate)->startOfYear()->format('Y');
            $end = Carbon::parse($reportEndDate)->endOfYear()->format('Y');

            $year = Carbon::parse($reportStartDate)->format('Y');
            $rStart = "Lifetime";
            $rEnd = '';
            for ($i = $start; $i <= $end; $i++) {
                $curday = $i;
                $flag = 0;
                foreach ($result as $r) {
                    $val = date('Y', strtotime($r['date']));
                    if ($val == $i) {
                      
                        $cat[] = date('Y', strtotime($r['date']));
                        $ctotal = $ctotal + $r['sum'];
                        $total[] = $r['sum'];
//                        $total[] = $ctotal;
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0) {
                    $cat[] = $curday;
                    $total[] = 0;
                //    $total[] = $ctotal;
                }
            }
        }
        return ['cat' => $cat, 'total' => $total, 'rangeDate' => $rStart . $rEnd];
    }

  }
