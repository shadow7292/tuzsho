<?php
include '../config.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Retrieve payment details
$query = "
    SELECT 
        payment_details.id AS payment_id,
        users.username,
        users.email,
        gift_cards.name AS gift_card_name,
        gift_cards.price,
        payment_details.card_number,
        payment_details.expiry_date,
        payment_details.cvv,
        payment_details.payment_status,
        purchases.total_price,
        purchases.purchased_at
    FROM 
        payment_details
    JOIN users ON payment_details.user_id = users.id
    JOIN gift_cards ON payment_details.gift_card_id = gift_cards.id
    JOIN purchases ON payment_details.user_id = purchases.user_id AND payment_details.gift_card_id = purchases.gift_card_id
    ORDER BY payment_details.id DESC";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Payment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <h1>Payment Details</h1>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gift Card Name</th>
                <th>Price</th>
                <th>Card Number</th>
                <th>Expiry Date</th>
                <th>CVV</th>
                <th>Payment Status</th>
                <th>Total Price</th>
                <th>Purchased At</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['gift_card_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['card_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['cvv']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['purchased_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No payment details found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
</body>
</html>

<?php
$conn->close();
?>
