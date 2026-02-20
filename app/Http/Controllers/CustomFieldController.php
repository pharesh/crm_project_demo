<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;

class CustomFieldController extends Controller
{
    public function index()
    {
        $fields = CustomField::all();
        return view('custom_fields.index', compact('fields'));
    }

   public function store(Request $request)
    {
        CustomField::create([
            'field_name' => $request->field_name,
            'field_type' => $request->field_type,
            'field_options' => $request->field_options
        ]);

        return back()->with('success','Custom Field Added');
    }
    public function destroy($id)
    {
        CustomField::find($id)->delete();
        return back()->with('success','Deleted');
    }
}

