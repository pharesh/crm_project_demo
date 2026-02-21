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
                    <button class="btn btn-edit"
                        onclick="editContact({{ $contact->id }})">Edit</button>

                    <button class="btn btn-danger"
                        onclick="deleteContact({{ $contact->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>