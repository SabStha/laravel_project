<!DOCTYPE html>
<html>
<head>
    <title>Employer Registration Successful</title>
</head>
<body>
    <h2>Welcome, {{ $user->name }}!</h2>
    <p>Thank you for registering as an employer on our platform.</p>
    <p>Your account has been created successfully.</p>
    <p>You can now login using the following details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> (the one you entered)</li>
    </ul>
    <p>Click <a href="{{ url('/login') }}">here</a> to log in.</p>
</body>
</html>
