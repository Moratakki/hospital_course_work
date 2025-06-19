<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Сотрудники</h1>
<a href="index.php?entity=employee&action=create" class="btn btn-success">
    + Добавить нового сотрудника
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
            <th>ФИО</th>
            <th>Должность</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= $employee['employee_id'] ?></td>
                <td><?= htmlspecialchars($employee['name']) ?></td>
                <td><?= htmlspecialchars($employee['post']) ?></td>
                <td class="actions">
                    <a href="index.php?entity=employee&action=show&id=<?= $employee['employee_id'] ?>" class="btn">
                        Просмотр
                    </a>
                    <a href="index.php?entity=employee&action=edit&id=<?= $employee['employee_id'] ?>" class="btn">
                        Редактировать
                    </a>
                    <a href="index.php?entity=employee&action=delete&id=<?= $employee['employee_id'] ?>"
                        class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этого сотрудника?')">
                        Удалить
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>