<!DOCTYPE html>
<html>
<head>
    <title>Simple CRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body{font-family: Arial; margin:40px;}
        input, select{margin:5px; padding:5px;}
        table{width:100%; margin-top:20px; border-collapse: collapse;}
        table, th, td{border:1px solid #ccc; padding:8px;}
        .btn{padding:5px 10px; cursor:pointer;}
        .btn-danger{background:red; color:white;}
        .btn-edit{background:blue; color:white;}
        .btn-save{background:green; color:white;}
    </style>
</head>
<body>

    <h2>CRM Practical</h2>
    <a href="{{ route('contacts.index') }}">Contacts</a> |
    <a href="{{ route('customfields.index') }}">Custom Fields</a>

    <hr>

    @yield('content')

</body>
</html>