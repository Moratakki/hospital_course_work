<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<h1>Добавление нового сотрудника</h1>

<form method="POST" action="index.php?entity=employee&action=store">
    <div class="form-group">
        <label for="name">ФИО:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="post">Должность:</label>
        <input type="text" id="post" name="post" class="form-control" required>
    </div>

    <div class="actions">
        <button type="submit" class="btn btn-primary">Добавить сотрудника</button>
        <a href="index.php?entity=employee&action=index" class="btn">
            Отмена
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>