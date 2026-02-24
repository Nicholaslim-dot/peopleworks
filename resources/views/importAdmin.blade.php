<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Admin Cases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Upload Excel File</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            alert("Import Successful: {{ session('success') }}");
        </script>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Import Failed!</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            alert("Import Failed: {{ implode(', ', $errors->all()) }}");
        </script>
    @endif

    <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="excel_file" class="form-label">Excel File</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="sheet_name" class="form-label">Sheet Name</label>
            <input type="text" name="sheet_name" id="sheet_name" class="form-control" placeholder="Enter sheet/tab name" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
