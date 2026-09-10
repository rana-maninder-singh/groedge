<?php
require_once 'auth.php';
require_admin();

$data = get_testimonials_data();
$testimonials = $data['testimonials'] ?? [];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['delete_testimonial']) && is_numeric($_POST['delete_testimonial'])) {
        $i = (int) $_POST['delete_testimonial'];
        if (isset($testimonials[$i])) {
            array_splice($testimonials, $i, 1);
            $data['testimonials'] = $testimonials;
            if (save_testimonials_data($data)) {
                header('Location: testimonials.php?msg=deleted');
                exit;
            }
        }
    }
    if (isset($_POST['save_testimonials'])) {
        $names = $_POST['t_name'] ?? [];
        $roles = $_POST['t_role'] ?? [];
        $companies = $_POST['t_company'] ?? [];
        $industries = $_POST['t_industry'] ?? [];
        $quotes = $_POST['t_quote'] ?? [];
        $ratings = $_POST['t_rating'] ?? [];
        $avatars = $_POST['t_avatar'] ?? [];
        $testimonials = [];
        $n = is_array($names) ? count($names) : 0;
        for ($i = 0; $i < $n; $i++) {
            $name = trim(is_array($names) ? ($names[$i] ?? '') : '');
            if ($name === '') continue;
            $quote = trim(is_array($quotes) ? ($quotes[$i] ?? '') : '');
            if ($quote === '') continue;
            $testimonials[] = [
                'name' => $name,
                'role' => trim(is_array($roles) ? ($roles[$i] ?? '') : ''),
                'company' => trim(is_array($companies) ? ($companies[$i] ?? '') : ''),
                'industry' => trim(is_array($industries) ? ($industries[$i] ?? '') : ''),
                'quote' => $quote,
                'rating' => (int) (is_array($ratings) ? ($ratings[$i] ?? 5) : 5),
                'avatar' => trim(is_array($avatars) ? ($avatars[$i] ?? '') : '')
            ];
        }
        $data['testimonials'] = $testimonials;
        if (save_testimonials_data($data)) {
            $message = 'Testimonials saved.';
        } else {
            $error = 'Could not save. Check that data/testimonials.json is writable.';
        }
    }
    $testimonials = $data['testimonials'] ?? [];
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = 'Testimonial removed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials | GroEdge Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { padding: 20px; max-width: 900px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .admin-header h1 { color: #1a365d; font-size: 1.5rem; }
        .admin-nav a { margin-left: 15px; color: #2c5282; text-decoration: none; }
        .admin-nav a:hover { text-decoration: underline; }
        section { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        section h2 { color: #1a365d; font-size: 1.1rem; margin-bottom: 18px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748; font-size: 0.9rem; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; box-sizing: border-box; }
        .form-group textarea { min-height: 80px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
        button[type=submit], .btn { background: #2c5282; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem; }
        button[type=submit]:hover, .btn:hover { background: #1a365d; }
        .btn-remove { background: #c53030; padding: 6px 12px; font-size: 0.85rem; }
        .btn-remove:hover { background: #9b2c2c; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .err { color: #c53030; margin-bottom: 15px; }
        .block { padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; margin-bottom: 14px; }
        .block .form-group { margin-bottom: 10px; }
        #items-list { margin-bottom: 14px; }
        #item-template { display: none; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Testimonials</h1>
        <div class="admin-nav">
            <a href="dashboard.php">Submissions</a>
            <a href="settings.php">Settings</a>
            <a href="services.php">Services</a>
            <a href="projects.php">Projects</a>
            <a href="testimonials.php">Testimonials</a>
            <a href="blog.php">Blog</a>
            <a href="industries.php">Industries</a>
            <a href="resources.php">Resources</a>
            <a href="../index.php">View site</a>
            <a href="logout.php">Log out</a>
        </div>
    </div>

    <?php if ($message): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error): ?><p class="err"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <section>
        <h2>Testimonials (displayed on the home page)</h2>
        <p style="color:#718096; font-size:0.9rem; margin-bottom:16px;">Each testimonial shows as a card. Rating is 1-5 stars. Avatar URL is optional.</p>
        <form method="post" action="">
            <?php echo csrf_field(); ?>
            <div id="items-list">
                <?php foreach ($testimonials as $i => $t): ?>
                <div class="block">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="t_name[]" value="<?php echo htmlspecialchars($t['name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" name="t_role[]" value="<?php echo htmlspecialchars($t['role'] ?? ''); ?>" placeholder="e.g. Plant Head">
                        </div>
                    </div>
                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="t_company[]" value="<?php echo htmlspecialchars($t['company'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Industry</label>
                            <input type="text" name="t_industry[]" value="<?php echo htmlspecialchars($t['industry'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <select name="t_rating[]">
                                <?php for ($r = 1; $r <= 5; $r++): ?>
                                <option value="<?php echo $r; ?>"<?php echo (($t['rating'] ?? 5) == $r) ? ' selected' : ''; ?>><?php echo $r; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Quote</label>
                        <textarea name="t_quote[]" rows="3" required><?php echo htmlspecialchars($t['quote'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Avatar URL (optional)</label>
                        <input type="text" name="t_avatar[]" value="<?php echo htmlspecialchars($t['avatar'] ?? ''); ?>" placeholder="https://...">
                    </div>
                    <button type="submit" name="delete_testimonial" value="<?php echo (int)$i; ?>" class="btn btn-remove" onclick="return confirm('Remove this testimonial?');">Remove</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="item-template" style="display:none;">
                <div class="block">
                    <div class="form-row">
                        <div class="form-group"><label>Name</label><input type="text" name="t_name[]"></div>
                        <div class="form-group"><label>Role</label><input type="text" name="t_role[]"></div>
                    </div>
                    <div class="form-row-3">
                        <div class="form-group"><label>Company</label><input type="text" name="t_company[]"></div>
                        <div class="form-group"><label>Industry</label><input type="text" name="t_industry[]"></div>
                        <div class="form-group"><label>Rating</label><select name="t_rating[]"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5" selected>5</option></select></div>
                    </div>
                    <div class="form-group"><label>Quote</label><textarea name="t_quote[]" rows="3"></textarea></div>
                    <div class="form-group"><label>Avatar URL</label><input type="text" name="t_avatar[]"></div>
                </div>
            </div>
            <button type="button" id="add-item" class="btn">+ Add testimonial</button>
            <button type="submit" name="save_testimonials" value="1" class="btn">Save all</button>
        </form>
    </section>

    <script>
        document.getElementById('add-item').addEventListener('click', function() {
            var t = document.getElementById('item-template');
            var clone = t.querySelector('.block').cloneNode(true);
            document.getElementById('items-list').appendChild(clone);
        });
    </script>
</body>
</html>
