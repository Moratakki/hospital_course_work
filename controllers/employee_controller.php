<?php
require_once __DIR__ . '/../model.php';

// Список всех сотрудников
function index()
{
    $employees = getAllEmployees();
    require __DIR__ . '/../views/employees/index.php';
}

// Просмотр одного сотрудника
function show()
{
    if (!isset($_GET['id'])) {
        $error = "ID сотрудника не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];
    $employee = getEmployeeById($id);

    if (!$employee) {
        $error = "Сотрудник с ID $id не найден";
        require __DIR__ . '/../views/error.php';
        return;
    }

    require __DIR__ . '/../views/employees/show.php';
}

// Форма создания сотрудника
function create()
{
    require __DIR__ . '/../views/employees/create.php';
}

// Сохранение нового сотрудника
function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $post = trim($_POST['post'] ?? '');

        // Валидация
        $errors = [];
        if (empty($name))
            $errors[] = "ФИО обязательно для заполнения";
        if (empty($post))
            $errors[] = "Должность обязательна";

        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            require __DIR__ . '/../views/error.php';
            return;
        }

        // Создаем сотрудника
        $id = createEmployee($name, $post);

        if ($id === false) {
            $error = "Ошибка при создании сотрудника";
            require __DIR__ . '/../views/error.php';
            return;
        }

        header("Location: index.php?entity=employee&action=show&id=$id");
        exit;
    }

    $error = "Недопустимый метод запроса";
    require __DIR__ . '/../views/error.php';
}

// Форма редактирования сотрудника
function edit()
{
    if (!isset($_GET['id'])) {
        $error = "ID сотрудника не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];
    $employee = getEmployeeById($id);

    if (!$employee) {
        $error = "Сотрудник с ID $id не найден";
        require __DIR__ . '/../views/error.php';
        return;
    }

    require __DIR__ . '/../views/employees/edit.php';
}

// Обновление сотрудника
function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int) $_POST['employee_id'];
        $name = trim($_POST['name'] ?? '');
        $post = trim($_POST['post'] ?? '');

        // Валидация
        $errors = [];
        if (empty($id))
            $errors[] = "ID сотрудника не указан";
        if (empty($name))
            $errors[] = "ФИО обязательно для заполнения";
        if (empty($post))
            $errors[] = "Должность обязательна";

        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            require __DIR__ . '/../views/error.php';
            return;
        }

        // Обновляем данные сотрудника
        $success = updateEmployee($id, $name, $post);

        if ($success) {
            $_SESSION['message'] = "Данные сотрудника успешно обновлены";
            header("Location: index.php?entity=employee&action=show&id=$id");
            exit;
        } else {
            $error = "Ошибка при обновлении данных сотрудника";
            require __DIR__ . '/../views/error.php';
        }
    }

    $error = "Недопустимый запрос";
    require __DIR__ . '/../views/error.php';
}

// Удаление сотрудника
function delete()
{
    if (!isset($_GET['id'])) {
        $error = "ID сотрудника не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];

    try {
        // Проверяем зависимости
        if (hasEmployeeDependencies($id)) {
            $dependencies = getDependencyInfo('employee', $id);
            $error = "Невозможно удалить сотрудника, так как он связан с медицинскими картами (" . $dependencies['medcards'] . ").";
            require __DIR__ . '/../views/error.php';
            return;
        }

        // Удаляем сотрудника
        $success = deleteEmployee($id);

        if ($success) {
            $_SESSION['message'] = "Сотрудник успешно удален";
            header("Location: index.php?entity=employee&action=index");
            exit;
        } else {
            $error = "Ошибка при удалении сотрудника";
            require __DIR__ . '/../views/error.php';
        }
    } catch (PDOException $e) {
        $error = "Ошибка при удалении: " . $e->getMessage();
        require __DIR__ . '/../views/error.php';
    }
}