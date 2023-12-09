<?php
// Kết nối đến cơ sở dữ liệu (sử dụng thông tin của bạn)
$conn = new mysqli("localhost", "root", "1234", "your_database");

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Hàm tạo secret key ngẫu nhiên
function generateSecretKey($length = 32) {
    return bin2hex(random_bytes($length));
}

// Tạo secret key mới và user_id (giả sử user_id được truyền từ session hoặc thông tin người dùng)
$user_id = 2; // Thay thế giá trị này bằng giá trị thực từ session hoặc thông tin người dùng

$newSecretKey = generateSecretKey();

// Lưu secret key và user_id vào cơ sở dữ liệu
$insertQuery = "INSERT INTO secret_keys (user_id, secret_key) VALUES ('$user_id', '$newSecretKey') 
                ON DUPLICATE KEY UPDATE secret_key = '$newSecretKey'";

if ($conn->query($insertQuery) === TRUE) {
    echo "Secret key đã được tạo và lưu thành công cho user có ID $user_id.";
} else {
    echo "Lỗi khi tạo secret key: " . $conn->error;
}

$conn->close();
?>
