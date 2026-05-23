<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'worker') {
    $sql = "SELECT services.id, clients.fullName, services.serviceDescription, services.serviceDate, services.serviceCost, services.paid 
            FROM services 
            JOIN clients ON services.clientId = clients.id";
    $result = $connection->query($sql);
} else {
    $stmt = $connection->prepare("SELECT services.id, clients.fullName, services.serviceDescription, services.serviceDate, services.serviceCost, services.paid 
            FROM services 
            JOIN clients ON services.clientId = clients.id 
            WHERE clients.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<?php include 'header.php'; ?>

<h2>Оказанные услуги</h2>

<?php if ($role === 'worker'): ?>
    <p><a href="create_service.php">Добавить новую услугу</a></p>
<?php endif; ?>

<?php if ($result->num_rows == 0): ?>
    <p style="color: #AEAEAE">Пока нет заказанных услуг.</p>
<?php else: ?>
    <?php
    $totalSum = 0;
    $paidSum = 0;
    $unpaidSum = 0;
    ?>

    <table>
        <tr>
            <th>Клиент</th>
            <th>Описание услуги</th>
            <th>Дата</th>
            <th>Стоимость</th>
            <th>Статус оплаты</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <?php
            $cost = (float)$row['serviceCost'];
            $totalSum += $cost;
            if ($row['paid'] === 'Yes') {
                $paidSum += $cost;
            } else {
                $unpaidSum += $cost;
            }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fullName']); ?></td>
                <td><?php echo htmlspecialchars($row['serviceDescription']); ?></td>
                <td><?php echo htmlspecialchars($row['serviceDate']); ?></td>
                <td><?php echo htmlspecialchars($row['serviceCost']); ?> руб.</td>
                <td><?php echo $row['paid'] === 'Yes' ? 'Оплачено' : 'Не оплачено'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div class="services-summary">
        <div class="summary-item">
            Общая сумма: <span><?php echo htmlspecialchars($totalSum); ?> руб.</span>
        </div>
        <div class="summary-item">
            Оплачено: <span><?php echo htmlspecialchars($paidSum); ?> руб.</span>
        </div>
        <div class="summary-item">
            Не оплачено: <span><?php echo htmlspecialchars($unpaidSum); ?> руб.</span>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>