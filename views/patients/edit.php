<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Редактирование пациента</h1>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert success">
        <?= htmlspecialchars($_SESSION['message']) ?>
        <?php unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?entity=patient&action=update">
    <input type="hidden" name="patient_id" value="<?= $patient['patient_id'] ?>">

    <div class="form-group">
        <label for="name">ФИО:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($patient['name']) ?>" required>
    </div>

    <div class="form-group">
        <label for="passport_data">Паспортные данные:</label>
        <input type="text" id="passport_data" name="passport_data"
            value="<?= htmlspecialchars($patient['passport_data']) ?>" required>
    </div>

    <div class="form-group">
        <label for="insurance_policy_number">Номер страхового полиса:</label>
        <input type="text" id="insurance_policy_number" name="insurance_policy_number"
            value="<?= htmlspecialchars($patient['insurance_policy_number']) ?>" required>
    </div>

    <div class="form-group">
        <label for="admission_time">Время поступления:</label>
        <input type="datetime-local" id="admission_time" name="admission_time"
            value="<?= date('Y-m-d\TH:i', strtotime($patient['admission_time'])) ?>" required>
    </div>

    <div class="actions">
        <button type="submit" class="btn">Сохранить изменения</button>
        <a href="index.php?entity=patient&action=show&id=<?= $patient['patient_id'] ?>" class="btn">
            Отмена
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>