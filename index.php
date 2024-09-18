
<?php
// تفاصيل الاتصال بقاعدة البيانات
$host = 'sql202.infinityfree.com';
$user = '	if0_37257343';
$pass = '576ym9pn';
$db = 'if0_37257343_b'

// إقامة اتصال آمن بقاعدة البيانات
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التعامل مع إرسال نموذج التسجيل
if (isset($_POST['register'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // لا تشفير كلمة المرور، فقط تخزينها كنص عادي
    // Prepare and execute the query to insert user data
    $query = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('ss', $email, $password);
        if ($stmt->execute()) {
            echo "<p>المعدرة اعد التشجيل !</p>";
        } else {
            echo "<p>فشل التسجيل: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>فشل الاستعلام عن قاعدة البيانات: " . $conn->error . "</p>";
    }
}

// التعامل مع إرسال نموذج تسجيل الدخول
if (isset($_POST['login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // إعداد وتنفيذ الاستعلام لاسترجاع بيانات المستخدم
    $query = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            // التحقق من كلمة المرور
            if ($password === $stored_password) {
                echo "<p>المعدرة حاول مرة اخرى  !</p>";
            } else {
                echo "<p>كلمة مرور غير صحيحة!</p>";
            }
        } else {
            echo "<p>لم يتم العثور على مستخدم بهذا البريد الإلكتروني!</p>";
        }
        $stmt->close();
    } else {
        echo "<p>فشل الاستعلام عن قاعدة البيانات: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وثيقة</title>
    <link rel="stylesheet" href="c.css">
</head>
<body>
    <!-- نموذج التسجيل -->
    <form method="POST" action="">
        <center>
        <img src="H.jpeg" alt="" width="20">
        <h2>تسجيل</h2>
        </center>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required><br>
        <input type="password" name="password" placeholder="كلمة المرور" required><br>
        <input type="submit" name="register" value="تسجيل">  
      </form>

    <!-- 
</body>
</html>
