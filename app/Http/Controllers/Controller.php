<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\GeneralCategory;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function chekRole($role)
    {
        if (Auth::user()->role =='admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role =='owner') {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('login');
        }
    }


    public function explore()
    {

        $categories = GeneralCategory::where('name', '!=', 'private')->get();
        $documents = Document::where('type', 'general')->get();
        return view('guest.explore', compact('documents', 'categories'));
    }

    public function explore_filter(HttpRequest $request)
    {
        // dd($request->all());
        $categories = GeneralCategory::where('name', '!=', 'private')->get();
        $category = GeneralCategory::find($request->category);
        $documents = Document::where('type', 'general')->where('general_category_id', $request->category)->get();
        return view('guest.explore', compact('documents', 'categories'));
    }

    public function document($id)
    {
        $data = Document::find($id);
        return view('guest.document', compact('data'));
    }
}
