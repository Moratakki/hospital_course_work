<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="medcard-details">
    <h1>Медицинская карта #<?= $medcard['card_id'] ?></h1>

    <div class="detail-item">
        <span class="detail-label">ID карты:</span>
        <span class="detail-value"><?= $medcard['card_id'] ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Пациент:</span>
        <span class="detail-value"><?= getPatientName($medcard['patient_id']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Сотрудник:</span>
        <span class="detail-value"><?= getEmployeeName($medcard['employee_id']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Дата создания:</span>
        <span class="detail-value"><?= date('d.m.Y H:i', strtotime($medcard['creation_date'])) ?></span>
    </div>

    <div class="actions">
        <a href="index.php?entity=medcard&action=edit&id=<?= $medcard['card_id'] ?>" class="btn">
            Редактировать
        </a>
        <a href="index.php?entity=medcard&action=index" class="btn">
            ← Назад к списку
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>