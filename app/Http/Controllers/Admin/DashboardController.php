<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $total_dokumen_umum = Document::where('type', 'general')->count();
        $total_dokumen_pribadi = Document::where('type', 'private')->where('user_id', auth()->user()->id)->count();
        return view('admin.dashboard', compact('total_dokumen_umum', 'total_dokumen_pribadi'));
    }
}
