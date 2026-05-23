<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detective Agency</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Детективное агентство</h1>
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>
                Привет,
                <?php echo htmlspecialchars($_SESSION['username']); ?>
                (<?php echo $_SESSION['role'] == 'worker' ? 'Работник' : 'Клиент'; ?>)
            </span>
            <a class="logout" href="logout.php">Выйти</a>
        <?php else: ?>
            <a href="login.php">Войти</a>
            <a href="register.php">Регистрация</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">
    <?php if (isset($_SESSION['user_id'])): ?>
        <nav>
            <a href="index.php">Главная</a>
            <?php if ($_SESSION['role'] == 'worker'): ?>
                <a href="clients.php">Клиенты</a>
            <?php endif; ?>
            <a href="services.php">Услуги и Учет средств</a>
        </nav>
        <hr>
    <?php endif; ?>