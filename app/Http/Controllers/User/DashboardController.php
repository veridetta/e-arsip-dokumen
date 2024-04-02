<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\GeneralCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $categories = GeneralCategory::where('name', '!=', 'private')->get();
        $documents = Document::where('type', 'general')->get();
        // dd($documents);
        $total_dokumen_pribadi = Document::where('type', 'private')->where('user_id', auth()->user()->id)->count();
        return view('user.dashboard', compact('categories', 'documents', 'total_dokumen_pribadi'));
    }

    public function filter(Request $request)
    {
        $categories = GeneralCategory::where('name', '!=', 'private')->get();
        $category = GeneralCategory::find($request->category);
        $documents = Document::where('type', 'general')->where('general_category_id', $request->category)->get();
        $total_dokumen_pribadi = Document::where('type', 'private')->where('user_id', auth()->user()->id)->count();
        return view('user.dashboard', compact('categories', 'category', 'documents', 'total_dokumen_pribadi'));
    }

    //document
    public function document($id)
    {
        $data = Document::find($id);
        return view('user.document', compact('data'));
    }

}
