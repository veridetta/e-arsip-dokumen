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
        return view('user.dashboard', compact('categories', 'documents'));
    }

    public function filter(Request $request)
    {
        $categories = GeneralCategory::where('name', '!=', 'private')->get();
        $category = GeneralCategory::find($request->category);
        $documents = Document::where('type', 'general')->where('general_category_id', $request->category)->get();
        return view('user.dashboard', compact('categories', 'category', 'documents'));
    }

    //document
    public function document($id)
    {
        $data = Document::find($id);
        return view('user.document', compact('data'));
    }

}
