<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $connection->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<h2>Регистрация</h2>
<form method="post">
    <p>
        Логин: <input type="text" name="username" required>
    </p>
    <p>
        Пароль: <input type="password" name="password" required>
    </p>
    <p>
        Роль:
        <select name="role">
            <option value="client">Клиент</option>
            <option value="worker">Работник</option>
        </select>
    </p>
    <button type="submit">Зарегистрироваться</button>
</form>

<?php include 'footer.php'; ?>