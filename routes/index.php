<?php

// ===== START SESSION (QUAN TRỌNG) =====
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';

// ===== AUTO ĐIỀU HƯỚNG =====
$action = $_GET['action'] ?? (isset($_SESSION['user']) ? 'home' : 'login');

$auth = new AuthController();
$home = new HomeController();

switch ($action) {

    // ===== AUTH =====
    case 'register':
        $auth->register();
        break;

    case 'handleRegister':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->handleRegister();
        }
        break;

    case 'login':
        $auth->login();
        break;

    case 'handleLogin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->handleLogin();
        }
        break;

    case 'logout':
        $auth->logout();
        break;

    // ===== USER =====
    case 'home':
    $home->index();
    break;

    // ===== ADMIN =====
    case 'dashboard':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=home");
            exit;
        }
        $home->dashboard();
        break;

    // ===== DEFAULT =====
    default:
        echo "404 Not Found";
        break;
}