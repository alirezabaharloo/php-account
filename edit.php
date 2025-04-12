<?php
// اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

// ایجاد اتصال به دیتابیس
$connection = mysqli_connect($servername, $username, $password, $dbname);

// بررسی اتصال
if (!$connection) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

// بررسی وجود شناسه کاربر
if (!isset($_GET['id'])) {
    header('Location: index.php');
    die();
}

$id = $_GET['id'];

// دریافت اطلاعات کاربر
$query = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);

// اگر کاربر پیدا نشد
if (!$user) {
    header('Location: index.php');
    die();
}

// وقتی فرم ویرایش ارسال میشه
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $img = $user['img']; // حفظ تصویر قبلی

    // بررسی آپلود تصویر جدید
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $upload_folder = 'uploads/';
        
        if (!is_dir($upload_folder)) {
            mkdir($upload_folder);
        }

        $file_name = time() . '_' . $_FILES['img']['name'];
        $target_path = $upload_folder . $file_name;

        // آپلود تصویر جدید
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
            // حذف تصویر قدیمی
            if ($user['img'] && file_exists($user['img'])) {
                unlink($user['img']);
            }
            $img = $target_path;
        }
    }

    // بروزرسانی اطلاعات
    $query = "UPDATE users SET 
              first_name = '$first_name',
              last_name = '$last_name',
              username = '$username',
              img = '$img'
              WHERE id = '$id'";
    
    mysqli_query($connection, $query);
    
    // بستن اتصال
    mysqli_close($connection);
    
    header('Location: index.php');
    die();
}
?>

<!-- قسمت HTML فرم -->
<!DOCTYPE html>
<html>
<head>
    <title>ویرایش کاربر</title>
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
        .current-image {
            max-width: 100px;
            margin: 10px 0;
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
    <h2>ویرایش کاربر</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>نام:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>نام خانوادگی:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>نام کاربری:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="form-group">
            <label>تصویر پروفایل:</label>
            <?php if ($user['img']): ?>
                <img src="<?php echo htmlspecialchars($user['img']); ?>" class="current-image">
            <?php endif; ?>
            <input type="file" name="img">
        </div>

        <button type="submit">بروزرسانی</button>
        <a href="index.php"><button type="button" class="back-btn">بازگشت</button></a>
    </form>
</body>
</html> 