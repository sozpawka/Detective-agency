<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $connection->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'client')");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $userId = $stmt->insert_id;

    $stmt = $connection->prepare("INSERT INTO clients (fullName, phoneNumber, email, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $fullName, $phoneNumber, $email, $userId);
    $stmt->execute();

    header("Location: clients.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<h2>Добавить клиента</h2>

<form method="post">
    <p>
        Username <input type="text" name="username" required>
    </p>

    <p>
        Password <input type="password" name="password" required>
    </p>

    <p>
        ФИО <input type="text" name="fullName" required>
    </p>

    <p>
        Телефон <input type="text" name="phoneNumber" required>
    </p>

    <p>
        Email <input type="text" name="email" required>
    </p>

    <button type="submit">Создать</button>
</form>

<?php include 'footer.php'; ?>