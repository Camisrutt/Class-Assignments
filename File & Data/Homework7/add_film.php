<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sakila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = $conn->prepare("INSERT INTO film (title, description, release_year, language_id, rental_duration, rental_rate, length, replacement_cost, rating, special_features) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$sql->bind_param(
    "ssiiididss",
    $_POST['title'],
    $_POST['description'],
    $_POST['release_year'],
    $_POST['language_id'],
    $_POST['rental_duration'],
    $_POST['rental_rate'],
    $_POST['length'],
    $_POST['replacement_cost'],
    $_POST['rating'],
    $_POST['special_features']
);

if ($sql->execute()) {
    echo "Film added successfully!";
} else {
    echo "Error: " . $sql->error;
}

$sql->close();
$conn->close();
?>
<br>
<button onclick="location.href='manager.html'">Return to Manager</button>
