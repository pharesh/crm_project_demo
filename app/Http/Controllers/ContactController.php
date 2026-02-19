<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactCustomFieldValue;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        // Save custom fields
        foreach ($request->custom_fields as $field_id => $value) {
            ContactCustomFieldValue::create([
                'contact_id' => $contact->id,
                'custom_field_id' => $field_id,
                'value' => $value   
            ]);
        }

        return response()->json(['success' => 'Contact Added Successfully']);
    }
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $contact->update($request->all());

        return response()->json(['success' => 'Updated Successfully']);
    }
    public function destroy($id)
    {
        Contact::find($id)->delete();
        return response()->json(['success' => 'Deleted Successfully']);
    }


}
