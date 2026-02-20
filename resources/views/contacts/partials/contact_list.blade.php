<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
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