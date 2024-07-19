<?php
include '../config.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $query = "INSERT INTO gift_cards (name, description, price, quantity) VALUES ('$name', '$description', '$price', '$quantity')";

    if (mysqli_query($conn, $query)) {
        echo "Gift card added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

$giftCards = mysqli_query($conn, "SELECT * FROM gift_cards");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Admin Panel</h2>
    <form method="post">
        <div class="form-group">
            <label for="name">Gift Card Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Gift Card</button>
    </form>
    <h3>Gift Cards</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($card = mysqli_fetch_assoc($giftCards)) { ?>
            <tr>
                <td><?php echo $card['id']; ?></td>
                <td><?php echo $card['name']; ?></td>
                <td><?php echo $card['description']; ?></td>
                <td><?php echo $card['price']; ?></td>
                <td><?php echo $card['quantity']; ?></td>
                <td><?php echo $card['created_at']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
