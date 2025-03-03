<!DOCTYPE html>
<html>
<head>
    <title>Import Jobseekers</title>
</head>
<body>
    <h2>Upload Google Forms CSV File</h2>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <form action="{{ url('/import-jobseekers') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
