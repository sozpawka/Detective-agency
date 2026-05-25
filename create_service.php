<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: index.php");
    exit;
}

$clientsResult = $connection->query("SELECT id, fullName FROM clients");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientId = $_POST['clientId'];
    $description = $_POST['description'];
    $serviceDate = $_POST['serviceDate'];
    $serviceCost = $_POST['serviceCost'];
    $paid = $_POST['paid'];
    $stmt = $connection->prepare("INSERT INTO services (clientId, description, serviceDate, serviceCost, paid) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $clientId, $description, $serviceDate, $serviceCost, $paid);
    $stmt->execute();

    header("Location: services.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<h2>Добавить услугу</h2>

<form method="post">
    <p>
        Клиент
        <select name="clientId" required>
            <?php while($row = $clientsResult->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo htmlspecialchars($row['fullName']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </p>
    <p>
        Описание услуги <textarea name="description" required></textarea>
    </p>
    <p>
        Дата <input type="date" name="serviceDate" required>
    </p>
    <p>
        Стоимость <input type="number" name="serviceCost" step="0.01" required>
    </p>
    <p>
        Оплата
        <select name="paid">
            <option value="No">Не оплачено</option>
            <option value="Yes">Оплачено</option>
        </select>
    </p>

    <button type="submit">Создать</button>
</form>

<?php include 'footer.php'; ?>