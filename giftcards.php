<?php
include 'config.php';
session_start();

// Fetch gift cards
$query = "SELECT * FROM gift_cards";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Cards</title>
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
            margin-right: 20px;
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
            margin-top: 80px; /* Adjust based on navbar height */
            padding: 20px;
        }

        .gift-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 300px;
            margin: 20px auto; /* Center align gift cards */
            text-align: center;
        }

        .gift-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .gift-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
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
                    <li><a href="giftcards.php">Explore Gift Cards</a></li>
                    <li><a href="#">Upgrade Card To Visa Gold</a></li>
                    <li><a href="#">Apply For Credit Card</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
        </div>
    </nav>
</header>

<div class="container">
    <h4 class="text-center">Available Gift Cards</h4>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4">
                <div class="gift-card">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Gift Card Image">
                    <?php endif; ?>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($row['price']); ?></p>
                    <p><strong>Quantity Available:</strong> <?php echo htmlspecialchars($row['quantity']); ?></p>
                    <a href="view_details.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>                                                                                                                             
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
