@extends('layout')

@section('content')

<div class="card">
    <h3>Add Custom Field</h3>

    <form method="POST" action="{{ route('customfields.store') }}">
        @csrf

        <div class="form-row">
            <input type="text" name="field_name" placeholder="Field Name" required>

            <select name="field_type" id="field_type">
                <option value="text">Text</option>
                <option value="date">Date</option>
                <option value="number">Number</option>
                <option value="select">Dropdown</option>
                <option value="checkbox">Checkbox</option>
            </select>
        </div>

        <div id="options_area" style="display:none;">
            <label>Enter Options (Comma separated)</label><br>
            <input type="text" name="field_options" placeholder="Option1,Option2,Option3">
        </div>

        <br>
        <button type="submit" class="btn btn-save">Add Field</button>
    </form>
</div>

<div class="card">
    <h3>Existing Fields</h3>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Options</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($fields as $field)
                <tr>
                    <td>{{ $field->field_name }}</td>
                    <td>{{ ucfirst($field->field_type) }}</td>
                    <td>
                        {{ $field->field_options ? $field->field_options : '-' }}
                    </td>
                    <td>
                        <form method="POST"
                              action="{{ route('customfields.delete',$field->id) }}"
                              onsubmit="return confirm('Delete this field?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$('#field_type').change(function(){
    let type = $(this).val();
    if(type == 'select' || type == 'checkbox'){
        $('#options_area').slideDown();
    } else {
        $('#options_area').slideUp();
    }
});
</script>

@endsection