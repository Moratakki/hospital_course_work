<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Редактирование медицинской карты #<?= $medcard['card_id'] ?></h1>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert success">
        <?= htmlspecialchars($_SESSION['message']) ?>
        <?php unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?entity=medcard&action=update">
    <input type="hidden" name="card_id" value="<?= $medcard['card_id'] ?>">

    <div class="form-group">
        <label for="patient_id">Пациент:</label>
        <select id="patient_id" name="patient_id" class="form-control" required>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['patient_id'] ?>" <?= $patient['patient_id'] == $medcard['patient_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($patient['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="employee_id">Сотрудник:</label>
        <select id="employee_id" name="employee_id" class="form-control" required>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= $employee['employee_id'] ?>" <?= $employee['employee_id'] == $medcard['employee_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($employee['name']) ?> (<?= htmlspecialchars($employee['post']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="creation_date">Дата создания:</label>
        <input type="datetime-local" id="creation_date" name="creation_date" class="form-control"
            value="<?= date('Y-m-d\TH:i', strtotime($medcard['creation_date'])) ?>" required>
    </div>

    <div class="actions">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="index.php?entity=medcard&action=show&id=<?= $medcard['card_id'] ?>" class="btn">
            Отмена
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>