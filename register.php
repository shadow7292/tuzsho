<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Send message to Telegram bot
        $botToken = '6621783242:AAGuSb2elijTARdfHRyMIoS-siOTP7TTHQ0'; // Replace with your bot token
        $chatID = '1482859514'; // Replace with your chat ID
        $message = "New Registration:\nUsername: $username\nEmail: $email";
        
        $sendMessageURL = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($message);
        file_get_contents($sendMessageURL);

        header('Location: login.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TUZ SHOP</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }

        /* Header styles */
        .navbar {
            background-color: #FFFFFF;
            color: black;
            padding: 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            color: black;
            font-size: 24px;
            margin-right: 40px;
        }

        .nav-links {
            display: flex;
        }

        .nav-links ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-links li {
            margin-right: 20px;
        }

        .nav-links a {
            color: black;
            text-decoration: none;
        }

        /* Media query for responsive design */
        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px; /* Adjust according to header height */
                left: 0;
                background-color: #FFFFFF;
                width: 100%;
                padding: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links ul {
                flex-direction: column;
            }

            .nav-links li {
                margin-bottom: 10px;
            }

            .nav-links a {
                font-weight: bold;
                margin-bottom: 10px;
            }
        }

        /* Footer styles */
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer p {
            margin: 0;
        }

        /* Form container styles */
        .container {
            max-width: 500px;
            margin: 150px auto 50px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="img/tuzshop.png" alt="Company Logo">
                <span class="company-name">TUZ SHOP</span>
            </div>
            <div class="hamburger" onclick="toggleMenu()">
                &#9776;
            </div>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="#">Link 3</a></li>
                    <li><a href="#">Link 4</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <h2>Register</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 - 2028 TUZ Shop All Rights Reserved</p>
    </div>

    <script>
        // Hamburger menu toggle
        function toggleMenu() {
            var navLinks = document.getElementById("navLinks");
            navLinks.classList.toggle("active");
        }
    </script>
</body>
</html>
