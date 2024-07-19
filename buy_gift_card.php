<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the gift card ID is provided and valid
if (!isset($_POST['gift_card_id']) || !is_numeric($_POST['gift_card_id'])) {
    die("Invalid gift card ID.");
}

$gift_card_id = (int) $_POST['gift_card_id'];
$user_id = $_SESSION['user_id'];

// Fetch gift card details
$query = "SELECT * FROM gift_cards WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gift_card_id);
$stmt->execute();
$result = $stmt->get_result();
$gift_card = $result->fetch_assoc();

if (!$gift_card) {
    die("Gift card not found.");
}

// Check the quantity available
if ($gift_card['quantity'] <= 0) {
    die("Sorry, this gift card is out of stock.");
}

// Insert purchase record
$total_price = $gift_card['price'];
$query = "INSERT INTO purchases (user_id, gift_card_id, quantity, total_price) VALUES (?, ?, 1, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $user_id, $gift_card_id, $total_price);
if ($stmt->execute()) {
    // Update quantity in the gift cards table
    $query = "UPDATE gift_cards SET quantity = quantity - 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $gift_card_id);
    $stmt->execute();

    // Redirect to a success page or back to the details page
    header('Location: purchase_success.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
