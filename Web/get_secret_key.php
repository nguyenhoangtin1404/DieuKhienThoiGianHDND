<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

$conn = new mysqli("localhost", "root", "1234", "your_database");

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$query = "SELECT secret_key FROM secret_keys WHERE user_id = (SELECT user_id FROM users WHERE username = '$username')";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $secretKey = $row['secret_key'];

    // Trả về secret key dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode(['secret_key' => $secretKey]);
} else {
    echo "Không tìm thấy secret key.";
}

$conn->close();
?>
