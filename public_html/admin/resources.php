<?php
require_once 'auth.php';
require_admin();

$data = get_resources_data();
$resources = $data['resources'] ?? [];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['delete_resource']) && is_numeric($_POST['delete_resource'])) {
        $i = (int) $_POST['delete_resource'];
        if (isset($resources[$i])) {
            array_splice($resources, $i, 1);
            $data['resources'] = $resources;
            if (save_resources_data($data)) {
                header('Location: resources.php?msg=deleted');
                exit;
            }
        }
    }
    if (isset($_POST['save_resources'])) {
        $titles = $_POST['r_title'] ?? [];
        $types = $_POST['r_type'] ?? [];
        $descs = $_POST['r_description'] ?? [];
        $urls = $_POST['r_url'] ?? [];
        $icons = $_POST['r_icon'] ?? [];
        $resources = [];
        $n = is_array($titles) ? count($titles) : 0;
        for ($i = 0; $i < $n; $i++) {
            $title = trim(is_array($titles) ? ($titles[$i] ?? '') : '');
            if ($title === '') continue;
            $resources[] = [
                'title' => $title,
                'type' => trim(is_array($types) ? ($types[$i] ?? '') : 'guide'),
                'description' => trim(is_array($descs) ? ($descs[$i] ?? '') : ''),
                'download_url' => trim(is_array($urls) ? ($urls[$i] ?? '') : ''),
                'icon' => trim(is_array($icons) ? ($icons[$i] ?? '') : '')
            ];
        }
        $data['resources'] = $resources;
        if (save_resources_data($data)) {
            $message = 'Resources saved.';
        } else {
            $error = 'Could not save. Check that data/resources.json is writable.';
        }
    }
    $resources = $data['resources'] ?? [];
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = 'Resource removed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources | GroEdge Admin</title>
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
        .form-group textarea { min-height: 60px; resize: vertical; }
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
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Resources</h1>
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
        <h2>Downloadable resources</h2>
        <p style="color:#718096; font-size:0.9rem; margin-bottom:16px;">Checklists, templates, guides, and calculators offered on the site.</p>
        <form method="post" action="">
            <?php echo csrf_field(); ?>
            <div id="items-list">
                <?php foreach ($resources as $i => $r): ?>
                <div class="block">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="r_title[]" value="<?php echo htmlspecialchars($r['title'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select name="r_type[]">
                                <?php
                                $types = ['checklist' => 'Checklist', 'template' => 'Template', 'guide' => 'Guide', 'calculator' => 'Calculator'];
                                $currentType = $r['type'] ?? 'guide';
                                foreach ($types as $val => $label):
                                ?>
                                <option value="<?php echo $val; ?>"<?php echo $currentType === $val ? ' selected' : ''; ?>><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="r_description[]" rows="2"><?php echo htmlspecialchars($r['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Download URL</label>
                            <input type="text" name="r_url[]" value="<?php echo htmlspecialchars($r['download_url'] ?? ''); ?>" placeholder="https://...">
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input type="text" name="r_icon[]" value="<?php echo htmlspecialchars($r['icon'] ?? ''); ?>" placeholder="📋">
                        </div>
                    </div>
                    <button type="submit" name="delete_resource" value="<?php echo (int)$i; ?>" class="btn btn-remove" onclick="return confirm('Remove this resource?');">Remove resource</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="item-template" style="display:none;">
                <div class="block">
                    <div class="form-row">
                        <div class="form-group"><label>Title</label><input type="text" name="r_title[]"></div>
                        <div class="form-group"><label>Type</label><select name="r_type[]"><option value="checklist">Checklist</option><option value="template">Template</option><option value="guide" selected>Guide</option><option value="calculator">Calculator</option></select></div>
                    </div>
                    <div class="form-group"><label>Description</label><textarea name="r_description[]" rows="2"></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>Download URL</label><input type="text" name="r_url[]"></div>
                        <div class="form-group"><label>Icon</label><input type="text" name="r_icon[]"></div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-item" class="btn">+ Add resource</button>
            <button type="submit" name="save_resources" value="1" class="btn">Save all</button>
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
