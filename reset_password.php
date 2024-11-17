<?php
session_start();
require 'config/connection.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าโทเคนถูกส่งมาหรือไม่
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // ตรวจสอบโทเคนในฐานข้อมูล
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = :token");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // แสดงฟอร์มรีเซ็ตรหัสผ่าน
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = $_POST['new_password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // แฮชรหัสผ่านใหม่

            // อัปเดตรหัสผ่านและลบโทเคน
            $stmt = $conn->prepare("UPDATE users SET password = :password, reset_token = NULL WHERE id = :id");
            $stmt->execute(['password' => $hashed_password, 'id' => $user['id']]);

            $_SESSION['success'] = 'รหัสผ่านได้ถูกรีเซ็ตแล้ว!';
            header('location: signin.php'); // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
            exit();
        }
    } else {
        echo '<div class="alert alert-danger">Invalid token. Please check your email and try again.</div>';
    }
} else {
    echo '<div class="alert alert-danger">No token provided.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้ารีเซ็ตรหัสผ่าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h3 class="form-title">รีเซ็ตรหัสผ่าน</h3>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="new_password" class="form-label">รหัสผ่านใหม่</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">รีเซ็ตรหัสผ่าน</button>
    </form>
</div>

</body>
</html>
