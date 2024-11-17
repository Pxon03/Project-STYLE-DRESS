<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าเข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    background: linear-gradient(to bottom, #e89a26, #ffc0b8); /* ไล่สีจากส้มอ่อนไปสีพาสเทล */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    color: #fff;
}

.login-container {
    background: rgba(255, 255, 255, 0.1); /* โปร่งเล็กน้อย */
    border: 2px solid rgba(255, 255, 255, 0.2);
    padding: 20px;
    border-radius: 15px;
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    width: 350px;
}

.login-container h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #c25451; /* ใช้สีแดงเข้มสำหรับหัวข้อ */
}

.login-container .form-control {
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    color: #fff;
}

.login-container .form-control:focus {
    background-color: rgba(255, 255, 255, 0.3);
    box-shadow: none;
    border: none;
    color: #fff;
}

.login-container .btn-primary {
    background-color: #e89a26; /* สีส้ม */
    border: none;
    width: 100%;
    margin-top: 10px;
}

.login-container a {
    color: #ff8983; /* สีชมพูอ่อนสำหรับลิงก์ */
    text-decoration: none;
}

.login-container a:hover {
    color: #ffc0b8; /* สีชมพูอ่อนเมื่อ hover */
}

.alert {
    text-align: center;
    border-radius: 10px;
    background-color: #c25451; /* พื้นหลังข้อความแจ้งเตือนสีแดงเข้ม */
    color: #fff;
}
    </style>
</head>

<body>
    <div class="login-container">
        <h3>Login</h3>
        <form action="config/signin_db.php" method="post">
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
        </form>
        <hr>
        <p>ยังไม่เป็นสมาชิก? <a href="signup.php">สมัครสมาชิกเลย!</a></p>
        <p>ลืมรหัสผ่าน? <a href="forgot_password.php">คลิกที่นี่</a></p> <!-- เพิ่มลิงก์สำหรับลืมรหัสผ่าน -->
    </div>
</body>

</html>
