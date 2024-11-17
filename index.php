<?php
session_start();

require_once 'config/upload.php';

$sql_clothes = "SELECT * FROM clothes";
$all_clothes = $conn->query($sql_clothes);

$sql_accessories = "SELECT * FROM accessories";
$all_accessories = $conn->query($sql_accessories);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>หน้าหลัก</title>
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

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
  <!-- navbar -->
  <header>
    <a href="#" class="logo"><img src="image/logo.png" alt="" /></a>
    <ul class="navmenu">
      <li><a href="#">home</a></li>
      <li><a href="#sample-page">sample</a></li>
      <li><a href="#clothes-page">clothes</a></li>
      <li><a href="#accessories-page">accessories</a></li>
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

      <!--เมนู-->
      <div class="bx bx-menu" id="menu-icon"></div>


    </div>
    </div>
  </header>

  <!-- ส่วนหลัก -->
  <section class="main-home">
    <div class="main-text">
      <h5>style dressing</h5>
      <h1>สไตล์ที่ใช่ <span>สไตล์ที่ชอบ</span></h1>
      <p>เสื้อผ้าและเครื่องประดับ</p>

      <a href="#clothes-page" class="main-btn">คลิ๊กเลย<i class="bx bx-chevron-right"></i></a>
    </div>

    <div class="down-arrow">
      <a href="#sample-page" class="down"><i class="bx bxs-chevron-down"></i></a>
    </div>
  </section>

  <!-- หน้าตัวอย่าง -->
  <section class="sample-style" id="sample-page">
    <div class="center-text1">
      <h2>ตัวอย่าง<span>สไตล์</span></h2>
      <div class="img-slider">
        <div class="slide active">
          <img src="image/slide1-1.png" alt="Slide 01" />
          <div class="slide-info">
            <h2>Slide<span>01</span></h2>
            <p>
              คำอธิบายนี้จะใส่ในอนาคต
            </p>
          </div>
        </div>
        <div class="slide">
          <img src="image/slide1-1.png" alt="Slide 02" />
          <div class="slide-info">
            <h2>Slide<span>2</span></h2>
            <p>
              คำอธิบายนี้จะใส่ในอนาคต
            </p>
          </div>
        </div>
        <div class="navigation-slide">
          <div class="btn active"></div>
          <div class="btn"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- หน้าเสื้อ -->
  <section class="clothes-list" id="clothes-page">
    <div class="center-text2">
      <h2>หมวดหมู่<span>เสื้อผ้า</span></h2>
      <div class="container">
        <div class="products-container">
          <?php while ($row = $all_clothes->fetch_assoc()) { ?>
            <div class="product" data-name="p-<?php echo $row['id']; ?>">
              <img src="<?php echo $row['clothes_image']; ?>" alt="" />
              <h3><?php echo $row['clothes_name']; ?></h3>
            </div>

          <?php } ?>
        </div>
      </div>

      <div class="products-preview">
        <?php $all_clothes->data_seek(0); // รีเซ็ตค่า pointer ก่อนวน loop ใหม่
        while ($row = $all_clothes->fetch_assoc()) { ?>
          <div class="preview" data-target="p-<?php echo $row['id']; ?>">
            <i class="fas fa-times"></i>
            <img src="<?php echo $row['clothes_image']; ?>" alt="" />
            <h3><?php echo $row['clothes_name']; ?></h3>
            <div class="description-box">
              <p><?php echo $row["clothes_description"]; ?></p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- หน้าเครื่องประดับ -->
  <section class="accessories-list" id="accessories-page">
    <div class="center-text2">
      <h2>หมวดหมู่<span>เครื่องประดับ</span></h2>
      <div class="container">
        <div class="products-container">
          <?php while ($row = $all_accessories->fetch_assoc()) { ?>
            <div class="product" data-name="p-<?php echo $row['id']; ?>">
              <img src="<?php echo $row['accessories_image']; ?>" alt="" />
              <h3><?php echo $row['accessories_name']; ?></h3>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="products-preview">
        <?php $all_accessories->data_seek(0);
        while ($row = $all_accessories->fetch_assoc()) { ?>
          <div class="preview" data-target="p-<?php echo $row['id']; ?>">
            <i class="fas fa-times"></i>
            <img src="<?php echo $row['accessories_image']; ?>" alt="" />
            <h3><?php echo $row['accessories_name']; ?></h3>
            <div class="description-box">
              <p><?php echo $row["accessories_description"]; ?></p>
            </div>

          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <script src="java.js"></script>

</body>

</html>