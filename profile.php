<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    echo "User not found.";
    exit();
}

$user = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Only update password if provided
    $password = $_POST['password'];
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id='$user_id'";
    } else {
        $query = "UPDATE users SET username='$username', email='$email' WHERE id='$user_id'";
    }

    if (mysqli_query($conn, $query)) {
        $success_message = "Profile updated successfully!";
        // Refresh the user details
        $result = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
        if (!$result) {
            die("Error executing query: " . mysqli_error($conn));
        }
        $user = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 80px; /* Adjust based on navbar height */
            padding: 20px;
        }

        .profile-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
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
                <li><a href="user_purchase_history.php">Purchase History</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <div class="profile-card">
        <img src="img/avatar.png" alt="Profile Image"> <!-- Add a default profile image -->
        <h2>Profile</h2>

        <?php if (isset($success_message)) : ?>
            <div style="color: green; text-align: center; margin-bottom: 20px;"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)) : ?>
            <div style="color: red; text-align: center; margin-bottom: 20px;"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Profile Update Form -->
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 - 2028 TUZ Shop All Rights Reserved</p>
</div>

<script>
    function toggleMenu() {
        var navLinks = document.getElementById("navLinks");
        if (navLinks.classList.contains("active")) {
            navLinks.classList.remove("active");
        } else {
            navLinks.classList.add("active");
        }
    }
</script>
</body>
</html>
