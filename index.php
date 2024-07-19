<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUZ SHOP</title>
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
            margin-right: 30px;
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

        /* Card styles */
        .card {
            background-color: #FFFFFF;
            border: 2px solid #FFD700; /* Yellow border */
            border-radius: 12px; /* Rounded corners */
            padding: 0px;
            margin: 0px auto;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 100px; /* Adjust top margin to create space */
        }

        .card img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            object-fit: cover; /* Ensure the image covers the entire container */
        }

        /* Slideshow styles */
        .slideshow-container {
            position: relative;
            max-width: 100%;
            overflow: hidden;
            margin: 0px auto;
            border-radius: 10px;
        }

        .slideshow-container img {
            width: 100%;
            vertical-align: middle;
        }

        /* Section heading styles */
        .section-heading {
            text-align: center;
            margin-top: 20px;
            font-size: 17px;
            font-weight: bold;
        }

        /* Section text styles */
        .section-text {
            text-align: center;
            margin-top: 10px;
            color: #666;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Image row styles */
        .image-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding: 0 10px; /* Add padding to align with card container */
        }

        .image-row .image {
            text-align: center;
            width: 30%; /* Adjust width as per your layout */
            position: relative;
        }

        .image-row .image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover; /* Ensure the image covers the entire box */
        }

        .image-row .image .image-text {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
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

    <!-- Card with sliding image view -->
    <div class="card">
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="img/aslide.png" alt="Slide 1">
            </div>
            <div class="mySlides fade">
                <img src="img/fslide.png" alt="Slide 2">
            </div>
            <div class="mySlides fade">
                <img src="img/spslide.png" alt="Slide 3">
            </div>
        </div>
    </div>

    <!-- Three images in a row with text below and redirection links -->
    <div class="image-row">
        <div class="image">
            <a href="giftcards.php">
                <img src="img/amc.png" alt="Image 1">
            </a>
            <div class="image-text">
                Explore Gift Cards
            </div>
        </div>
        <div class="image">
            <a href="#">
                <img src="img/grcrcr.png" alt="Image 2">
            </a>
            <div class="image-text">
                Upgrade Your Card To Visa Gold
            </div>
        </div>
        <div class="image">
            <a href="#">
                <img src="img/acr.png" alt="Image 3">
            </a>
            <div class="image-text">
                Apply For Credit Card
            </div>
        </div>
    </div>

    <div class="section-heading">
        TUZ Shop – World's Largest Gift Card Store
    </div>
    <div class="section-text">
        TUZ Shop is the world's largest gift card store offering gift cards, Upgrade Credit Cards, or Apply for Credit Cards. Explore gift cards from sought-after brands such as Amazon, Myntra, Shoppers Stop, Lifestyle, Cleartrip, Marks & Spencer, Croma, MakeMyTrip, Four Fountains Spa, Lakme Salon, Nykaa, VLCC, and many others. Find the perfect gift voucher for every occasion and individual at TUZ Shop.
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 - 2028 TUZ Shop All Rights Reserved</p>
    </div>

    <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }

        // Hamburger menu toggle
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
