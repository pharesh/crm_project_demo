@extends('layout')

@section('content')

<h3>Add Contact</h3>

<form id="contactForm" enctype="multipart/form-data">
    @csrf

    <input type="hidden" id="contact_id">

    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">

    <br>

    Gender:
    <input type="radio" name="gender" value="Male"> Male
    <input type="radio" name="gender" value="Female"> Female

    <br>

    Profile Image:
    <input type="file" name="profile_image">

    Additional File:
    <input type="file" name="additional_file">

    <br>

    {{-- Dynamic Custom Fields --}}
    <h4>Custom Fields</h4>
    @foreach($customFields as $field)
        <label>{{ $field->field_name }}</label>
        <input type="{{ $field->field_type }}"
               name="custom_fields[{{ $field->id }}]">
    @endforeach

    <br>
    <button type="submit" class="btn btn-save">Save</button>
</form>

<hr>

<h3>Filter</h3>

<form id="filterForm">
    <input type="text" name="name" placeholder="Search Name">
    <input type="text" name="email" placeholder="Search Email">

    <select name="gender">
        <option value="">All</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
</form>

<div id="contactTable">
    @include('contacts.partials.contact_list')
</div>

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// INSERT / UPDATE
$('#contactForm').submit(function(e){
    e.preventDefault();

    let id = $('#contact_id').val();
    let url = id ? '/contacts/'+id : '/contacts';

    let formData = new FormData(this);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        contentType:false,
        processData:false,
        success:function(res){
            alert(res.success);
            $('#contactForm')[0].reset();
            $('#contact_id').val('');
            loadContacts();
        }
    });
});

// DELETE
function deleteContact(id){
    if(confirm("Delete this contact?")){
        $.ajax({
            url:'/contacts/'+id,
            type:'DELETE',
            success:function(res){
                alert(res.success);
                loadContacts();
            }
        });
    }
}

// EDIT
function editContact(id){
    $.get('/contacts/'+id+'/edit', function(data){
        $('#contact_id').val(data.id);
        $('input[name="name"]').val(data.name);
        $('input[name="email"]').val(data.email);
        $('input[name="phone"]').val(data.phone);
        $('input[name="gender"][value="'+data.gender+'"]').prop('checked', true);

        // CLEAR previous custom values
        $('input[name^="custom_fields"]').val('');

        // SET custom field values
        if(data.custom_fields){
            $.each(data.custom_fields, function(field_id, value){
                $('input[name="custom_fields['+field_id+']"]').val(value);
            });
        }

    });
}

// FILTER
$('#filterForm input, #filterForm select').on('keyup change', function(){
    $.ajax({
        url:'/contacts/filter',
        data:$('#filterForm').serialize(),
        success:function(data){
            $('#contactTable').html(data);
        }
    });
});

// Reload contacts
function loadContacts(){
    $.get('/contacts', function(data){
        location.reload();
    });
}

</script>

@endsection