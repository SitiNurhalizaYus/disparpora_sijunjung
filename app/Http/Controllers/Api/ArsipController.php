<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArsipController extends Controller
{
    public function getArchives()
    {
        $archives = Content::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Menambahkan nama bulan untuk tampilan
        foreach ($archives as $archive) {
            $archive->month_name = Carbon::create()->month($archive->month)->format('F');
        }

        return response()->json([
            'success' => true,
            'data' => $archives
        ]);
    }
}
