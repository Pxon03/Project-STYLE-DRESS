<?php
session_start();
require_once 'config/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าลงทะเบียน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
    background: linear-gradient(to bottom, #e89a26, #ffc0b8); /* ไล่สีจากส้มอ่อนไปสีพาสเทล */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    color: #fff;
}

.container {
    background: rgba(255, 255, 255, 0.1); /* โปร่งเล็กน้อย */
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    width: 350px;
}

.container h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #c25451; /* ใช้สีแดงเข้มสำหรับหัวข้อ */
}

.container .form-control {
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    color: #fff;
}

.container .form-control:focus {
    background-color: rgba(255, 255, 255, 0.3);
    box-shadow: none;
    border: none;
    color: #fff;
}

.container .btn-primary {
    background-color: #e89a26; 
    border: none;
    width: 100%;
    margin-top: 10px;
}

.container a {
    color: #ff8983; 
    text-decoration: none;
}

.container a:hover {
    color: #ffc0b8; 
}

.alert {
    text-align: center;
    border-radius: 10px;
    background-color: #c25451; 
    color: #fff;
    padding: 10px; 
}

    </style>
</head>

<body>
    <div class="container">
        <h3>สมัครสมาชิก</h3>
        <hr>
        <form action="config/signup_db.php" method="post">
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

            <?php if (isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php
                    echo $_SESSION['warning'];
                    unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstname" aria-describedby="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastname" aria-describedby="lastname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="con_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="con_password">
            </div>

            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
        </form>
        <hr>
        <p>เป็นสมาชิกแล้วใช่ไหม? คลิ๊กที่นี่เพื่อ <a href="signin.php">เข้าสู่ระบบ</a></p>
    </div>
</body>

</html>
