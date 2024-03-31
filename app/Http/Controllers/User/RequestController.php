<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\Notification;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $data = DocumentRequest::where('to', auth()->user()->id)->get();
        $documents = Document::where('type', 'private')->where('user_id', auth()->user()->id)->get();
        return view('user.request.index', compact('data', 'documents'));
    }

    //reply
    public function reply(Request $request, $id)
    {
        $request->validate([
            'response' => 'required',
            'document_id' => 'required',
        ]);

        $simpan = DocumentRequest::find($id);
        $simpan->response = $request->response;
        $simpan->document_id = $request->document_id;
        $simpan->status = 'approved';
        $simpan->expired = $simpan->created_at->addDays(1);
        $simpan->save();

        //kirim notifikasi ke user
        $notif = new Notification();
        $notif->to = $simpan->user_id;
        $notif->from = auth()->user()->id;
        $notif->content = 'Selamat, request dokumen anda telah disetujui';
        $notif->save();

        if($simpan){
            return redirect()->route('user.requests.index')->with('message', [
                'success' => true,
                'message' => 'Request replied successfully'
            ]);
        }else{
            return redirect()->route('user.requests.index')->with('message', [
                'success' => false,
                'message' => 'Request failed to reply'
            ]);
        }
    }

    //reject
    public function reject($id)
    {
        $simpan = DocumentRequest::find($id);
        $simpan->status = 'rejected';
        $simpan->save();

        //kirim notifikasi ke user
        $notif = new Notification();
        $notif->to = $simpan->user_id;
        $notif->from = auth()->user()->id;
        $notif->content = 'Maaf, request dokumen anda telah ditolak';
        $notif->save();

        if($simpan){
            return redirect()->route('user.requests.index')->with('message', [
                'success' => true,
                'message' => 'Request rejected successfully'
            ]);
        }else{
            return redirect()->route('user.requests.index')->with('message', [
                'success' => false,
                'message' => 'Request failed to reject'
            ]);
        }
    }
}
