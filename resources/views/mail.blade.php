<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Visiting</title>
    <style>
        /* Reset some default styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Container for the email content */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100%;
        }

        /* Greeting */
        h2 {
            color: #333;
            text-transform: capitalize;
        }

        Strong {
            text-transform: capitalize;
        }

        /* Content */
        p {
            color: #666;
            line-height: 1.5;
        }

        /* Signature */
        .signature {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with logo -->
        <div class="header">
            <img class="logo" src="https://royalvision.com.pk/images/logo-wide.png" alt="Company Logo">
        </div>

        <!-- Greeting -->
        <h2>Dear Student {{ $name }},</h2>

        <!-- Content -->
        <p>We wanted to express our sincere gratitude for your visit to our office (<strong>Royal Vision Education</strong>).</p>

        <p>Your interest and support are greatly valued. It was a pleasure to have your visit and interest.</p>

        <!-- Counsellor Information -->
        <p>Mr./Ms. <strong>{{ $counsellor_name }}</strong> has been assigned to you as a Counselor.</p>

        <!-- Signature -->
        <p class="signature">Best Regards,<br>Team Royal Vision Education</p>
    </div>
</body>
</html>