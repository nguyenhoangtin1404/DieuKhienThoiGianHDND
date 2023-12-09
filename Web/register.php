<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $newEmail = $_POST["new_email"];
    $fullName = $_POST["full_name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];

    $conn = new mysqli("localhost", "root", "1234", "your_database");

    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    $checkQuery = "SELECT * FROM users WHERE username = '$newUsername' OR email = '$newEmail'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "Tên đăng nhập hoặc email đã tồn tại.";
    } else {
        $insertQuery = "INSERT INTO users (username, password, email, full_name, address, phone_number) 
                        VALUES ('$newUsername', '$newPassword', '$newEmail', '$fullName', '$address', '$phone_number')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Người dùng đã được thêm thành công.";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<body>
    <h1>Đăng ký</h1>
    <form method="post" action="register.php">
        <label for="new_username">Tên đăng nhập:</label>
        <input type="text" name="new_username" required><br>

        <label for="new_password">Mật khẩu:</label>
        <input type="password" name="new_password" required><br>

        <label for="new_email">Email:</label>
        <input type="email" name="new_email" required><br>

        <label for="full_name">Họ và tên:</label>
        <input type="text" name="full_name" required><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" name="address"><br>

        <label for="phone_number">Số điện thoại:</label>
        <input type="text" name="phone_number"><br>

        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
