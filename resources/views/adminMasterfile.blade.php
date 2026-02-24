<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Master File - PeopleWorks</title>
    @vite(['resources/css/adminMasterFile.css', 'resources/js/adminMasterFile.js'])
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <div class="logo">
                <img src="{{ asset('images/logoPplWorks.png') }}" alt="PeopleWorks Logo">
            </div>
            <h1 class="title">Admin Master File</h1>
        </header>
    </div>
    <div id="admin-table"></div>
</html>
