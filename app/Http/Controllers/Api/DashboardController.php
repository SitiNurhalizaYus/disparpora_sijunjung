<?php

namespace App\Http\Controllers\Api;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('topPageNonAdmin','getStatistikBulanan');
    }

    public function topPageNonAdmin(Request $request)
    {
        // Query untuk mengambil halaman selain admin
        $query = Log::where('path', 'not like', '%admin%')
            ->groupBy('path')
            ->selectRaw('path, count(*) as total')
            ->orderBy('total', 'desc')
            ->get()
            ->toArray();

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        }

        // Result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successful', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function getStatistikBulanan()
    {
        // Query untuk mendapatkan jumlah kunjungan berdasarkan bulan
        $data = DB::table('logs')
            ->select(DB::raw('MONTHNAME(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function topPage(Request $request)
    {
        // query
        $query = Log::groupBy('path')->selectRaw('path, count(*) as total')->orderBy('total', 'desc')->get()->toArray();

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function topDevice(Request $request)
    {
        // query
        $queryDesktop = Log::selectRaw('count(*) as total')->where('is_desktop', '1')->get();
        $queryMobile = Log::selectRaw('count(*) as total')->where('is_mobile', '1')->get();
        $queryTablet = Log::selectRaw('count(*) as total')->where('is_tablet', '1')->get();

        $data = [];
        $metadata = [];

        $tempDesktop = [
            'device' => 'Desktop',
            'total' => $queryDesktop[0]['total']
        ];
        array_push($data, $tempDesktop);

        $queryMobile = [
            'device' => 'Mobile',
            'total' => $queryMobile[0]['total']
        ];
        array_push($data, $queryMobile);

        $queryTablet = [
            'device' => 'Tablet',
            'total' => $queryTablet[0]['total']
        ];
        array_push($data, $queryTablet);

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function topOs(Request $request)
    {
        // query
        $query = Log::groupBy('os')->selectRaw('os, count(*) as total')->orderBy('total', 'desc')->get()->toArray();

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function topBrowser(Request $request)
    {
        // query
        $query = Log::groupBy('browser')->selectRaw('browser, count(*) as total')->orderBy('total', 'desc')->get()->toArray();

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function topCountry(Request $request)
    {
        // query
        $query = Log::groupBy('country_name')->selectRaw('country_name, count(*) as total')->whereRaw('country_name is not null and country_name != ""')->orderBy('total', 'desc')->limit(10)->get()->toArray();

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }


    public function topCity(Request $request)
    {
        // query
        $query = Log::groupBy('city_name')->selectRaw('city_name, count(*) as total')->whereRaw('city_name is not null and city_name != ""')->orderBy('total', 'desc')->limit(10)->get()->toArray();

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function accessDaily(Request $request)
    {
        // query
        $query = DB::select("
            SELECT
                (SELECT DATE_FORMAT(created_at, '%Y-%m-%d') FROM logs where created_at is not null ORDER BY created_at desc LIMIT 1) - INTERVAL seq-1 DAY  AS dates,
                (select count(*) from logs where date(created_at) = dates) as count
            FROM seq_31_to_1
        ");

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            $temp->dates_indo = \App\Helpers\AppHelper::instance()->convertDateIndo($temp->dates);
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }

    public function accessMonthly(Request $request)
    {
        // query
        $query = DB::select("
            SELECT
                (SELECT DATE_FORMAT(created_at, '%Y-%m-01') FROM logs where created_at is not null ORDER BY created_at desc LIMIT 1) - INTERVAL seq-1 MONTH  AS months,
                (select count(*) from logs where YEAR(created_at) = YEAR(months) and MONTH(created_at) = MONTH(months)) as count
            FROM seq_12_to_1
        ");

        $data = [];
        $metadata = [];
        foreach ($query as $qry) {
            $temp = $qry;
            $temp->months_indo = \App\Helpers\AppHelper::instance()->convertMonthIndo($temp->months);
            array_push($data, $temp);
        };

        // result
        if ($data) {
            return new ApiResource(true, 200, 'Get data successfull', $data, $metadata);
        } else {
            return new ApiResource(false, 200, 'No data found', [], $metadata);
        }
    }
}
