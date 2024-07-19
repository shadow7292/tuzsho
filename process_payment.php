<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve gift card details
$gift_card_id = $_POST['gift_card_id'];

$query = "SELECT * FROM gift_cards WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gift_card_id);
$stmt->execute();
$gift_card = $stmt->get_result()->fetch_assoc();

if (!$gift_card) {
    die("Gift card not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment - TUZ SHOP</title>
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

        /* Payment form styles */
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .container img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .container h2 {
            margin-top: 20px;
        }

        .container p {
            margin: 10px 0;
        }

        .btn {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
                    <li><a href="register.php">Register</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <img src="<?php echo htmlspecialchars($gift_card['image_url']); ?>" alt="<?php echo htmlspecialchars($gift_card['name']); ?>">
        <h2><?php echo htmlspecialchars($gift_card['name']); ?></h2>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($gift_card['price']); ?></p>
        <p><strong>Description:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($gift_card['description'])); ?></p>
        <p><strong>Quantity Available:</strong> <?php echo htmlspecialchars($gift_card['quantity']); ?></p>

        <form action="complete_payment.php" method="post">
            <input type="hidden" name="gift_card_id" value="<?php echo htmlspecialchars($gift_card['id']); ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

            <div class="form-group">
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date (MM/YYYY):</label>
                <input type="text" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
            
            <button type="submit" class="btn">Complete Payment</button>
        </form>
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
