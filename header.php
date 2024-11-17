<?php if (session_status() == PHP_SESSION_NONE) {
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>แถบเมนู</title>
  
  <link rel="stylesheet" href="styles.css" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <link
    rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

</head>

<body>
  <!-- navbar -->
  <header>
    <a href="index.php" class="logo"><img src="image/logo.png" alt="" /></a>
    <ul class="navmenu">
      <li><a href="index.php">home</a></li>
      <li><a href="index.php#sample-page">sample</a></li>
      <li><a href="index.php#clothes-page">clothes</a></li>
      <li><a href="index.php#accessories-page">accessories</a></li>
    </ul>

    <!-- ค้นหา -->
    <div class="nav-icon">
      <div class="container-search">
        <form action="search.php" method="GET">
          <!-- Dropdown ให้เลือกหมวดหมู่ -->
          <select name="category" required>
            <option value="">เลือกหมวดหมู่</option>
            <option value="clothes">เสื้อผ้า</option>
            <option value="accessories">เครื่องประดับ</option>
          </select>

          <!-- ช่องค้นหา -->
          <input type="text" name="query" id="search-item" placeholder="ค้นหา..." required>

          <!-- ปุ่มค้นหา -->
          <button type="submit">ค้นหา</button>
        </form>
      </div>




      <!-- ผู้ใช้ -->
      <a href="<?php echo isset($_SESSION['urole']) ? ($_SESSION['urole'] == 'admin' ? 'admin.php' : 'user.php') : 'signin.php'; ?>">
        <i class="bx bx-user"></i>
        <?php if (!isset($_SESSION['urole'])) : ?>
        <?php endif; ?>
      </a>


      <div class="bx bx-menu" id="menu-icon"></div>


    </div>
    </div>
  </header>

  <script src="java.js"></script>

</body>

</html>