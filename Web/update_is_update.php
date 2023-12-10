<?php
// Kết nối đến cơ sở dữ liệu (sử dụng thông tin của bạn)
$conn = new mysqli("localhost", "root", "1234", "your_database");

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Lấy ID kỳ họp từ tham số trên URL
$meetingId = isset($_GET['id']) ? $_GET['id'] : null;

if ($meetingId) {
    // Truy vấn cơ sở dữ liệu để lấy thông tin về trường is_update
    $query = "SELECT is_update FROM meetings WHERE id = $meetingId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $meeting = $result->fetch_assoc();
        $isUpdate = $meeting['is_update'];

        if ($isUpdate == 0) {
            // Bắt đầu đếm ngược từ đầu và cập nhật trường is_update = 1
            $countdownTime = 60; // Đặt lại thời gian đếm ngược
            $updateQuery = "UPDATE meetings SET is_update = 1, countdown_time = $countdownTime WHERE id = $meetingId";
            $conn->query($updateQuery);
        } else {
            // Trường is_update = 1, không làm gì cả
        }
    } else {
        echo "Không tìm thấy kỳ họp.";
    }
} else {
    echo "Không có ID kỳ họp được cung cấp.";
}

$conn->close();
?>
