<?php
// تنظیمات اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

// برقراری ارتباط با پایگاه داده
$connection = mysqli_connect($servername, $username, $password, $dbname);

// بررسی وضعیت اتصال
if (!$connection) {
    die("خطا در اتصال به پایگاه داده: " . mysqli_connect_error());
}

// بررسی وجود شناسه کاربر در پارامترهای URL
if (!isset($_GET['id'])) {
    // انتقال به صفحه اصلی در صورت عدم وجود شناسه
    header('Location: index.php');
    die();
}

// دریافت شناسه کاربر
$id = $_GET['id'];

// دریافت اطلاعات تصویر کاربر قبل از حذف
$query = "SELECT img FROM users WHERE id = '$id'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);

// حذف فایل تصویر از سرور
if ($user && $user['img'] != '') {
    // بررسی وجود فایل و حذف آن
    if (file_exists($user['img'])) {
        unlink($user['img']);
    }
}

// حذف اطلاعات کاربر از پایگاه داده
$query = "DELETE FROM users WHERE id = '$id'";
mysqli_query($connection, $query);

// پایان ارتباط با پایگاه داده
mysqli_close($connection);

// بازگشت به صفحه اصلی
header('Location: index.php');
die();
?> 