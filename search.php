<?php
require_once 'config/upload.php'; // เชื่อมต่อฐานข้อมูล


if (isset($_GET['query']) && isset($_GET['category'])) {
    $searchQuery = $_GET['query'];
    $category = $_GET['category'];

    // กำหนดตัวแปรสำหรับเก็บผลการค้นหา
    $result = null;

    // ตรวจสอบหมวดหมู่ที่เลือก
    if ($category == 'clothes') {
        $stmt = $conn->prepare("SELECT * FROM clothes WHERE clothes_name LIKE ? OR clothes_description LIKE ?");
    } elseif ($category == 'accessories') {
        $stmt = $conn->prepare("SELECT * FROM accessories WHERE accessories_name LIKE ? OR accessories_description LIKE ?");
    }

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $searchPattern = "%$searchQuery%";
    $stmt->bind_param('ss', $searchPattern, $searchPattern);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าค้นหา</title>
    <?php include 'header.php'; ?>
    <style>
        body {
            font-family: "Kanit", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        section {
            display: flex;
            margin-top: 13rem;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 3rem 2rem;

        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;

            position: relative;
            text-align: center;
            padding: 3rem 2rem;
            background: #fff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            outline: 0.1rem solid #ccc;
            outline-offset: -1.5rem;

        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }

        .card-content {
            padding: 15px;
        }

        .card-content h4 {
            margin: 0 0 10px;
            font-size: 1.2em;
        }

        .card-content p {
            margin: 0;
            color: #555;
        }

        .no-results {
            text-align: center;
            font-size: 1.2em;
            color: #777;
        }

        /* ป๊อปอัปสไตล์ */
        .popup {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            position: fixed;
            top: 0;
            left: 0;
            min-height: 100vh;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            z-index: 1000;
            overflow: auto;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            max-height: 90vh;
            /* จำกัดความสูงของเนื้อหา */
            overflow-y: auto;
            /* ทำให้เนื้อหาภายในสามารถเลื่อนดูได้ */
        }

        .popup-content img {
            max-height: 20rem;
            object-fit: contain;
            border-radius: 10px;
        }

        .popup-content h4 {
            margin-top: 20px;
            font-size: 1.5em;
        }

        .popup-content p {
            margin-top: 1rem;
            font-size: 1.1em;
            font-style: italic;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            max-height: 200px;
            overflow-y: auto;
            text-align: left;
            padding: 10px;
        }

        .close-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }

        /* ปรับให้เข้ากับขนาดหน้าจอ */
        @media (max-width: 768px) {
            .card {
                width: calc(100% - 30px);
                /* ให้การ์ดใช้พื้นที่มากขึ้นบนหน้าจอเล็ก */
                max-width: none;
                /* ยกเลิกขนาดสูงสุด */
            }
        }
    </style>
</head>

<body>


    <section class="card-search">
        <div class="container">
            <h2>ผลการค้นหาสำหรับ "<?php echo htmlspecialchars($searchQuery); ?>" ในหมวดหมู่ "<?php echo $category == 'clothes' ? 'เสื้อผ้า' : 'เครื่องประดับ'; ?>"</h2>

            <!-- แสดงผลลัพธ์ในรูปแบบการ์ด -->
            <div class="card-container">
                <?php if ($result && $result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="card" onclick="showPopup('<?php echo $category == 'clothes' ? $row['clothes_name'] : $row['accessories_name']; ?>', '<?php echo $category == 'clothes' ? $row['clothes_description'] : $row['accessories_description']; ?>', '<?php echo !empty($category == 'clothes' ? $row['clothes_image'] : $row['accessories_image']) ? ($category == 'clothes' ? $row['clothes_image'] : $row['accessories_image']) : 'default-image.jpg'; ?>')">
                            <img src="<?php echo !empty($category == 'clothes' ? $row['clothes_image'] : $row['accessories_image']) ? ($category == 'clothes' ? $row['clothes_image'] : $row['accessories_image']) : 'default-image.jpg'; ?>" alt="<?php echo $category == 'clothes' ? $row['clothes_name'] : $row['accessories_name']; ?>" class="card-img">
                            <div class="card-content">
                                <h4><?php echo $category == 'clothes' ? $row['clothes_name'] : $row['accessories_name']; ?></h4>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="no-results">ไม่พบผลลัพธ์ในหมวดหมู่ "<?php echo $category == 'clothes' ? 'เสื้อผ้า' : 'เครื่องประดับ'; ?>"</p>
                <?php } ?>
            </div>
        </div>

        <!-- Popup ที่จะแสดงรายละเอียด -->
        <div class="popup" id="popup">
            <div class="popup-content">
                <img id="popup-img" src="" alt="Popup Image">
                <h4 id="popup-title"></h4>
                <p id="popup-description"></p>
                <button class="close-btn" onclick="closePopup()">ปิด</button>
            </div>
        </div>
    </section>

    <script src="java.js"></script>

    <script>
        function showPopup(title, description, image) {
            document.getElementById('popup-title').innerText = title;
            document.getElementById('popup-description').innerText = description;
            document.getElementById('popup-img').src = image;
            document.getElementById('popup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>



</body>

</html>