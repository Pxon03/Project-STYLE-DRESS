<?php
session_start();
include 'config/connection.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit();
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_login'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(":id", $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าผู้ใช้</title>

    <?php include 'header.php'; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <style>
        section {
            margin-top: 50px;
        }
    </style>

</head>

<body>

    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h3>ยินดีต้อนรับ, <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h3>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5>ข้อมูลผู้ใช้</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <strong>รูปโปรไฟล์:</strong>
                        <div>
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                            <?php else: ?>
                                <span>ไม่มีรูปที่อัพโหลด</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <strong>อีเมล:</strong> <?php echo htmlspecialchars($user['email']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>สถานะผู้ใช้:</strong> <?php echo htmlspecialchars($user['urole']); ?>
                        </li>
                    </ul>

                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <a href="index.php" class="btn btn-secondary mb-2 mb-md-0">กลับไปหน้าหลัก</a>
                        <a href="logout.php" class="btn btn-danger mb-2 mb-md-0">ล็อคเอาท์</a>
                        <a href="update_profile.php" class="btn btn-primary mb-2 mb-md-0">อัพเดตโปรไฟล์</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="java.js"></script>

</body>

</html>