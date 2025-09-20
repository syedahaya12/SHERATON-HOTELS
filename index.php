<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sheraton Hotels - Homepage</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
        }
        .navbar {
            background: #1a2a44;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .hero {
            background: url('https://source.unsplash.com/1600x900/?hotel') no-repeat center center/cover;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .search-bar {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .search-bar input, .search-bar button {
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
        }
        .search-bar input {
            width: 200px;
        }
        .search-bar button {
            background: #ff6200;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-bar button:hover {
            background: #e55a00;
        }
        .featured {
            padding: 40px;
            text-align: center;
        }
        .featured h2 {
            margin-bottom: 20px;
        }
        .hotel-card {
            display: inline-block;
            width: 300px;
            margin: 15px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .hotel-card:hover {
            transform: scale(1.05);
        }
        .hotel-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .hotel-card h3 {
            padding: 10px;
            font-size: 18px;
        }
        .hotel-card p {
            padding: 0 10px 10px;
            color: #666;
        }
        .footer {
            background: #1a2a44;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            .hotel-card {
                width: 100%;
            }
            .search-bar input, .search-bar button {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Sheraton Hotels</h1>
        <div>
            <a href="index.php">Home</a>
            <a href="#" onclick="redirectTo('hotels.php')">Hotels</a>
            <a href="#" onclick="redirectTo('bookings.php')">My Bookings</a>
        </div>
    </div>
    <div class="hero">
        <div class="search-bar">
            <form id="searchForm" onsubmit="searchHotels(event)">
                <input type="text" id="destination" placeholder="Destination" required>
                <input type="date" id="checkin" required>
                <input type="date" id="checkout" required>
                <button type="submit">Search Hotels</button>
            </form>
        </div>
    </div>
    <div class="featured">
        <h2>Featured Hotels</h2>
        <div class="hotel-card" onclick="redirectTo('booking.php?hotel_id=1')">
            <img src="https://source.unsplash.com/300x200/?hotel,deluxe" alt="Hotel 1">
            <h3>Sheraton Deluxe</h3>
            <p>From $150/night</p>
        </div>
        <div class="hotel-card" onclick="redirectTo('booking.php?hotel_id=2')">
            <img src="https://source.unsplash.com/300x200/?hotel,luxury" alt="Hotel 2">
            <h3>Sheraton Luxury</h3>
            <p>From $250/night</p>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025 Sheraton Hotels Clone. All rights reserved.</p>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
        function searchHotels(event) {
            event.preventDefault();
            const destination = document.getElementById('destination').value.trim();
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;
            if (destination && checkin && checkout) {
                const url = `hotels.php?destination=${encodeURIComponent(destination)}&checkin=${checkin}&checkout=${checkout}`;
                redirectTo(url);
            } else {
                alert('Please fill in all fields.');
            }
        }
    </script>
</body>
</html>
