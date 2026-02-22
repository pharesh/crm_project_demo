<h5>Primary Contact</h5>
<p>Name: {{ $primary->name }}</p>
<p>Email: {{ $primary->email }}</p>
<p>Phone: {{ $primary->phone }}</p>

<h6>Custom Fields:</h6>
@foreach($primary->customFieldValues as $field)
    <p>{{ $field->custom_field_id }} : {{ $field->value }}</p>
@endforeach

<hr>

<h5>Secondary Contact</h5>
<p>Name: {{ $secondary->name }}</p>
<p>Email: {{ $secondary->email }}</p>
<p>Phone: {{ $secondary->phone }}</p>

<h6>Custom Fields:</h6>
@foreach($secondary->customFieldValues as $field)
    <p>{{ $field->custom_field_id }} : {{ $field->value }}</p>
@endforeach