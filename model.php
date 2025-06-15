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
    $stmt = $pdo->prepare("UPDATE `пациент` 
                          SET name = ?, passport_data = ?, insurance_policy_number = ?, admission_time = ?
                          WHERE patient_id = ?");
    return $stmt->execute([$name, $passport_data, $insurance_policy_number, $admission_time, $id]);
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