<?php
include 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit;
        }
    }
}
?>

<?php include 'header.php'; ?>

<h2>Вход в систему</h2>
<form method="post">
    <p>
        Логин: <input type="text" name="username" required>
    </p>
    <p>
        Пароль: <input type="password" name="password" required>
    </p>
    <button type="submit">Войти</button>
</form>

<?php include 'footer.php'; ?>