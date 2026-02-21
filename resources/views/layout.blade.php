<!DOCTYPE html>
<html>
<head>
    <title>Simple CRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f5f6fa;
    }

    .container {
        width: 95%;
        margin: auto;
        padding: 20px;
    }

    h2 {
        margin-bottom: 10px;
    }

    .top-nav {
        margin-bottom: 20px;
    }

    .top-nav a {
        text-decoration: none;
        margin-right: 15px;
        color: #3498db;
        font-weight: bold;
    }

    .card {
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .form-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    input, select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        min-width: 180px;
    }

    label {
        margin-right: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th {
        background: #2c3e50;
        color: white;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-save { background: #27ae60; color: white; }
    .btn-edit { background: #2980b9; color: white; }
    .btn-danger { background: #e74c3c; color: white; }

</style>
</head>
<body>

<div class="container">

    <h2>CRM Practical</h2>

    <div class="top-nav">
        <a href="{{ route('contacts.index') }}">Contacts</a>
        <a href="{{ route('customfields.index') }}">Custom Fields</a>
    </div>

    @yield('content')

</div>

</body>
</html>