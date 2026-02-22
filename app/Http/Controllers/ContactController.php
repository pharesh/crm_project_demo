<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactCustomFieldValue;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    // SHOW LIST PAGE
    public function index()
    {
        $contacts = Contact::with('customFieldValues.customField')->latest()->get();
        $customFields = CustomField::all();

        return view('contacts.index', compact('contacts', 'customFields'));
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

        // ✅ Upload Profile Image
        if ($request->hasFile('profile_image')) {
            $contact->profile_image = $request->file('profile_image')
                ->store('profiles', 'public');
        }

        // ✅ Upload Additional File
        if ($request->hasFile('additional_file')) {
            $contact->additional_file = $request->file('additional_file')
                ->store('documents', 'public');
        }

        $contact->save();

        // Save custom fields
        if ($request->custom_fields) {

            foreach ($request->custom_fields as $field_id => $value) {

                if (is_array($value)) {
                    $value = implode(',', $value); // checkbox multiple values
                }

                ContactCustomFieldValue::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $field_id,
                    'value' => $value,
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
            'custom_fields' => $customValues,
        ]);
    }

    // UPDATE (AJAX)
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        // ✅ Update basic fields
        $contact->update($request->only('name', 'email', 'phone', 'gender'));

        // =========================
        // ✅ PROFILE IMAGE UPDATE
        // =========================
        if ($request->hasFile('profile_image')) {

            // delete old image
            if ($contact->profile_image) {
                Storage::disk('public')->delete($contact->profile_image);
            }

            // store new image
            $contact->profile_image = $request->file('profile_image')
                ->store('profiles', 'public');
        }

        // =========================
        // ✅ ADDITIONAL FILE UPDATE
        // =========================
        if ($request->hasFile('additional_file')) {

            // delete old file
            if ($contact->additional_file) {
                Storage::disk('public')->delete($contact->additional_file);
            }

            // store new file
            $contact->additional_file = $request->file('additional_file')
                ->store('documents', 'public');
        }

        // save file changes
        $contact->save();

        // =========================
        // ✅ CUSTOM FIELDS UPDATE
        // =========================
        if ($request->custom_fields) {

            foreach ($request->custom_fields as $field_id => $value) {

                if (is_array($value)) {
                    $value = implode(',', $value);
                }

                ContactCustomFieldValue::updateOrCreate(
                    [
                        'contact_id' => $contact->id,
                        'custom_field_id' => $field_id,
                    ],
                    [
                        'value' => $value,
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

        if ($request->name) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->email) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        $contacts = $query->get();
        $customFields = CustomField::all();

        return view('contacts.partials.contact_list', compact('contacts', 'customFields'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            abort(404, 'Invalid ID');
        }

        $contact = Contact::findOrFail($id);
        return view('contact.show', compact('contact'));
    }

    public function merge(Request $request)
    {
        $primary = Contact::findOrFail($request->primary_id);
        $secondary = Contact::findOrFail($request->secondary_id);
        // ✅ Merge Basic Fields (Email, Phone)
        if ($secondary->email && $secondary->email != $primary->email) {
            $primary->email .= ',' . $secondary->email;
        }

        if ($secondary->phone && $secondary->phone != $primary->phone) {
            $primary->phone .= ',' . $secondary->phone;
        }

        // ✅ Merge Custom Fields
        foreach ($secondary->customFieldValues as $field) {

            $exists = $primary->customFieldValues()
                ->where('custom_field_id', $field->custom_field_id)
                ->first();

            if (!$exists) {
                // Add new field
                $primary->customFieldValues()->create([
                    'custom_field_id' => $field->custom_field_id,
                    'value' => $field->value
                ]);
            } else {
                // If different value → append (NO DATA LOSS)
                if ($exists->value != $field->value) {
                    $exists->update([
                        'value' => $exists->value . ', ' . $field->value
                    ]);
                }
            }
        }

        // ✅ Save primary
        $primary->save();

        // ✅ Mark secondary as merged (IMPORTANT)
        $secondary->update([
            'is_merged' => true,
            'merged_into' => $primary->id
        ]);

        return response()->json(['success' => 'Contacts merged successfully']);
    }

    public function preview(Request $request)
    {
        $primary = Contact::with('customFieldValues')->find($request->primary_id);
        $secondary = Contact::with('customFieldValues')->find($request->secondary_id);

        return view('contacts.preview', compact('primary', 'secondary'));
    }
}
