<!DOCTYPE html>
<html>
<head>
    <title>Complete Your Registration</title>
</head>
<body>
    <p>Dear {{ $name }},</p>
    <p>Thank you for registering. Please click the button below to complete your company registration.</p>
    <p>
        <a href="{{ $url }}" style="background: #28a745; padding: 10px 20px; color: #fff; text-decoration: none;">
            Complete Registration
        </a>
    </p>
    <p>If you did not request this registration, please ignore this email.</p>
</body>
</html>
