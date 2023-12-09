<?php
// Kết nối đến cơ sở dữ liệu (sử dụng thông tin của bạn)
$conn = new mysqli("localhost", "root", "1234", "your_database");

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Xử lý khi API được gọi với phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ phía client
    $meetingId = $_POST["meeting_id"];
    $newMeetingName = $_POST["new_meeting_name"];
    $newContent = $_POST["new_content"];
    $newSpeaker = $_POST["new_speaker"];
    $newSpeechType = $_POST["new_speech_type"];
    $newCountdownTime = $_POST["new_countdown_time"];

    // Thực hiện truy vấn để cập nhật thông tin kỳ họp
    $updateQuery = "UPDATE meetings 
                    SET meeting_name = '$newMeetingName', content = '$newContent', 
                        speaker = '$newSpeaker', speech_type = '$newSpeechType', 
                        countdown_time = '$newCountdownTime'
                    WHERE id = $meetingId";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Thông tin kỳ họp đã được cập nhật thành công.";
    } else {
        echo "Lỗi khi cập nhật thông tin kỳ họp: " . $conn->error;
    }
}

$conn->close();
?>
