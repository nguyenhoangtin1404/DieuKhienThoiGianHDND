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

$query = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullName = $row["full_name"];
    $address = $row["address"];
    $phoneNumber = $row["phone_number"];
} else {
    echo "Không tìm thấy thông tin cá nhân.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin cá nhân</title>
</head>
<body>
    <h1>Thông tin cá nhân</h1>
    <p><strong>Tên đăng nhập:</strong> <?php echo $username; ?></p>
    <p><strong>Họ và tên:</strong> <?php echo $fullName; ?></p>
    <p><strong>Địa chỉ:</strong> <?php echo $address; ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo $phoneNumber; ?></p>
</body>
</html>
