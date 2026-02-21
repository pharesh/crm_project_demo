<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>

            @foreach($customFields as $field)
                <th>{{ $field->field_name }}</th>
            @endforeach
            <th>Profile</th>
            <th>File</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->gender }}</td>

                @foreach($customFields as $field)
                    @php
                        $value = $contact->customFieldValues
                            ->where('custom_field_id', $field->id)
                            ->first();
                    @endphp 

                    <td>{{ $value ? $value->value : '-' }}</td>
                @endforeach
<td>
    @if($contact->profile_image)
        <img src="{{ asset('storage/'.$contact->profile_image) }}" 
             width="50" height="50" 
             style="border-radius:50%;">
    @else
        -
    @endif
</td>

<td>
    @if($contact->additional_file)
        <a href="{{ asset('storage/'.$contact->additional_file) }}" target="_blank">
            View File
        </a>
    @else
        -
    @endif
</td>
                <td>
                    <button class="btn btn-edit"
                        onclick="editContact({{ $contact->id }})">Edit</button>

                    <button class="btn btn-danger"
                        onclick="deleteContact({{ $contact->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>