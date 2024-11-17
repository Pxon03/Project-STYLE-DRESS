<?php
session_start();
require_once 'config/connection.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit();
}

// ตรวจสอบว่าผู้ใช้งานเป็น admin หรือ user
if (isset($_SESSION['admin_login'])) {
    $user_id = $_SESSION['admin_login']; // ถ้าเป็น admin
} elseif (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login']; // ถ้าเป็น user
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(":id", $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// อัปเดตข้อมูลเมื่อมีการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ตรวจสอบและอัปโหลดรูปภาพ
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "upload_user/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    } else {
        $image_path = $user['profile_image']; // ใช้รูปเดิมถ้าไม่มีการอัปโหลดใหม่
    }

    // ตรวจสอบรหัสผ่าน
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // แฮชรหัสผ่านใหม่
    } else {
        $hashed_password = $user['password']; // ใช้รหัสผ่านเดิม
    }

    // อัปเดตข้อมูลในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, profile_image = :profile_image WHERE id = :id");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':profile_image', $image_path);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    $_SESSION['success'] = 'อัปเดตข้อมูลสำเร็จ!';
    header('location: update_profile.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าอัปเดตโปรไฟล์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .alert {
            margin-bottom: 20px;
        }
        .btn-secondary {
            margin-left: 10px;
        }
        /* เพิ่มสไตล์สำหรับแสดงภาพตัวอย่าง */
        #profilePreview {
            display: block;
            max-width: 200px;
            max-height: 200px;
            margin: 20px 0;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h3>อัปเดตโปรไฟล์</h3>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- ฟอร์มการอัปเดตโปรไฟล์ -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="firstname" class="form-label">ชื่อ</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">นามสกุล</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">อีเมล</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        
        <!-- ภาพโปรไฟล์ปัจจุบัน -->
        <div class="mb-3">
            <label for="profile_image" class="form-label">รูปโปรไฟล์ปัจจุบัน</label>
            <img id="profilePreview" src="<?php echo $user['profile_image']; ?>" alt="Profile Image">
        </div>

        <!-- อัปโหลดรูปโปรไฟล์ใหม่ -->
        <div class="mb-3">
            <label for="profile_image" class="form-label">อัปโหลดรูปโปรไฟล์ใหม่</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image">
        </div>
        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
        <?php if (isset($_SESSION['admin_login'])): ?>
            <a href="admin.php" class="btn btn-secondary">กลับไปที่โปรไฟล์</a>
        <?php elseif (isset($_SESSION['user_login'])): ?>
            <a href="user.php" class="btn btn-secondary">กลับไปที่โปรไฟล์</a>
        <?php endif; ?>
    </form>
</div>

<script>
    // แสดงตัวอย่างรูปโปรไฟล์ใหม่ที่เลือก
    document.getElementById('profile_image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>
