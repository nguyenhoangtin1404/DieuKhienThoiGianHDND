<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Xử lý khi biểu mẫu được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meetingName = $_POST["meeting_name"];
    $content = $_POST["content"];
    $speaker = $_POST["speaker"];
    $speechType = $_POST["speech_type"];
    $countdownTime = $_POST["countdown_time"];

    // Kết nối đến cơ sở dữ liệu (sử dụng thông tin của bạn)
    $conn = new mysqli("localhost", "root", "1234", "your_database");

    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    // Thực hiện truy vấn để thêm kỳ họp mới
    $insertQuery = "INSERT INTO meetings (meeting_name, content, speaker, speech_type, countdown_time) 
                    VALUES ('$meetingName', '$content', '$speaker', '$speechType', '$countdownTime')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Kỳ họp mới đã được thêm thành công.";
    } else {
        echo "Lỗi khi thêm kỳ họp: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới kỳ họp</title>
</head>
<body>
    <h1>Thêm mới kỳ họp</h1>

    <form method="post" action="">
        <label for="meeting_name">Tên kỳ họp:</label>
        <input type="text" name="meeting_name" required><br>

        <label for="content">Nội dung:</label>
        <textarea name="content" rows="4" cols="50" required></textarea><br>

        <label for="speaker">Tên người phát biểu:</label>
        <input type="text" name="speaker" required><br>

        <label for="speech_type">Loại phát biểu:</label>
        <input type="text" name="speech_type" required><br>

        <label for="countdown_time">Thời gian đếm ngược:</label>
        <input type="text" name="countdown_time" required><br>

        <button type="submit">Thêm mới</button>
    </form>

    <a href="manage_meetings.php">Quay lại trang quản lý kỳ họp</a>
</body>
</html>
