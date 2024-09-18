<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'meta';

// إقامة اتصال بقاعدة البيانات
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التحقق من وجود البريد الإلكتروني في طلب GET
if (isset($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);

    // إعداد وتنفيذ الاستعلام لاسترجاع بيانات المستخدم
    $query = "SELECT email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_email, $user_password);
            $stmt->fetch();
            $user_data = array(
                'email' => $user_email,
                'password' => $user_password
            );
        } else {
            $user_data = null;
        }
        $stmt->close();
    } else {
        echo "<p>فشل الاستعلام عن قاعدة البيانات: " . $conn->error . "</p>";
    }
} else {
    echo "<p>لم يتم تحديد البريد الإلكتروني!</p>";
    $user_data = null;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف المستخدم</title>
    <link rel="stylesheet" href="c.css">
</head>
<body>
    <center>
        <h2>ملف المستخدم</h2>
        <?php if ($user_data): ?>
            <p><strong>البريد الإلكتروني:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            <p><strong>كلمة المرور:</strong> <?php echo htmlspecialchars($user_data['password']); ?></p>
        <?php else: ?>
            <p>لم يتم العثور على بيانات المستخدم.</p>
        <?php endif; ?>
    </center>
</body>
</html>
