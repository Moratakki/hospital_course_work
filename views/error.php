<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="error-container">
    <h2>Ошибка</h2>
    <div class="error-message">
        <?= $error ?? 'Произошла неизвестная ошибка' ?>
    </div>

    <div class="actions">
        <a href="javascript:history.back()" class="btn">Назад</a>
        <a href="index.php" class="btn">На главную</a>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>