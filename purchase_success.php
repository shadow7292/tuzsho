<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Success - TUZ SHOP</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container styles */
        .container {
            text-align: center;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .tick-icon {
            font-size: 100px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .message {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
        }

        .footer p {
            margin: 0;
        }
    </style>
    <script>
        // Redirect to user_purchase_history.php after 5 seconds
        setTimeout(function() {
            window.location.href = 'user_purchase_history.php';
        }, 5000);
    </script>
</head>
<body>
    <div class="container">
        <div class="tick-icon">
            &#10004; <!-- Green checkmark icon -->
        </div>
        <div class="message">
            <h1>Check Your Email</h1>
            <p>Your purchase has been completed successfully & sended to yur email. You will be redirected to your purchase history shortly.</p>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 - 2028 TUZ Shop All Rights Reserved</p>
    </div>
</body>
</html>
