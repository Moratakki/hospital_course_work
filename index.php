<?php
session_start();

$entity = $_GET['entity'] ?? 'patient';
$action = $_GET['action'] ?? 'index';

$controllerFile = __DIR__ . "/controllers/{$entity}_controller.php";

if (!file_exists($controllerFile)) {
    die("Контроллер для сущности '$entity' не найден");
}

require_once $controllerFile;

if (!function_exists($action)) {
    die("Действие '$action' не найдено в контроллере для '$entity'");
}

$action();