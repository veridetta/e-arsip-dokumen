<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::all();
        return view('admin.client.index', compact('data'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'start_contract' => 'required',
            'end_contract' => 'required',
            'file' => 'required|mimes:pdf',
        ]);

        $file = $request->file('file');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file = $file->storeAs('public/clients', $file_name);

        $simpan = new Client();
        $simpan->name = $request->name;
        $simpan->company_name = $request->company_name;
        $simpan->phone = $request->phone;
        $simpan->start_contract = $request->start_contract;
        $simpan->end_contract = $request->end_contract;
        $simpan->file = $file_name;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.clients.index')->with('message', [
                'success' => true,
                'message' => 'Client created successfully'
            ]);
        }else{
            return redirect()->route('admin.clients.create')->with('message', [
                'success' => false,
                'message' => 'Client failed to create'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Client::findOrFail($id);
        return view('admin.client.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'start_contract' => 'required',
            'end_contract' => 'required',
        ]);


        $simpan = Client::findOrFail($id);
        if($request->file('file')){
            $request->validate([
                'file' => 'required|mimes:pdf',
            ]);

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file = $file->storeAs('public/clients', $file_name);
            //hapus file lama
            Storage::delete('public/clients/' . $simpan->file);
            $simpan->file = $file_name;
        }
        $simpan->name = $request->name;
        $simpan->company_name = $request->company_name;
        $simpan->phone = $request->phone;
        $simpan->start_contract = $request->start_contract;
        $simpan->end_contract = $request->end_contract;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.clients.index')->with('message', [
                'success' => true,
                'message' => 'Client updated successfully'
            ]);
        }else{
            return redirect()->route('admin.clients.edit', $id)->with('message', [
                'success' => false,
                'message' => 'Client failed to update'
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Client::findOrFail($id);
        Storage::delete('public/clients/' . $data->file);
        $data->delete();
        return redirect()->route('admin.clients.index')->with('message', [
            'success' => true,
            'message' => 'Client deleted successfully'
        ]);
    }

    public function preview($id)
    {
        $data = Client::findOrFail($id);
        return view('admin.client.preview', compact('data'));
    }
}
