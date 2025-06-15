<?php
require_once __DIR__ . '/../model.php';

function index()
{
    $patients = getAllPatients();
    require __DIR__ . '/../views/patients/index.php';
}

function show()
{
    if (!isset($_GET['id'])) {
        die("ID пациента не указан");
    }

    $id = (int) $_GET['id'];
    $patient = getPatientById($id);

    if (!$patient) {
        $error = "Пациент с ID $id не найден";
        require __DIR__ . '/../views/error.php';
        return;
    }

    require __DIR__ . '/../views/patients/show.php';
}

function create()
{
    require __DIR__ . '/../views/patients/create.php';
}

function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получаем данные из формы
        $name = trim($_POST['name'] ?? '');
        $passport_data = trim($_POST['passport_data'] ?? '');
        $insurance_policy_number = trim($_POST['insurance_policy_number'] ?? '');
        $admission_time = trim($_POST['admission_time'] ?? date('Y-m-d H:i:s'));

        // Валидация
        $errors = [];
        if (empty($name))
            $errors[] = "ФИО обязательно для заполнения";
        if (empty($passport_data))
            $errors[] = "Паспортные данные обязательны";
        if (empty($insurance_policy_number))
            $errors[] = "Номер полиса обязателен";

        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            require __DIR__ . '/../views/error.php';
            return;
        }

        // Создаем пациента
        $id = createPatient($name, $passport_data, $insurance_policy_number, $admission_time);

        if ($id === false) {
            $error = "Ошибка при создании пациента";
            require __DIR__ . '/../views/error.php';
            return;
        }

        header("Location: index.php?entity=patient&action=show&id=$id");
        exit;
    }

    $error = "Недопустимый метод запроса";
    require __DIR__ . '/../views/error.php';
}

function edit()
{
    if (!isset($_GET['id'])) {
        die("ID пациента не указан");
    }
    $id = $_GET['id'];
    $patient = getPatientById($id);
    require '../views/patients/edit.php';
}

function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
        $id = (int) $_POST['patient_id'];
        $name = trim($_POST['name'] ?? '');
        $passport_data = trim($_POST['passport_data'] ?? '');
        $insurance_policy_number = trim($_POST['insurance_policy_number'] ?? '');
        $admission_time = trim($_POST['admission_time'] ?? '');

        // Валидация
        $errors = [];
        if (empty($name))
            $errors[] = "ФИО обязательно для заполнения";
        if (empty($passport_data))
            $errors[] = "Паспортные данные обязательны";
        if (empty($insurance_policy_number))
            $errors[] = "Номер полиса обязателен";
        if (empty($admission_time))
            $errors[] = "Время поступления обязательно";

        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            require __DIR__ . '/../views/error.php';
            return;
        }

        // Обновляем данные
        $success = updatePatient($id, $name, $passport_data, $insurance_policy_number, $admission_time);

        if ($success) {
            header("Location: index.php?entity=patient&action=show&id=$id");
            exit;
        } else {
            $error = "Ошибка при обновлении данных пациента";
            require __DIR__ . '/../views/error.php';
        }
    }

    $error = "Недопустимый запрос";
    require __DIR__ . '/../views/error.php';
}

function delete()
{
    if (!isset($_GET['id'])) {
        $error = "ID пациента не указан";
        require __DIR__ . '/../views/error.php';
        return;
    }

    $id = (int) $_GET['id'];
    $success = deletePatient($id);

    if ($success) {
        $_SESSION['message'] = "Пациент успешно удалён";
        header("Location: index.php?entity=patient&action=index");
        exit;
    } else {
        $error = "Ошибка при удалении пациента";
        require __DIR__ . '/../views/error.php';
    }
}