<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: index.php");
    exit;
}

$result = $connection->query("SELECT * FROM clients");
?>

<?php include 'header.php'; ?>

<h2>Сведения о клиентах</h2>

<p><a href="create_client.php">Добавить нового клиента</a></p>

<?php if ($result->num_rows == 0): ?>
    <p style="color: #AEAEAE">Пока нет зарегистрированных клиентов.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fullName']); ?></td>
                <td><?php echo htmlspecialchars($row['phoneNumber']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>