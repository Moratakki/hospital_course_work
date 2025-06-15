<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Просмотр пациента</h1>

<?php if (!empty($patient)): ?>
    <div class="patient-details">
        <p><strong>ID пациента:</strong> <?= htmlspecialchars($patient['patient_id'] ?? '') ?></p>
        <p><strong>ФИО:</strong> <?= htmlspecialchars($patient['name'] ?? '') ?></p>
        <p><strong>Паспортные данные:</strong> <?= htmlspecialchars($patient['passport_data'] ?? '') ?></p>
        <p><strong>Номер страхового полиса:</strong> <?= htmlspecialchars($patient['insurance_policy_number'] ?? '') ?></p>
        <p><strong>Время поступления:</strong>
            <?= date('d.m.Y H:i', strtotime($patient['admission_time'])) ?>
        </p>
    </div>

    <div class="actions">
        <!-- <a href="index.php?entity=patient&action=edit&id=<?= $patient['patient_id'] ?>" class="btn">Редактировать</a> -->
        <a href="index.php?entity=patient&action=delete&id=<?= $patient['patient_id'] ?>" class="btn btn-danger"
            onclick="return confirm('Вы уверены, что хотите удалить этого пациента?')">
            Удалить пациента
        </a>
    </div>
<?php else: ?>
    <p>Пациент не найден.</p>
<?php endif; ?>

<a href="index.php?entity=patient&action=index" class="btn">← Назад к списку пациентов</a>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>