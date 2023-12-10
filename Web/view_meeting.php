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
        $isUpdate = $meeting['is_update'];
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
    <style>
        #countdown {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Thông tin kỳ họp</h1>
    <p><strong>Tên kỳ họp:</strong> <?php echo $meetingName; ?></p>
    <p><strong>Nội dung:</strong> <?php echo $content; ?></p>
    <p><strong>Tên người phát biểu:</strong> <?php echo $speaker; ?></p>
    <p><strong>Loại phát biểu:</strong> <?php echo $speechType; ?></p>
    <p><strong>Thời gian đếm ngược:</strong> <span id="countdown"></span></p>

    <script>
        // Lấy thời gian đếm ngược và trạng thái is_update từ PHP
        var countdownTime = <?php echo $countdownTime; ?>;
        var isUpdate = <?php echo $isUpdate; ?>;

        // Hiển thị thời gian đếm ngược
        function displayCountdown() {
            if (countdownTime >= 0) {
                var minutes = Math.floor(countdownTime / 60);
                var seconds = countdownTime % 60;

                // Định dạng hiển thị giờ, phút, giây
                var formattedTime = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                // Hiển thị lên trang web
                document.getElementById("countdown").innerHTML = formattedTime;

                // Giảm thời gian đếm ngược
                countdownTime--;

                // Kiểm tra xem đã hết thời gian đếm ngược chưa
                if (countdownTime < 0) {
                    clearInterval(countdownInterval);
                    displayCurrentTime();
                }
            }
        }

        // Hiển thị thời gian hiện tại sau khi kết thúc đếm ngược
        function displayCurrentTime() {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            // Định dạng hiển thị giờ, phút, giây
            var formattedTime = hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

            // Hiển thị lên trang web
            document.getElementById("countdown").innerHTML = formattedTime;
        }

        // Gọi hàm hiển thị đếm ngược mỗi giây
        var countdownInterval = setInterval(displayCountdown, 1000);

        // Kiểm tra và cập nhật is_update mỗi giây
        function updateIsUpdate() {
            // Nếu is_update = 0, thực hiện cập nhật
            if (isUpdate === 0) {
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Nhận phản hồi từ trang xử lý PHP (nếu cần)
                        console.log(this.responseText);
                    }
                };

                // Gửi yêu cầu đến trang xử lý PHP để kiểm tra và cập nhật is_update
                xhttp.open("GET", "update_is_update.php?id=<?php echo $meetingId; ?>", true);
                xhttp.send();
            }
        }

        // Lặp lại hàm kiểm tra và cập nhật mỗi giây
        setInterval(updateIsUpdate, 1000);
    </script>
</body>
</html>
