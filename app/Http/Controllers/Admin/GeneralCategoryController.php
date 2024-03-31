<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralCategory;
use Illuminate\Http\Request;

class GeneralCategoryController extends Controller
{
    public function index()
    {
        $data = GeneralCategory::all();
        return view('admin.general_categories.index', compact('data'));
    }

    public function create()
    {
        return view('admin.general_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();

        $insert = GeneralCategory::create($data);

        if ($insert) {
            return redirect()->route('admin.general-categories.index')->with('message', [
                'success' => true,
                'message' => 'Jenis Dokumen  created successfully'
            ]);
        } else {
            return redirect()->route('admin.general-categories.index')->with('message', [
                'success' => false,
                'message' => 'Jenis Dokumen failed to create'
            ]);
        }
    }

    public function edit($id)
    {
        $data = GeneralCategory::find($id);
        return view('admin.general_categories.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();

        $update = GeneralCategory::find($id)->update($data);

        if ($update) {
            return redirect()->route('admin.general-categories.index')->with('message', [
                'success' => true,
                'message' => 'Jenis Dokumen updated successfully'
            ]);
        } else {
            return redirect()->route('admin.general-categories.index')->with('message', [
                'success' => false,
                'message' => 'Jenis Dokumen failed to update'
            ]);
        }
    }

    public function destroy($id)
    {
        $delete = GeneralCategory::find($id)->delete();

        if ($delete) {
            return redirect()->route('admin.general-categories.index')->with('message', [
                'success' => true,
                'message' => 'Jenis Dokumen deleted successfully'
            ]);
        } else {
            return redirect()->route('admin.general-categories.index')->with('message', [
                'success' => false,
                'message' => 'Jenis Dokumen failed to delete'
            ]);
        }
    }
}
