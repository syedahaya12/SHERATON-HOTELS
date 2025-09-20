<?php
require_once 'db.php';
session_start();
$stmt = $pdo->query("SELECT b.*, h.name FROM bookings b JOIN hotels h ON b.hotel_id = h.id");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sheraton Hotels - My Bookings</title>
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
        .bookings {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .bookings h2 {
            margin-bottom: 20px;
        }
        .booking-item {
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }
        .footer {
            background: #1a2a44;
            color: white;
            text-align: center;
            padding: 20px;
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
    <div class="bookings">
        <h2>My Bookings</h2>
        <?php foreach ($bookings as $booking): ?>
            <div class="booking-item">
                <p><strong>Hotel:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['user_name']); ?></p>
                <p><strong>Check-in:</strong> <?php echo htmlspecialchars($booking['checkin_date']); ?></p>
                <p><strong>Check-out:</strong> <?php echo htmlspecialchars($booking['checkout_date']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="footer">
        <p>&copy; 2025 Sheraton Hotels Clone. All rights reserved.</p>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
