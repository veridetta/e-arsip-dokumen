<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\GeneralCategory;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetRequestController extends Controller
{
    public function index()
    {
        $data = DocumentRequest::where('user_id', auth()->user()->id)->get();
        return view('admin.get_requests.index', compact('data'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('admin.get_requests.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'to'=>'required',
            'message'=>'required',
        ]);

        $simpan = new DocumentRequest();
        $simpan->document_id = NULL;
        $simpan->user_id = auth()->user()->id;
        $simpan->to = $request->to;
        $simpan->message = $request->message;
        $simpan->status = 'pending';
        $simpan->expired = NULL;
        $simpan->save();

        //kirim notifikasi ke user yang dituju
        //kirim notifikasi ke user
        $notif = new Notification();
        $notif->to = $simpan->to;
        $notif->from = auth()->user()->id;
        $notif->content = 'Anda mendapat request dokumen dari ' . auth()->user()->name;
        $notif->save();

        if($simpan){
            return redirect()->route('admin.get-requests.index')->with('message', [
                'success' => true,
                'message' => 'Request sent successfully'
            ]);
        }else{
            return redirect()->route('admin.get-requests.create')->with('message', [
                'success' => false,
                'message' => 'Request failed to send'
            ]);
        }
    }

    public function show($id)
    {
        $data = Document::findOrFail($id);
        $requests = DocumentRequest::where('document_id', $id)->get();
        return view('admin.get_requests.show', compact('data', 'requests'));
    }

    public function edit($id)
    {
        $data = Document::findOrFail($id);
        return view('admin.get_requests.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);


        $simpan = Document::findOrFail($id);
        if($request->file('file')){
            $request->validate([
                'file' => 'required|mimes:doc,docx,pdf,xls,xlsx',
            ]);

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file = $file->storeAs('public/private-documents', $file_name);
            //hapus file lama
            Storage::delete('public/private-documents/' . $simpan->file);
            $simpan->file = $file_name;
        }
        $simpan->name = $request->name;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.get-requests.index')->with('message', [
                'success' => true,
                'message' => 'Document updated successfully'
            ]);
        }else{
            return redirect()->route('admin.get-requests.edit', $id)->with('message', [
                'success' => false,
                'message' => 'Document failed to update'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = Document::findOrFail($id);
        Storage::delete('public/private-documents/' . $hapus->file);
        $hapus->delete();

        return redirect()->route('admin.get-requests.index')->with('message', [
            'success' => true,
            'message' => 'Document deleted successfully'
        ]);
    }

    public function share(Request $request, $document_id)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        foreach ($request->user_id as $user_id) {
            $simpan = new DocumentRequest();
            $simpan->document_id = $document_id;
            $simpan->user_id = $user_id;
            $simpan->expired = date('Y-m-d', strtotime('+1 day'));
            $simpan->save();
        }

        if($simpan){
            return redirect()->route('admin.get-requests.index')->with('message', [
                'success' => true,
                'message' => 'Document shared successfully'
            ]);
        }else{
            return redirect()->route('admin.get-requests.index')->with('message', [
                'success' => false,
                'message' => 'Document failed to share'
            ]);
        }
    }

    public function preview($id)
    {
        $data = Document::findOrFail($id);
        $auth = true;
        //check if user is authorized to view the document
        if($data->user_id != auth()->user()->id){
            $check = DocumentRequest::where('document_id', $id)->where('user_id', auth()->user()->id);
            if($check->count() == 0){
                $auth = false;
            }else{
                //cek expired
                $check = $check->first();
                if($check->expired < date('Y-m-d')){
                    $auth = false;
                }else{
                    $auth = true;
                }
            }
        }
        return view('admin.get_requests.preview', compact('data', 'auth'));
    }
}
