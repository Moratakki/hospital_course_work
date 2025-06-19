<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="patient-details">
    <h1>Просмотр пациента</h1>

    <div class="detail-item">
        <span class="detail-label">ID пациента:</span>
        <span class="detail-value"><?= htmlspecialchars($patient['patient_id']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">ФИО:</span>
        <span class="detail-value"><?= htmlspecialchars($patient['name']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Паспортные данные:</span>
        <span class="detail-value"><?= htmlspecialchars($patient['passport_data']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Номер страхового полиса:</span>
        <span class="detail-value"><?= htmlspecialchars($patient['insurance_policy_number']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Время поступления:</span>
        <span class="detail-value"><?= date('d.m.Y H:i', strtotime($patient['admission_time'])) ?></span>
    </div>

    <div class="actions">
        <a href="index.php?entity=patient&action=edit&id=<?= $patient['patient_id'] ?>" class="btn">
            Редактировать
        </a>
        <a href="index.php?entity=patient&action=index" class="btn">
            ← Назад к списку
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>