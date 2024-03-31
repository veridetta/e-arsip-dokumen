<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\GeneralCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralDocumentController extends Controller
{
    public function index()
    {
        $data = Document::where('type', 'general')->get();
        return view('admin.general_document.index', compact('data'));
    }

    public function create()
    {
        $categories = GeneralCategory::all();
        return view('admin.general_document.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',

            //file tipe exel,word,pdf
            'file' => 'required|mimes:doc,docx,pdf,xls,xlsx',
            'general_category_id' => 'required',
        ]);

        $file = $request->file('file');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file = $file->storeAs('public/general-documents', $file_name);


        $simpan = new Document();
        $simpan->user_id = auth()->user()->id;
        $simpan->name = $request->name;
        $simpan->file = $file_name;
        $simpan->general_category_id = $request->general_category_id;
        $simpan->type = 'general';
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.general-documents.index')->with('message', [
                'success' => true,
                'message' => 'Document created successfully'
            ]);
        }else{
            return redirect()->route('admin.general-documents.create')->with('message', [
                'success' => false,
                'message' => 'Document failed to create'
            ]);
        }
    }

    public function show($id)
    {
        $data = Document::findOrFail($id);
        return view('admin.general_document.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Document::findOrFail($id);
        $categories = GeneralCategory::all();
        return view('admin.general_document.edit', compact('data', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'general_category_id' => 'required',
        ]);


        $simpan = Document::findOrFail($id);
        if($request->file('file')){
            $request->validate([
                'file' => 'required|mimes:doc,docx,pdf,xls,xlsx',
            ]);

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file = $file->storeAs('public/general-documents', $file_name);
            //hapus file lama
            Storage::delete('public/general-documents/' . $simpan->file);
            $simpan->file = $file_name;
        }
        $simpan->name = $request->name;
        $simpan->general_category_id = $request->general_category_id;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.general-documents.index')->with('message', [
                'success' => true,
                'message' => 'Document updated successfully'
            ]);
        }else{
            return redirect()->route('admin.general-documents.edit', $id)->with('message', [
                'success' => false,
                'message' => 'Document failed to update'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = Document::findOrFail($id);
        Storage::delete('public/general-documents/' . $hapus->file);
        $hapus->delete();

        return redirect()->route('admin.general-documents.index')->with('message', [
            'success' => true,
            'message' => 'Document deleted successfully'
        ]);
    }

    public function preview($id)
    {
        $data = Document::findOrFail($id);
        return view('admin.general_document.preview', compact('data'));
    }
}
