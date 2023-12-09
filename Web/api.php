<?php
// Thực hiện xác thực API ở đây nếu cần

$conn = new mysqli("localhost", "root", "1234", "your_database");

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$query = "SELECT * FROM meetings";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $meetings = array();
    while ($row = $result->fetch_assoc()) {
        $meetings[] = array(
            'meeting_name' => $row['meeting_name'],
            'content' => $row['content'],
            'speaker_name' => $row['speaker_name'],
            'speech_type' => $row['speech_type'],
            'countdown_time' => $row['countdown_time']
        );
    }

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($meetings);
} else {
    echo "Không có cuộc họp nào trong cơ sở dữ liệu.";
}

$conn->close();
?>
