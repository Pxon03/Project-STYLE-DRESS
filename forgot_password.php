<?php
require 'config/connection.php'; // เชื่อมต่อฐานข้อมูล
require 'vendor/autoload.php'; // สำหรับ Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // ตรวจสอบว่ามีอีเมลในฐานข้อมูลหรือไม่
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // สร้างโทเคนและลิงก์สำหรับรีเซ็ตรหัสผ่าน
        $token = bin2hex(random_bytes(30)); // สร้างโทเคน
        $stmt = $conn->prepare("UPDATE users SET reset_token = :token WHERE email = :email");

        // ตรวจสอบการอัปเดตโทเคนในฐานข้อมูล
        if ($stmt->execute(['token' => $token, 'email' => $email])) {
            // ส่งอีเมล
            $mail = new PHPMailer(true);

            try {
                // ตั้งค่า SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // เซิร์ฟเวอร์ SMTP ของคุณ
                $mail->SMTPAuth = true;
                $mail->Username = 'nattapongpansa810@gmail.com'; // อีเมลของคุณ
                $mail->Password = 'cgaj glrk artk nzph'; // รหัสผ่านอีเมลของคุณ
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // ตั้งค่าอีเมล
                $mail->setFrom('nattapongpansa810@gmail.com', 'Nattapong');
                $mail->addAddress($email);
                $mail->Subject = 'Reset your password';
                $mail->Body = 'กดลิงค์นี้เพื่อรีเซ็ตรหัสผ่านใหม่: <a href="http://localhost/project_type1/reset_password.php?token=' . $token . '">Reset Password</a>';
                $mail->isHTML(true);

                // ส่งอีเมล
                $mail->send();
                echo '<div class="alert alert-success">Reset password email sent!</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Failed to update token in database.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Email not found.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าลืมรหัสผ่าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);

        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #c25451;

        }

        .btn-primary {
            background-color: #e89a26;

            border: none;
            color: white;

            padding: 10px;

            border-radius: 5px;

            cursor: pointer;

            transition: background-color 0.3s;

        }

        .btn-primary:hover {
            background-color: #ffc0b8;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">ลืมรหัสผ่าน?</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">อีเมลของคุณ</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="โปรดใส่อีเมลของคุณ">
                </div>
                <button type="submit" class="btn btn-primary w-100">ส่งรีเซ็ตลิงค์</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>