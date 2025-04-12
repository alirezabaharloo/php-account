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
    // اگر شناسه وجود نداشت، برگرد به صفحه اصلی
    header('Location: index.php');
    die();
}

// دریافت شناسه کاربر
$id = $_GET['id'];

// پیدا کردن تصویر کاربر
$query = "SELECT img FROM users WHERE id = '$id'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);

// حذف تصویر از پوشه
if ($user && $user['img'] != '') {
    // اگر تصویر وجود داشت، از پوشه حذف کن
    if (file_exists($user['img'])) {
        unlink($user['img']);
    }
}

// حذف کاربر از دیتابیس
$query = "DELETE FROM users WHERE id = '$id'";
mysqli_query($connection, $query);

// بستن اتصال دیتابیس
mysqli_close($connection);

// برگشت به صفحه اصلی
header('Location: index.php');
die();
?> 