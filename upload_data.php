<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าอัพโหลดข้อมูล</title>

    <?php include 'header.php'; ?>

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

    <style>
        /* Section Upload Container */
        #upload_container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            margin-top: 100px;
        }

        #upload_container form {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        #upload_container form input,
        #category {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        #upload_container form button {
            padding: 8px;
            background: lightblue;
            border: none;
            margin-bottom: 8px;
            cursor: pointer;
        }

        #upload_container form input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #upload_container form input[type="submit"]:hover {
            background-color: #218838;
        }

        #choose {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        #choose:hover {
            background-color: #0056b3;
        }

        #category {
            cursor: pointer;
        }

        /* เพิ่มสไตล์แสดงรูปตัวอย่าง */
        #imagePreview {
            display: block;
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            #upload_container form {
                width: 90%;
            }
        }
    </style>

</head>

<body>

    <section id="upload_container">
        <form action="upload_data.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="productname" id="productname" placeholder="ชื่อ" required>
            <input type="text" name="description" id="description" placeholder="รายละเอียด" required>

            <!-- เพิ่มเลือกประเภท -->
            <select name="category" id="category" required>
                <option value="">เลือกประเภท</option>
                <option value="clothes">Clothes</option>
                <option value="accessories">Accessories</option>
            </select>

            <input type="file" name="imageUpload" id="imageUpload" required hidden>
            <button id="choose" type="button" onclick="upload();">เลือกรูปภาพ</button>

            <!-- เพิ่มแท็ก img สำหรับแสดงภาพตัวอย่าง -->
            <img id="imagePreview" src="" alt="Preview image" style="display: none;">

            <input type="submit" value="อัพโหลด" name="submit">
        </form>
    </section>

    <script>
        var productname = document.getElementById("productname");
        var description = document.getElementById("description");
        var choose = document.getElementById("choose");
        var uploadImage = document.getElementById("imageUpload");
        var imagePreview = document.getElementById("imagePreview");

        function upload() {
            uploadImage.click();
        }

        uploadImage.addEventListener("change", function() {
            var file = this.files[0];
            if (productname.value == "") {
                productname.value = file.name;
            }

            choose.innerHTML = "คุณสามารถเปลี่ยนภาพ (" + file.name + ") ได้";

            // แสดงภาพตัวอย่าง
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // กำหนดค่า src ของ imagePreview ให้เป็นภาพที่เลือก
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = "block"; // แสดงภาพตัวอย่าง
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>