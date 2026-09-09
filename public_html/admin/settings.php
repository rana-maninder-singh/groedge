<?php
require_once 'auth.php';
require_admin();
$cfg = get_config();
$addr = $cfg->address ?? (object)['company' => '', 'line1' => '', 'line2' => '', 'country' => ''];
$saved = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $cfg->contact_person = trim($_POST['contact_person'] ?? '');
    $cfg->contact_phone = trim($_POST['contact_phone'] ?? '');
    $cfg->contact_phone_raw = preg_replace('/\D/', '', $cfg->contact_phone);
    $cfg->email_contact = trim($_POST['email_contact'] ?? '');
    $cfg->email_info = trim($_POST['email_info'] ?? '');
    $cfg->email_sales = trim($_POST['email_sales'] ?? '');
    $cfg->business_hours = trim($_POST['business_hours'] ?? '');
    $cfg->form_to_email = trim($_POST['form_to_email'] ?? $cfg->email_info);
    $cfg->form_bcc = trim($_POST['form_bcc'] ?? '');
    $cfg->address = (object)[
        'company' => trim($_POST['addr_company'] ?? ''),
        'line1' => trim($_POST['addr_line1'] ?? ''),
        'line2' => trim($_POST['addr_line2'] ?? ''),
        'country' => trim($_POST['addr_country'] ?? '')
    ];

    if (isset($_POST['new_password']) && strlen($_POST['new_password']) >= 8) {
        $cfg->admin_password_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    }

    if (save_config($cfg)) {
        $saved = true;
    } else {
        $error = 'Could not save. Check that data/site-config.json is writable.';
    }
    $addr = $cfg->address;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings | GroEdge Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { padding: 20px; max-width: 600px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .admin-header h1 { color: #1a365d; font-size: 1.5rem; }
        .admin-nav a { margin-left: 15px; color: #2c5282; text-decoration: none; }
        .admin-nav a:hover { text-decoration: underline; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 500; margin-bottom: 6px; color: #2d3748; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; }
        .form-group input:focus { outline: none; border-color: #2c5282; }
        section { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        section h2 { color: #1a365d; font-size: 1.1rem; margin-bottom: 18px; }
        button[type=submit] { background: #2c5282; color: #fff; padding: 12px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        button[type=submit]:hover { background: #1a365d; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .err { color: #c53030; margin-bottom: 15px; }
        .hint { font-size: 0.85rem; color: #718096; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Site Settings</h1>
        <div class="admin-nav">
            <a href="dashboard.php">Submissions</a>
            <a href="services.php">Services</a>
            <a href="projects.php">Projects</a>
            <a href="logout.php">Log out</a>
            <a href="../contact.php">View contact page</a>
        </div>
    </div>

    <?php if ($saved): ?><p class="success">Settings saved.</p><?php endif; ?>
    <?php if ($error): ?><p class="err"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <form method="post" action="">
        <?php echo csrf_field(); ?>
        <section>
            <h2>Contact information (shown on contact page)</h2>
            <div class="form-group">
                <label>Contact person</label>
                <input type="text" name="contact_person" value="<?php echo htmlspecialchars($cfg->contact_person ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="contact_phone" value="<?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?>">
                <p class="hint">Displayed as-is. Use contact_phone_raw in config for tel: link (digits only) if needed.</p>
            </div>
            <div class="form-group">
                <label>Email (contact person)</label>
                <input type="email" name="email_contact" value="<?php echo htmlspecialchars($cfg->email_contact ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Email (general inquiries)</label>
                <input type="email" name="email_info" value="<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Email (sales)</label>
                <input type="email" name="email_sales" value="<?php echo htmlspecialchars($cfg->email_sales ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Business hours</label>
                <input type="text" name="business_hours" value="<?php echo htmlspecialchars($cfg->business_hours ?? ''); ?>" placeholder="e.g. Mon-Fri: 9:00 AM - 6:00 PM IST">
            </div>
        </section>

        <section>
            <h2>Form submission emails</h2>
            <div class="form-group">
                <label>Send form submissions to (To)</label>
                <input type="email" name="form_to_email" value="<?php echo htmlspecialchars($cfg->form_to_email ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>BCC (comma-separated)</label>
                <input type="text" name="form_bcc" value="<?php echo htmlspecialchars($cfg->form_bcc ?? ''); ?>" placeholder="email1@groedge.in, email2@groedge.in">
            </div>
        </section>

        <section>
            <h2>Office address</h2>
            <div class="form-group">
                <label>Company name</label>
                <input type="text" name="addr_company" value="<?php echo htmlspecialchars($addr->company ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Address line 1</label>
                <input type="text" name="addr_line1" value="<?php echo htmlspecialchars($addr->line1 ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Address line 2 (city, state, postal)</label>
                <input type="text" name="addr_line2" value="<?php echo htmlspecialchars($addr->line2 ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="addr_country" value="<?php echo htmlspecialchars($addr->country ?? ''); ?>">
            </div>
        </section>

        <section>
            <h2>Change admin password</h2>
            <div class="form-group">
                <label>New password (leave blank to keep current)</label>
                <input type="password" name="new_password" placeholder="Min 8 characters" minlength="8" autocomplete="new-password">
            </div>
        </section>

        <button type="submit">Save settings</button>
    </form>
</body>
</html>
