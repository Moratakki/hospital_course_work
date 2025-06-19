<?php
require_once __DIR__ . '/../model.php';

function index()
{
    $medcards = getAllMedcards();
    require __DIR__ . '/../views/medcards/index.php';
}

function show()
{
    if (!isset($_GET['id'])) {
        $error = "ID медкарты не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];
    $medcard = getMedcardById($id);

    if (!$medcard) {
        $error = "Медкарта с ID $id не найдена";
        require __DIR__ . '/../views/error.php';
        return;
    }

    require __DIR__ . '/../views/medcards/show.php';
}

function create()
{
    $patients = getAllPatients();
    $employees = getAllEmployees();
    require __DIR__ . '/../views/medcards/create.php';
}

function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $patient_id = (int) $_POST['patient_id'];
        $employee_id = (int) $_POST['employee_id'];
        $creation_date = $_POST['creation_date'] ?? date('Y-m-d H:i:s');

        $errors = [];
        if (empty($patient_id))
            $errors[] = "Необходимо выбрать пациента";
        if (empty($employee_id))
            $errors[] = "Необходимо выбрать сотрудника";

        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            require __DIR__ . '/../views/error.php';
            return;
        }

        $id = createMedcard($patient_id, $employee_id, $creation_date);

        if ($id === false) {
            $error = "Ошибка при создании медкарты";
            require __DIR__ . '/../views/error.php';
            return;
        }

        header("Location: index.php?entity=medcard&action=show&id=$id");
        exit;
    }

    $error = "Недопустимый метод запроса";
    require __DIR__ . '/../views/error.php';
}

function edit()
{
    if (!isset($_GET['id'])) {
        $error = "ID медкарты не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];
    $medcard = getMedcardById($id);

    if (!$medcard) {
        $error = "Медкарта с ID $id не найдена";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $patients = getAllPatients();
    $employees = getAllEmployees();
    require __DIR__ . '/../views/medcards/edit.php';
}

function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $card_id = (int) $_POST['card_id'];
        $patient_id = (int) $_POST['patient_id'];
        $employee_id = (int) $_POST['employee_id'];
        $creation_date = $_POST['creation_date'];

        $errors = [];
        if (empty($card_id))
            $errors[] = "ID медкарты не указан";
        if (empty($patient_id))
            $errors[] = "Необходимо выбрать пациента";
        if (empty($employee_id))
            $errors[] = "Необходимо выбрать сотрудника";
        if (empty($creation_date))
            $errors[] = "Дата создания обязательна";

        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            require __DIR__ . '/../views/error.php';
            return;
        }

        $success = updateMedcard($card_id, $patient_id, $employee_id, $creation_date);

        if ($success) {
            $_SESSION['message'] = "Медкарта успешно обновлена";
            header("Location: index.php?entity=medcard&action=show&id=$card_id");
            exit;
        } else {
            $error = "Ошибка при обновлении медкарты";
            require __DIR__ . '/../views/error.php';
        }
    }

    $error = "Недопустимый запрос";
    require __DIR__ . '/../views/error.php';
}

function delete()
{
    if (!isset($_GET['id'])) {
        $error = "ID медкарты не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];

    try {
        if (hasMedcardDependencies($id)) {
            $dependencies = getDependencyInfo('medcard', $id);
            $error = "Невозможно удалить медкарту, так как она содержит связанные данные:";
            $error .= "<ul>";
            foreach ($dependencies as $type => $count) {
                $error .= "<li>$count $type</li>";
            }
            $error .= "</ul>";
            require __DIR__ . '/../views/error.php';
            return;
        }

        $success = deleteMedcard($id);

        if ($success) {
            $_SESSION['message'] = "Медкарта успешно удалена";
            header("Location: index.php?entity=medcard&action=index");
            exit;
        } else {
            $error = "Ошибка при удалении медкарты";
            require __DIR__ . '/../views/error.php';
        }
    } catch (PDOException $e) {
        $error = "Ошибка при удалении: " . $e->getMessage();
        require __DIR__ . '/../views/error.php';
    }
}