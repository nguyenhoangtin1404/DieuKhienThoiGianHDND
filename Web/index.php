<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "1234", "your_database");

    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION["username"] = $username;
        header("Location: personal_info.php");
        exit();
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h1>Đăng nhập</h1>
    <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
    <form method="post" action="">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" required><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>
