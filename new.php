<?php
// تنظیمات اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

// برقراری ارتباط با پایگاه داده
$connection = mysqli_connect($servername, $username, $password, $dbname);

// بررسی وضعیت اتصال به پایگاه داده
if (!$connection) {
    die("خطا در اتصال به پایگاه داده: " . mysqli_connect_error());
}

// بررسی ارسال فرم
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // دریافت اطلاعات ارسال شده از فرم
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $img = '';

    // بررسی وضعیت آپلود تصویر
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        // تنظیم مسیر ذخیره سازی تصاویر
        $upload_folder = 'uploads/';

        // ایجاد پوشه آپلود در صورت عدم وجود
        if (!is_dir($upload_folder)) {
            mkdir($upload_folder);
        }

        // ایجاد نام یکتا برای فایل
        $file_name = time() . '_' . $_FILES['img']['name'];
        $target_path = $upload_folder . $file_name;

        // انتقال فایل آپلود شده به پوشه مورد نظر
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
            $img = $target_path;
        }
    }

    // درج اطلاعات در پایگاه داده
    $query = "INSERT INTO users (first_name, last_name, username, img) 
              VALUES ('$first_name', '$last_name', '$username', '$img')";
    
    mysqli_query($connection, $query);

    // پایان ارتباط با پایگاه داده
    mysqli_close($connection);

    // انتقال به صفحه اصلی
    header('Location: index.php');
    die();
}
?>

<!-- بخش HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>ثبت کاربر جدید</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Tahoma;
            direction: rtl;
        }
        .form-group {
            margin: 10px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 200px;
            padding: 5px;
        }
        button {
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .back-btn {
            background: #666;
        }
    </style>
</head>
<body>
    <h2>ثبت کاربر جدید</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>نام:</label>
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label>نام خانوادگی:</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>نام کاربری:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>تصویر پروفایل:</label>
            <input type="file" name="img">
        </div>

        <button type="submit">ثبت اطلاعات</button>
        <a href="index.php"><button type="button" class="back-btn">بازگشت</button></a>
    </form>
</body>
</html> 