@extends('layout')

@section('content')

<h3>Add Custom Field</h3>

<form method="POST" action="{{ route('customfields.store') }}">
    @csrf

    <input type="text" name="field_name" placeholder="Field Name" required>

    <select name="field_type" id="field_type">
        <option value="text">Text</option>
        <option value="date">Date</option>
        <option value="number">Number</option>
        <option value="select">Dropdown</option>
        <option value="checkbox">Checkbox</option>
    </select>

    <br>

    <div id="options_area" style="display:none;">
        <label>Enter Options (Comma separated)</label>
        <input type="text" name="field_options" placeholder="Option1,Option2,Option3">
    </div>

    <button type="submit">Add</button>
</form>

<hr>

<h3>Existing Fields</h3>

<table>
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Action</th>
    </tr>

    @foreach($fields as $field)
        <tr>
            <td>{{ $field->field_name }}</td>
            <td>{{ $field->field_type }}</td>
            <td>
                <form method="POST"
                      action="{{ route('customfields.delete',$field->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<script>
$('#field_type').change(function(){
    let type = $(this).val();
    if(type == 'select' || type == 'checkbox'){
        $('#options_area').show();
    }else{
        $('#options_area').hide();
    }
});
</script>

@endsection