<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$configFile = __DIR__ . '/config.php';
if (!file_exists($configFile)) {
    http_response_code(500);
    echo json_encode(['error' => 'config.php не найден на сервере'], JSON_UNESCAPED_UNICODE);
    exit;
}

$config = require $configFile;
require_once __DIR__ . '/smtp.php';
require_once __DIR__ . '/data/registration-email.php';

if ($config['email'] === '' || $config['password'] === '') {
    http_response_code(500);
    echo json_encode(['error' => 'Не настроена почта на сервере (.env)'], JSON_UNESCAPED_UNICODE);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверный формат данных'], JSON_UNESCAPED_UNICODE);
    exit;
}

$name = trim(strip_tags((string) ($input['name'] ?? '')));
$email = trim((string) ($input['email'] ?? ''));
$sphere = trim(strip_tags((string) ($input['sphere'] ?? '')));
$request = trim(strip_tags((string) ($input['request'] ?? '')));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Заполните имя и корректный email'], JSON_UNESCAPED_UNICODE);
    exit;
}

$html = renderRegistrationEmail([
    'name' => $name,
    'email' => $email,
    'sphere' => $sphere ?: '—',
    'request' => $request ?: '—',
    'date' => date('d.m.Y H:i'),
]);

$subject = "Новая заявка в ШПП — $name";

$result = smtpSend(
    $config['smtp_host'],
    $config['smtp_port'],
    $config['email'],
    $config['password'],
    $config['email'],
    $config['email'],
    $subject,
    $html,
    'ШПП',
    $email
);

if ($result === true) {
    echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(500);
echo json_encode([
    'error' => 'Не удалось отправить письмо.',
    'detail' => $result,
], JSON_UNESCAPED_UNICODE);
