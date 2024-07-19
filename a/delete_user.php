<?php
include '../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details to confirm
    $query = "SELECT * FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Delete user
        $query = "DELETE FROM users WHERE id='$user_id'";

        if (mysqli_query($conn, $query)) {
            header('Location: admin_manage_users.php');
            exit();
        } else {
            $error_message = "Error deleting record: " . mysqli_error($conn);
        }
    }
} else {
    header('Location: admin_manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
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
        }

        .delete-user {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }

        .delete-user h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            color: white;
            background-color: #007bff;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        .btn-danger {
            background-color: #dc3545;
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
    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="../img/tuzshop.png" alt="Company Logo">
            <span class="company-name">TUZ SHOP Admin</span>
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            &#9776;
        </div>
        <div class="nav-links" id="navLinks">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_manage_users.php">Manage Users</a></li>
                <li><a href="admin_manage_giftcards.php">Manage Gift Cards</a></li>
                <li><a href="admin_manage_purchases.php">Manage Purchases</a></li>
                <li><a href="auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <div class="delete-user">
        <h2>Delete User</h2>
        <p>Are you sure you want to delete the user <strong><?php echo htmlspecialchars($user['username']); ?></strong>? This action cannot be undone.</p>
        <?php if (isset($error_message)) : ?>
            <div style="color: red; text-align: center; margin-bottom: 20px;"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="admin_manage_users.php" class="btn">Cancel</a>
        </form>
    </div>
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
