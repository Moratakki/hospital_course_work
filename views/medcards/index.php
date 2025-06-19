<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Медицинские карты</h1>
<a href="index.php?entity=medcard&action=create" class="btn btn-success">
    + Создать новую медкарту
</a>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert success">
        <?= htmlspecialchars($_SESSION['message']) ?>
        <?php unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Пациент</th>
            <th>Сотрудник</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medcards as $medcard): ?>
            <tr>
                <td><?= $medcard['card_id'] ?></td>
                <td><?= getPatientName($medcard['patient_id']) ?></td>
                <td><?= getEmployeeName($medcard['employee_id']) ?></td>
                <td><?= date('d.m.Y H:i', strtotime($medcard['creation_date'])) ?></td>
                <td class="actions">
                    <a href="index.php?entity=medcard&action=show&id=<?= $medcard['card_id'] ?>" class="btn">
                        Просмотр
                    </a>
                    <a href="index.php?entity=medcard&action=edit&id=<?= $medcard['card_id'] ?>" class="btn">
                        Редактировать
                    </a>
                    <a href="index.php?entity=medcard&action=delete&id=<?= $medcard['card_id'] ?>" class="btn btn-danger"
                        onclick="return confirm('Вы уверены, что хотите удалить эту медкарту?')">
                        Удалить
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>