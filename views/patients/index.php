<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert success">
        <?= htmlspecialchars($_SESSION['message']) ?>
        <?php unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert error">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<h1>Список пациентов</h1>
<a href="index.php?entity=patient&action=create"
    style="display: inline-block; margin-bottom: 20px; padding: 8px 15px; background: #4CAF50; color: white; text-decoration: none;">
    + Добавить нового пациента
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Паспортные данные</th>
        <th>Номер полиса</th>
        <th>Время поступления</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?= htmlspecialchars($patient['patient_id']) ?></td>
            <td><?= htmlspecialchars($patient['name']) ?></td>
            <td><?= htmlspecialchars($patient['passport_data']) ?></td>
            <td><?= htmlspecialchars($patient['insurance_policy_number']) ?></td>
            <td><?= date('d.m.Y H:i', strtotime($patient['admission_time'])) ?></td>
            <td>
                <!-- <a href="show.php?id=<?= $patient['patient_id'] ?>">Просмотр</a>
                <a href="edit.php?id=<?= $patient['patient_id'] ?>">Редактировать</a> -->
                <a href="index.php?entity=patient&action=delete&id=<?= $patient['patient_id'] ?>" class="btn btn-danger"
                    onclick="return confirm('Вы уверены, что хотите удалить этого пациента?')">
                    Удалить
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>