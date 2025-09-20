<?php
require_once 'db.php';
$hotels = [];
$destination = $_GET['destination'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';

if ($destination) {
    $stmt = $pdo->prepare("SELECT * FROM hotels WHERE location LIKE ?");
    $stmt->execute(["%$destination%"]);
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM hotels");
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sheraton Hotels - Listings</title>
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
        .filters {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .filters select, .filters input {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .hotel-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .hotel-card {
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
        }
        .hotel-card p {
            padding: 0 10px 10px;
            color: #666;
        }
        .hotel-card button {
            width: 100%;
            padding: 10px;
            background: #ff6200;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .hotel-card button:hover {
            background: #e55a00;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .footer {
            background: #1a2a44;
            color: white;
            text-align: center;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .hotel-card {
                width: 100%;
            }
            .filters select, .filters input {
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
            <a href="#" onclick="redirectTo('index.php')">Home</a>
            <a href="#" onclick="redirectTo('hotels.php')">Hotels</a>
            <a href="#" onclick="redirectTo('bookings.php')">My Bookings</a>
        </div>
    </div>
    <div class="filters">
        <select id="sort" onchange="sortHotels()">
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="rating_desc">Rating: High to Low</option>
        </select>
        <input type="number" id="minPrice" placeholder="Min Price" oninput="filterHotels()">
        <input type="number" id="maxPrice" placeholder="Max Price" oninput="filterHotels()">
    </div>
    <div class="hotel-list" id="hotelList">
        <?php if (empty($hotels)): ?>
            <p class="no-results">No hotels found for "<?php echo htmlspecialchars($destination); ?>".</p>
        <?php else: ?>
            <?php foreach ($hotels as $hotel): ?>
                <div class="hotel-card" onclick="redirectTo('booking.php?hotel_id=<?php echo $hotel['id']; ?>&checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>')">
                    <img src="<?php echo htmlspecialchars($hotel['image']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
                    <h3><?php echo htmlspecialchars($hotel['name']); ?></h3>
                    <p><?php echo htmlspecialchars($hotel['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($hotel['price']); ?>/night</p>
                    <p>Rating: <?php echo htmlspecialchars($hotel['rating']); ?>/5</p>
                    <button>Book Now</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>&copy; 2025 Sheraton Hotels Clone. All rights reserved.</p>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
        function sortHotels() {
            const sort = document.getElementById('sort').value;
            const hotels = Array.from(document.querySelectorAll('.hotel-card'));
            hotels.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('p:nth-child(4)').textContent.replace('Price: $', '').replace('/night', ''));
                const priceB = parseFloat(b.querySelector('p:nth-child(4)').textContent.replace('Price: $', '').replace('/night', ''));
                const ratingA = parseFloat(a.querySelector('p:nth-child(5)').textContent.replace('Rating: ', '').replace('/5', ''));
                const ratingB = parseFloat(b.querySelector('p:nth-child(5)').textContent.replace('Rating: ', '').replace('/5', ''));
                if (sort === 'price_asc') return priceA - priceB;
                if (sort === 'price_desc') return priceB - priceA;
                if (sort === 'rating_desc') return ratingB - ratingA;
            });
            const hotelList = document.getElementById('hotelList');
            hotelList.innerHTML = '';
            hotels.forEach(hotel => hotelList.appendChild(hotel));
        }
        function filterHotels() {
            const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
            const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;
            const hotels = Array.from(document.querySelectorAll('.hotel-card'));
            hotels.forEach(hotel => {
                const price = parseFloat(hotel.querySelector('p:nth-child(4)').textContent.replace('Price: $', '').replace('/night', ''));
                hotel.style.display = (price >= minPrice && price <= maxPrice) ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
