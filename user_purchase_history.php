<?php
include 'config.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user purchases
$query = "SELECT p.*, g.name AS gift_card_name, g.price AS gift_card_price FROM purchases p 
          JOIN gift_cards g ON p.gift_card_id = g.id
          WHERE p.user_id = ? ORDER BY p.purchased_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$purchases = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Purchase History - TUZ SHOP</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
}

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

@media (max-width: 768px) {
    .hamburger {
        display: block;
    }

    .nav-links {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 60px;
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

.container {
    margin-top: 100px;
    padding: 20px;
    text-align: center;
}

.purchase-table {
    width: 100%;
    border-collapse: separate; /* Changed to 'separate' for spacing between rows */
    border-spacing: 0 15px; /* Adds 15px of space between rows */
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.purchase-table th, .purchase-table td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.purchase-table th {
    background-color: #007bff;
    color: #fff;
}

.purchase-table tr:hover {
    background-color: #f5f5f5;
}

.purchase-table td {
    border-bottom: 1px solid #ddd; /* Ensures each cell has a border */
}

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

.btn {
    display: inline-block;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    color: white;
    background-color: #007bff;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    margin-top: 20px;
}

.btn:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .purchase-table th, .purchase-table td {
        display: block;
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        text-align: left;
        border: none;
    }

    .purchase-table th {
        background-color: #f9f9f9;
        position: absolute;
        top: 0;
        left: 0;
        padding: 15px;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
    }

    .purchase-table td {
        position: relative;
        padding-left: 50%;
        border-bottom: 1px solid #ddd;
        display: block;
    }

    .purchase-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 45%;
        padding-left: 10px;
        font-weight: bold;
        white-space: nowrap;
    }
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
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <h2>Your Purchase History</h2>
    <?php if (empty($purchases)) : ?>
        <p>You have not made any purchases yet.</p>
    <?php else : ?>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Gift Card Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Purchased At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $purchase) : ?>
                    <tr>
                        <td data-label="Gift Card Name"><?php echo htmlspecialchars($purchase['gift_card_name']); ?></td>
                        <td data-label="Price">$<?php echo number_format($purchase['gift_card_price'], 2); ?></td>
                        <td data-label="Quantity"><?php echo htmlspecialchars($purchase['quantity']); ?></td>
                        <td data-label="Total Price">$<?php echo number_format($purchase['total_price'], 2); ?></td>
                        <td data-label="Purchased At"><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($purchase['purchased_at']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="index.php" class="btn">Return to Home</a>
</div>

<div class="footer">
    <p>&copy; 2024 - 2028 TUZ Shop All Rights Reserved</p>
</div>

<script>
    function toggleMenu() {
        var navLinks = document.getElementById("navLinks");
        if (navLinks.style.display === "flex") {
            navLinks.style.display = "none";
        } else {
            navLinks.style.display = "flex";
        }
    }
</script>
</body>
</html>
