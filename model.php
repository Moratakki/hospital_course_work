<?php
require_once 'config/db.php';

function getPDO()
{
    static $pdo = null;
    if ($pdo === null) {
        $config = require 'config/db.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}

function getAllPatients()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM `пациент`");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPatientById($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM `пациент` WHERE patient_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createPatient($name, $passport_data, $insurance_policy_number, $admission_time = null)
{
    $pdo = getPDO();

    // Если время не указано, используем текущее
    if ($admission_time === null) {
        $admission_time = date('Y-m-d H:i:s');
    }

    $stmt = $pdo->prepare("INSERT INTO `пациент` 
                          (name, passport_data, insurance_policy_number, admission_time) 
                          VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $passport_data, $insurance_policy_number, $admission_time]);

    return $pdo->lastInsertId();
}

function updatePatient($id, $name, $passport_data, $insurance_policy_number, $admission_time)
{
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("UPDATE `пациент` 
                              SET name = ?, passport_data = ?, 
                                  insurance_policy_number = ?, admission_time = ?
                              WHERE patient_id = ?");
        return $stmt->execute([
            $name,
            $passport_data,
            $insurance_policy_number,
            $admission_time,
            $id
        ]);
    } catch (PDOException $e) {
        error_log("Ошибка обновления пациента: " . $e->getMessage());
        return false;
    }
}

function deletePatient($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM `пациент` WHERE patient_id = ?");
    return $stmt->execute([$id]);
}

function getAllMedcards()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM `медкарта`");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMedcardById($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM `медкарта` WHERE card_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createMedcard($patient_id, $employee_id, $creation_date)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO `медкарта` (patient_id, employee_id, creation_date) VALUES (?, ?, ?)");
    $stmt->execute([$patient_id, $employee_id, $creation_date]);
    return $pdo->lastInsertId();
}

function updateMedcard($card_id, $patient_id, $employee_id, $creation_date)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("UPDATE `медкарта` 
                          SET patient_id = ?, employee_id = ?, creation_date = ?
                          WHERE card_id = ?");
    return $stmt->execute([$patient_id, $employee_id, $creation_date, $card_id]);
}

function deleteMedcard($card_id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM `медкарта` WHERE card_id = ?");
    return $stmt->execute([$card_id]);
}

// Вспомогательные функции
function getPatientName($patient_id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT name FROM `пациент` WHERE patient_id = ?");
    $stmt->execute([$patient_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    return $patient ? $patient['name'] : 'Неизвестный пациент';
}

function getEmployeeName($employee_id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT name FROM `сотрудник` WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $employee ? $employee['name'] : 'Неизвестный сотрудник';
}

function getAllEmployees()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM `сотрудник` ORDER BY employee_id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeeById($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM `сотрудник` WHERE employee_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createEmployee($name, $post)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO `сотрудник` (name, post) VALUES (?, ?)");
    $stmt->execute([$name, $post]);
    return $pdo->lastInsertId();
}

function updateEmployee($id, $name, $post)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("UPDATE `сотрудник` SET name = ?, post = ? WHERE employee_id = ?");
    return $stmt->execute([$name, $post, $id]);
}

function deleteEmployee($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM `сотрудник` WHERE employee_id = ?");
    return $stmt->execute([$id]);
}

function canDeleteEmployee($employee_id)
{
    $pdo = getPDO();

    // Проверяем, используется ли сотрудник в медкартах
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `медкарта` WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    $count = $stmt->fetchColumn();

    return $count == 0;
}

// Проверка зависимостей для пациента
function hasPatientDependencies($patient_id)
{
    $pdo = getPDO();

    // Проверяем наличие связанных медкарт
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `медкарта` WHERE patient_id = ?");
    $stmt->execute([$patient_id]);
    return $stmt->fetchColumn() > 0;
}

// Проверка зависимостей для медкарты
function hasMedcardDependencies($card_id)
{
    $pdo = getPDO();

    // Проверяем наличие связанных записей
    $tables = [
        'осмотр',
        'диагнозы_пациента',
        'анализы_пациента',
        'назначения',
        'выписка'
    ];

    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `$table` WHERE card_id = ?");
        $stmt->execute([$card_id]);
        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    return false;
}

// Проверка зависимостей для сотрудника
function hasEmployeeDependencies($employee_id)
{
    $pdo = getPDO();

    // Проверяем наличие связанных медкарт
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `медкарта` WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    return $stmt->fetchColumn() > 0;
}

// Получение информации о зависимостях
function getDependencyInfo($entity, $id)
{
    $pdo = getPDO();
    $info = [];

    switch ($entity) {
        case 'patient':
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `медкарта` WHERE patient_id = ?");
            $stmt->execute([$id]);
            $info['medcards'] = $stmt->fetchColumn();
            break;

        case 'medcard':
            $tables = [
                'осмотр' => 'осмотров',
                'диагнозы_пациента' => 'диагнозов',
                'анализы_пациента' => 'анализов',
                'назначения' => 'назначений',
                'выписка' => 'выписок'
            ];

            foreach ($tables as $table => $name) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM `$table` WHERE card_id = ?");
                $stmt->execute([$id]);
                $count = $stmt->fetchColumn();
                if ($count > 0) {
                    $info[$name] = $count;
                }
            }
            break;

        case 'employee':
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `медкарта` WHERE employee_id = ?");
            $stmt->execute([$id]);
            $info['medcards'] = $stmt->fetchColumn();
            break;
    }

    return $info;
}