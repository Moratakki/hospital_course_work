<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Редактирование сотрудника</h1>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert success">
        <?= htmlspecialchars($_SESSION['message']) ?>
        <?php unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?entity=employee&action=update">
    <input type="hidden" name="employee_id" value="<?= $employee['employee_id'] ?>">

    <div class="form-group">
        <label for="name">ФИО:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($employee['name']) ?>"
            required>
    </div>

    <div class="form-group">
        <label for="post">Должность:</label>
        <input type="text" id="post" name="post" class="form-control" value="<?= htmlspecialchars($employee['post']) ?>"
            required>
    </div>

    <div class="actions">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="index.php?entity=employee&action=show&id=<?= $employee['employee_id'] ?>" class="btn">
            Отмена
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>