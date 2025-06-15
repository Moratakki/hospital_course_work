<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="error-message">
    <h1>Ошибка</h1>
    <p><?= htmlspecialchars($error ?? 'Произошла неизвестная ошибка') ?></p>
    <a href="index.php" class="btn">← На главную</a>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>