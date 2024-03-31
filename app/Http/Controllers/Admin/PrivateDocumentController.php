<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\GeneralCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrivateDocumentController extends Controller
{
    public function index()
    {
        $data = Document::where('type', 'private')->where('user_id', auth()->user()->id)->get();
        $users = User::where('role', 'user')->get();
        return view('admin.private_document.index', compact('data', 'users'));
    }

    public function create()
    {
        return view('admin.private_document.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required|mimes:doc,docx,pdf,xls,xlsx',
        ]);

        $file = $request->file('file');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file = $file->storeAs('public/private-documents', $file_name);


        $simpan = new Document();
        $simpan->user_id = auth()->user()->id;
        $simpan->name = $request->name;
        $simpan->file = $file_name;
        $simpan->general_category_id = 9999;
        $simpan->type = 'private';
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.private-documents.index')->with('message', [
                'success' => true,
                'message' => 'Document created successfully'
            ]);
        }else{
            return redirect()->route('admin.private-documents.create')->with('message', [
                'success' => false,
                'message' => 'Document failed to create'
            ]);
        }
    }

    public function show($id)
    {
        $data = Document::findOrFail($id);
        $requests = DocumentRequest::where('document_id', $id)->get();
        return view('admin.private_document.show', compact('data', 'requests'));
    }

    public function edit($id)
    {
        $data = Document::findOrFail($id);
        return view('admin.private_document.edit', compact('data'));
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
            return redirect()->route('admin.private-documents.index')->with('message', [
                'success' => true,
                'message' => 'Document updated successfully'
            ]);
        }else{
            return redirect()->route('admin.private-documents.edit', $id)->with('message', [
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

        return redirect()->route('admin.private-documents.index')->with('message', [
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
            return redirect()->route('admin.private-documents.index')->with('message', [
                'success' => true,
                'message' => 'Document shared successfully'
            ]);
        }else{
            return redirect()->route('admin.private-documents.index')->with('message', [
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
        return view('admin.private_document.preview', compact('data', 'auth'));
    }
}
