<?php

header('Content-Type: application/json; charset=utf-8');
session_start();

if (!empty($_SESSION['username'])) {
    echo json_encode(['ok' => true, 'username' => $_SESSION['username']]);
    exit;
}

echo json_encode(['ok' => false]);
exit;

