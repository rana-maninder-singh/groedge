<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('DATA_DIR', dirname(__DIR__) . '/data');
require_once dirname(__DIR__) . '/includes/config.php';

function require_admin() {
    if (empty($_SESSION['admin_logged_in'])) {
        header('Location: index.php');
        exit;
    }
}
