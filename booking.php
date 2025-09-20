<?php
require_once 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $user_name = $_POST['user_name'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    
    $stmt = $pdo->prepare("INSERT INTO bookings (hotel_id, user_name, checkin_date, checkout_date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$hotel_id, $user_name, $checkin, $checkout])) {
        $message = "Booking confirmed! You'll be redirected to your bookings.";
        echo "<script>setTimeout(() => redirectTo('bookings.php'), 2000);</script>";
    } else {
        $message = "Error in booking.";
    }
}
$hotel_id = $_GET['hotel_id'] ?? null;
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
if ($hotel_id) {
    $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
    $stmt->execute([$hotel_id]);
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sheraton Hotels - Booking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        .navbar {
            background: #1a2a44;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .booking-form {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .booking-form h2 {
            margin-bottom: 20px;
        }
        .booking-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .booking-form button {
            width: 100%;
            padding: 10px;
            background: #ff6200;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .booking-form button:hover {
            background: #e55a00;
        }
        .message {
            text-align: center;
            color: green;
            margin: 20px;
        }
        .error {
            color: red;
        }
        .footer {
            background: #1a2a44;
            color: white;
            text-align: center;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .booking-form {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Sheraton Hotels</h1>
        <div>
            <a href="#" onclick="redirectTo('index.php')">Home</a>
            <a href="#" onclick="redirectTo('hotels.php')">Hotels</a>
            <a href="#" onclick="redirectTo('bookings.php')">My Bookings</a>
        </div>
    </div>
    <div class="booking-form">
        <h2>Book <?php echo $hotel ? htmlspecialchars($hotel['name']) : 'Hotel'; ?></h2>
        <?php if (isset($message)): ?>
            <p class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error'; ?>"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if ($hotel): ?>
            <form method="POST" onsubmit="return validateBookingForm()">
                <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
                <input type="text" name="user_name" placeholder="Your Name" required>
                <input type="date" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>" required>
                <input type="date" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>" required>
                <button type="submit">Confirm Booking</button>
            </form>
        <?php else: ?>
            <p class="error">Invalid hotel selected.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>&copy; 2025 Sheraton Hotels Clone. All rights reserved.</p>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
        function validateBookingForm() {
            const checkin = new Date(document.querySelector('input[name="checkin"]').value);
            const checkout = new Date(document.querySelector('input[name="checkout"]').value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (checkin < today) {
                alert('Check-in date cannot be in the past.');
                return false;
            }
            if (checkout <= checkin) {
                alert('Check-out date must be after check-in date.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
