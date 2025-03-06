<!DOCTYPE html>
<html>
<head>
    <title>Complete Your Employer Registration</title>
</head>
<body>
    <h2>Welcome, {{ $name }}!</h2>
    <p>We have registered you as an employer. Before you can log in, please complete your business registration.</p>

    <p><strong>Your Temporary Password:</strong> {{ $password }}</p>
    <p><strong>Complete Your Registration:</strong></p>
    
    <a href="{{ $verificationLink }}" style="background-color:#28a745; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">
        Complete Registration
    </a>

    <p>If you did not register for an employer account, please ignore this email.</p>

    <p>Thank you!</p>
</body>
</html>
