<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get gift card ID and user details
$gift_card_id = $_POST['gift_card_id'];
$user_id = $_SESSION['user_id'];
$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];

// Fetch gift card details
$query = "SELECT * FROM gift_cards WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gift_card_id);
$stmt->execute();
$gift_card = $stmt->get_result()->fetch_assoc();

if (!$gift_card) {
    die("Gift card not found.");
}

// Dummy payment processing
// Replace this with real payment gateway integration
$is_payment_successful = true; // Simulate payment success

if ($is_payment_successful) {
    // Insert purchase record
    $query = "INSERT INTO purchases (user_id, gift_card_id, quantity, total_price) VALUES (?, ?, 1, ?)";
    $stmt = $conn->prepare($query);
    $total_price = $gift_card['price'];
    $stmt->bind_param("iid", $user_id, $gift_card_id, $total_price);
    $stmt->execute();

    // Redirect to success page
    header('Location: purchase_success.php');
    exit();
} else {
    echo "Payment failed. Please try again.";
}
?>
