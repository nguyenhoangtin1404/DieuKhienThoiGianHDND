<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Kết nối đến cơ sở dữ liệu (sử dụng thông tin của bạn)
$conn = new mysqli("localhost", "root", "1234", "your_database");

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Lấy ID kỳ họp từ tham số trên URL
$meetingId = isset($_GET['id']) ? $_GET['id'] : null;

if ($meetingId) {
    // Truy vấn cơ sở dữ liệu để lấy thông tin về kỳ họp
    $query = "SELECT * FROM meetings WHERE id = $meetingId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $meeting = $result->fetch_assoc();
        $meetingName = $meeting['meeting_name'];
        $content = $meeting['content'];
        $speaker = $meeting['speaker'];
        $speechType = $meeting['speech_type'];
        $countdownTime = $meeting['countdown_time'];
    } else {
        echo "Không tìm thấy kỳ họp.";
        exit();
    }
} else {
    echo "Không có ID kỳ họp được cung cấp.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin kỳ họp</title>
</head>
<body>
    <h1>Thông tin kỳ họp</h1>
    <p><strong>Tên kỳ họp:</strong> <?php echo $meetingName; ?></p>
    <p><strong>Nội dung:</strong> <?php echo $content; ?></p>
    <p><strong>Tên người phát biểu:</strong> <?php echo $speaker; ?></p>
    <p><strong>Loại phát biểu:</strong> <?php echo $speechType; ?></p>
    <p><strong>Thời gian đếm ngược:</strong> <?php echo $countdownTime; ?></p>

    <!-- Các phần tử HTML khác -->

</body>
</html>