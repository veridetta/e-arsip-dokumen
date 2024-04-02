<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\GeneralCategory;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function profile()
    {
        $data = User::find(Auth::user()->id);
        return view('profile', compact('data'));
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        //cek email duplikat
        $cek_email = User::where('email', $request->email)->where('id', '!=', $id)->count();
        if($cek_email > 0){
            return redirect()->route('profile')->with('message', [
                'success' => false,
                'message' => 'Email sudah digunakan'
            ]);
        }

        $simpan = User::find($id);
        if($request->password){
            $request->validate([
                'password' => 'required',
            ]);
            $simpan->password = bcrypt($request->password);
        }

        $simpan->name = $request->name;
        $simpan->email = $request->email;
        $simpan = $simpan->save();

        if($simpan){
            return redirect()->route('profile')->with('message', [
                'success' => true,
                'message' => 'User berhasil diubah'
            ]);
        }else{
            return redirect()->route('profile')->with('message', [
                'success' => false,
                'message' => 'User gagal diubah'
            ]);
        }
    }

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
