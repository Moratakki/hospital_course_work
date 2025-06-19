<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="employee-details">
    <h1>Сотрудник: <?= htmlspecialchars($employee['name']) ?></h1>

    <div class="detail-item">
        <span class="detail-label">ID сотрудника:</span>
        <span class="detail-value"><?= $employee['employee_id'] ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">ФИО:</span>
        <span class="detail-value"><?= htmlspecialchars($employee['name']) ?></span>
    </div>

    <div class="detail-item">
        <span class="detail-label">Должность:</span>
        <span class="detail-value"><?= htmlspecialchars($employee['post']) ?></span>
    </div>

    <div class="actions">
        <a href="index.php?entity=employee&action=edit&id=<?= $employee['employee_id'] ?>" class="btn">
            Редактировать
        </a>
        <a href="index.php?entity=employee&action=index" class="btn">
            ← Назад к списку
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>