<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Добавить нового пациента</h1>

<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST" action="index.php?entity=patient&action=store">
    <div>
        <label for="name">ФИО:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label for="passport_data">Паспортные данные:</label>
        <input type="text" id="passport_data" name="passport_data" required>
    </div>

    <div>
        <label for="insurance_policy_number">Номер страхового полиса:</label>
        <input type="text" id="insurance_policy_number" name="insurance_policy_number" required>
    </div>

    <div>
        <label for="admission_time">Время поступления:</label>
        <input type="datetime-local" id="admission_time" name="admission_time" value="<?= date('Y-m-d\TH:i') ?>"
            required>
    </div>

    <button type="submit">Добавить пациента</button>
    <a href="index.php?entity=patient&action=index">Отмена</a>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>