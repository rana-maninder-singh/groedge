<?php
require_once 'auth.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $password = $_POST['password'] ?? '';
    $cfg = get_config();
    $hash = $cfg->admin_password_hash ?? '';

    if (empty($hash)) {
        if (strlen($password) >= 8) {
            $cfg->admin_password_hash = password_hash($password, PASSWORD_DEFAULT);
            if (!save_config($cfg)) {
                $error = 'Could not save password. Check that data/site-config.json is writable.';
            } else {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                header('Location: dashboard.php');
                exit;
            }
        } else {
            $error = 'Set a password (at least 8 characters) for first-time setup.';
        }
    } else {
        if (password_verify($password, $hash)) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Invalid password.';
    }
}

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | GroEdge</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { padding: 40px 20px; max-width: 400px; margin: 0 auto; }
        .login-box { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        .login-box h1 { color: #1a365d; margin-bottom: 25px; font-size: 1.5rem; }
        .login-box input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #cbd5e0; border-radius: 6px; }
        .login-box button { width: 100%; padding: 14px; background: #2c5282; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .login-box button:hover { background: #1a365d; }
        .error { color: #c53030; font-size: 0.9rem; margin-bottom: 15px; }
        .back { display: inline-block; margin-top: 20px; color: #4a5568; text-decoration: none; font-size: 0.9rem; }
        .back:hover { color: #2c5282; }
        .warn { font-size:0.85rem; color:#c05621; margin-top:15px; background:#fffaf0; padding:10px; border-radius:6px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>GroEdge Admin</h1>
        <?php if ($error): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
        <form method="post" action="">
            <?php echo csrf_field(); ?>
            <input type="password" name="password" placeholder="Password" required autofocus<?php
                $cfgCheck = get_config();
                echo empty($cfgCheck->admin_password_hash) ? ' minlength="8" autocomplete="new-password"' : ' autocomplete="current-password"';
            ?>>
            <button type="submit">Log in</button>
        </form>
        <?php
        $cfg = get_config();
        if (empty($cfg->admin_password_hash)) {
            echo '<p class="warn">First-time setup: choose a strong password (min 8 characters) now. Until you do, anyone who reaches this page can claim admin access.</p>';
        }
        ?>
        <a href="../index.html" class="back">← Back to site</a>
    </div>
</body>
</html>
