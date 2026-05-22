<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detective Agency</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            color: #222;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        header {
            background: #2c3e50;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }

        header .logout {
            color: #e74c3c;
            font-weight: bold;
        }

        footer {
            background: #34495e;
            color: #fff;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            margin-bottom: 60px;
        }

        .forms-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .empty-text {
            color: #7f8c8d;
            font-style: italic;
            text-align: center;
            margin-top: 40px;
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 20px;
            color: #2c3e50;
            font-weight: bold;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }

        th, td {
            border: 1px solid #bdc3c7;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #ecf0f1;
        }

        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #bdc3c7;
            max-width: 400px;
        }

        form p {
            margin: 0 0 15px 0;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            background: #2ecc71;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

<header>
    <h1>Детективное агентство</h1>
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>Привет, <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo $_SESSION['role'] == 'worker' ? 'Работник' : 'Клиент'; ?>)</span>
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