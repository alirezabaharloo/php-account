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

// دریافت لیست تمام کاربران به ترتیب نزولی
$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>سیستم مدیریت کاربران</title>
    <meta charset="utf-8">
    <style>
        /* استایل‌های ظاهری صفحه */
        body {
            font-family: Tahoma;
            direction: rtl;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
        }
        .btn-new {
            background: #4CAF50;
        }
        .btn-edit {
            background: #ff9800;
        }
        .btn-delete {
            background: #f44336;
        }
        .user-image {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <h2>مدیریت کاربران</h2>
    
    <!-- دکمه افزودن کاربر جدید -->
    <a href="new.php" class="btn btn-new">افزودن کاربر جدید</a>
    
    <!-- جدول نمایش کاربران -->
    <table>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>نام کاربری</th>
            <th>تصویر پروفایل</th>
            <th>عملیات</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($result)): ?>
        <!-- نمایش اطلاعات هر کاربر -->
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td>
                <?php if (!empty($user['img'])): ?>
                    <img src="<?php echo htmlspecialchars($user['img']); ?>" class="user-image" alt="تصویر پروفایل کاربر">
                <?php endif; ?>
            </td>
            <td>
                <!-- دکمه‌های عملیات -->
                <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-edit">ویرایش</a>
                <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-delete" 
                   onclick="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">حذف</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // پایان ارتباط با پایگاه داده
    mysqli_close($connection);
    ?>
</body>
</html> 