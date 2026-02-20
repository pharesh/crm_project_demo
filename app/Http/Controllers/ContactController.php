<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\ContactCustomFieldValue;

class ContactController extends Controller
{
    // SHOW LIST PAGE
    public function index()
    {
        $contacts = Contact::with('customFieldValues')->latest()->get();
        $customFields = CustomField::all();
        return view('contacts.index', compact('contacts','customFields'));
    }

    // STORE CONTACT (AJAX)
    public function store(Request $request)
    {
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        // Upload files
        if ($request->hasFile('profile_image')) {
            $contact->profile_image = $request->file('profile_image')->store('profiles');
        }

        if ($request->hasFile('additional_file')) {
            $contact->additional_file = $request->file('additional_file')->store('documents');
        }

        $contact->save();

        // Save custom fields
        if($request->custom_fields){
            foreach ($request->custom_fields as $field_id => $value) {
                ContactCustomFieldValue::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $field_id,
                    'value' => $value
                ]);
            }
        }

        return response()->json(['success' => 'Contact Added Successfully']);
    }

    // EDIT
    public function edit($id)
    {
        $contact = Contact::with('customFieldValues')->findOrFail($id);

        $customValues = [];

        foreach ($contact->customFieldValues as $value) {
            $customValues[$value->custom_field_id] = $value->value;
        }

        return response()->json([
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'gender' => $contact->gender,
            'custom_fields' => $customValues
        ]);
    }

    // UPDATE (AJAX)
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update($request->only('name','email','phone','gender'));

        // Update custom fields
        if($request->custom_fields){

            foreach ($request->custom_fields as $field_id => $value) {
                ContactCustomFieldValue::updateOrCreate(
                    [
                        'contact_id' => $contact->id,
                        'custom_field_id' => $field_id
                    ],
                    [
                        'value' => $value
                    ]
                );
            }
        }

        return response()->json(['success' => 'Updated Successfully']);
    }

    // DELETE (AJAX)
    public function destroy($id)
    {
        Contact::find($id)->delete();
        return response()->json(['success' => 'Deleted Successfully']);
    }

    // FILTER
    public function filter(Request $request)
    {
        $query = Contact::query();

        if($request->name)
            $query->where('name','like','%'.$request->name.'%');

        if($request->email)
            $query->where('email','like','%'.$request->email.'%');

        if($request->gender)
            $query->where('gender',$request->gender);

        $contacts = $query->get();

        return view('contacts.partials.contact_list', compact('contacts'));
    }
}

