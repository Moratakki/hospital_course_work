<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Создание новой медицинской карты</h1>

<form method="POST" action="index.php?entity=medcard&action=store">
    <div class="form-group">
        <label for="patient_id">Пациент:</label>
        <select id="patient_id" name="patient_id" class="form-control" required>
            <option value="">Выберите пациента</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['patient_id'] ?>">
                    <?= htmlspecialchars($patient['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="employee_id">Сотрудник:</label>
        <select id="employee_id" name="employee_id" class="form-control" required>
            <option value="">Выберите сотрудника</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= $employee['employee_id'] ?>">
                    <?= htmlspecialchars($employee['name']) ?> (<?= htmlspecialchars($employee['post']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="creation_date">Дата создания:</label>
        <input type="datetime-local" id="creation_date" name="creation_date" class="form-control"
            value="<?= date('Y-m-d\TH:i') ?>" required>
    </div>

    <div class="actions">
        <button type="submit" class="btn btn-primary">Создать медкарту</button>
        <a href="index.php?entity=medcard&action=index" class="btn">
            Отмена
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>