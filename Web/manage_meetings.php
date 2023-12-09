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

// Xử lý xóa kỳ họp nếu có yêu cầu
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Thực hiện truy vấn xóa
    $deleteQuery = "DELETE FROM meetings WHERE id = $deleteId";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Kỳ họp đã được xóa thành công.";
    } else {
        echo "Lỗi khi xóa kỳ họp: " . $conn->error;
    }
}

// Truy vấn cơ sở dữ liệu để lấy danh sách kỳ họp
$query = "SELECT * FROM meetings";
$result = $conn->query($query);

// Lưu thông tin kỳ họp vào mảng
$meetings = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meetings[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý kỳ họp</title>
</head>
<body>
    <h1>Quản lý kỳ họp</h1>

    <a href="create_meeting.php">Thêm kỳ họp mới</a>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên kỳ họp</th>
            <th>Nội dung</th>
            <th>Tên người phát biểu</th>
            <th>Loại phát biểu</th>
            <th>Thời gian đếm ngược</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($meetings as $meeting) : ?>
            <tr>
                <td><?php echo $meeting['id']; ?></td>
                <td><?php echo $meeting['meeting_name']; ?></td>
                <td><?php echo $meeting['content']; ?></td>
                <td><?php echo $meeting['speaker']; ?></td>
                <td><?php echo $meeting['speech_type']; ?></td>
                <td><?php echo $meeting['countdown_time']; ?></td>
                <td>
                    <a href="view_meeting.php?id=<?php echo $meeting['id']; ?>">Xem</a>
                    <a href="edit_meeting.php?id=<?php echo $meeting['id']; ?>">Sửa</a>
                    <a href="manage_meetings.php?delete_id=<?php echo $meeting['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa kỳ họp này không?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
