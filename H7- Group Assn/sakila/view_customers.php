<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sakila";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query
$sql = "SELECT customer.first_name, customer.last_name, address.address, city.city, address.district, address.postal_code, 
        GROUP_CONCAT(film.title SEPARATOR ', ') AS rented_films
        FROM customer
        JOIN address ON customer.address_id = address.address_id
        JOIN city ON address.city_id = city.city_id
        LEFT JOIN rental ON customer.customer_id = rental.customer_id
        LEFT JOIN inventory ON rental.inventory_id = inventory.inventory_id
        LEFT JOIN film ON inventory.film_id = film.film_id
        GROUP BY customer.customer_id
        ORDER BY customer.last_name";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
</head>
<body>
    <h1>Customer List</h1>
    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>City</th>
            <th>District</th>
            <th>Postal Code</th>
            <th>Films Rented</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['city']); ?></td>
            <td><?php echo htmlspecialchars($row['district']); ?></td>
            <td><?php echo htmlspecialchars($row['postal_code']); ?></td>
            <td><?php echo htmlspecialchars($row['rented_films']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <button onclick="location.href='manager.html'">Return to Manager</button>
</body>
</html>
<?php $conn->close(); ?>
