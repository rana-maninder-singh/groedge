<?php
require_once 'auth.php';
require_admin();

$data = get_industries_data();
$industries = $data['industries'] ?? [];
$message = '';
$error = '';

function make_slug($title) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['delete_industry']) && is_numeric($_POST['delete_industry'])) {
        $i = (int) $_POST['delete_industry'];
        if (isset($industries[$i])) {
            array_splice($industries, $i, 1);
            $data['industries'] = $industries;
            if (save_industries_data($data)) {
                header('Location: industries.php?msg=deleted');
                exit;
            }
        }
    }
    if (isset($_POST['save_industries'])) {
        $names = $_POST['ind_name'] ?? [];
        $slugs = $_POST['ind_slug'] ?? [];
        $icons = $_POST['ind_icon'] ?? [];
        $taglines = $_POST['ind_tagline'] ?? [];
        $descriptions = $_POST['ind_description'] ?? [];
        $painPoints = $_POST['ind_pain_points'] ?? [];
        $solutions = $_POST['ind_solutions'] ?? [];
        $statLabels1 = $_POST['ind_stat_label1'] ?? [];
        $statValues1 = $_POST['ind_stat_value1'] ?? [];
        $statLabels2 = $_POST['ind_stat_label2'] ?? [];
        $statValues2 = $_POST['ind_stat_value2'] ?? [];
        $statLabels3 = $_POST['ind_stat_label3'] ?? [];
        $statValues3 = $_POST['ind_stat_value3'] ?? [];
        $images = $_POST['ind_image'] ?? [];
        $industries = [];
        $n = is_array($names) ? count($names) : 0;
        for ($i = 0; $i < $n; $i++) {
            $name = trim(is_array($names) ? ($names[$i] ?? '') : '');
            if ($name === '') continue;
            $slug = trim(is_array($slugs) ? ($slugs[$i] ?? '') : '');
            if ($slug === '') $slug = make_slug($name);
            $ppText = is_array($painPoints) ? ($painPoints[$i] ?? '') : '';
            $solText = is_array($solutions) ? ($solutions[$i] ?? '') : '';
            $industries[] = [
                'name' => $name,
                'slug' => $slug,
                'icon' => trim(is_array($icons) ? ($icons[$i] ?? '') : ''),
                'tagline' => trim(is_array($taglines) ? ($taglines[$i] ?? '') : ''),
                'description' => trim(is_array($descriptions) ? ($descriptions[$i] ?? '') : ''),
                'pain_points' => array_values(array_filter(array_map('trim', explode("\n", $ppText)))),
                'solutions' => array_values(array_filter(array_map('trim', explode("\n", $solText)))),
                'stats' => [
                    ['label' => trim(is_array($statLabels1) ? ($statLabels1[$i] ?? '') : ''), 'value' => trim(is_array($statValues1) ? ($statValues1[$i] ?? '') : '')],
                    ['label' => trim(is_array($statLabels2) ? ($statLabels2[$i] ?? '') : ''), 'value' => trim(is_array($statValues2) ? ($statValues2[$i] ?? '') : '')],
                    ['label' => trim(is_array($statLabels3) ? ($statLabels3[$i] ?? '') : ''), 'value' => trim(is_array($statValues3) ? ($statValues3[$i] ?? '') : '')]
                ],
                'image' => trim(is_array($images) ? ($images[$i] ?? '') : '')
            ];
        }
        $data['industries'] = $industries;
        if (save_industries_data($data)) {
            $message = 'Industries saved.';
        } else {
            $error = 'Could not save. Check that data/industries.json is writable.';
        }
    }
    $industries = $data['industries'] ?? [];
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = 'Industry removed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industries | GroEdge Admin</title>
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
        .form-group input, .form-group textarea { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; box-sizing: border-box; }
        .form-group textarea { min-height: 80px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
        .stat-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        button[type=submit], .btn { background: #2c5282; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem; }
        button[type=submit]:hover, .btn:hover { background: #1a365d; }
        .btn-remove { background: #c53030; padding: 6px 12px; font-size: 0.85rem; }
        .btn-remove:hover { background: #9b2c2c; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .err { color: #c53030; margin-bottom: 15px; }
        .block { padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; margin-bottom: 14px; }
        .block .form-group { margin-bottom: 10px; }
        #items-list { margin-bottom: 14px; }
        .stats-label { font-size: 0.8rem; color: #718096; font-weight: 500; margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Industries</h1>
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
        <h2>Industry pages</h2>
        <p style="color:#718096; font-size:0.9rem; margin-bottom:16px;">Pain Points and Solutions: one item per line. Icon is an emoji. Slug auto-generates from name.</p>
        <form method="post" action="">
            <?php echo csrf_field(); ?>
            <div id="items-list">
                <?php foreach ($industries as $i => $ind): ?>
                <div class="block">
                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="ind_name[]" value="<?php echo htmlspecialchars($ind['name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="ind_slug[]" value="<?php echo htmlspecialchars($ind['slug'] ?? ''); ?>" placeholder="auto-generated">
                        </div>
                        <div class="form-group">
                            <label>Icon (emoji)</label>
                            <input type="text" name="ind_icon[]" value="<?php echo htmlspecialchars($ind['icon'] ?? ''); ?>" placeholder="🏭">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tagline</label>
                        <input type="text" name="ind_tagline[]" value="<?php echo htmlspecialchars($ind['tagline'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="ind_description[]" rows="3"><?php echo htmlspecialchars($ind['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Pain Points (one per line)</label>
                            <textarea name="ind_pain_points[]" rows="4"><?php echo htmlspecialchars(implode("\n", $ind['pain_points'] ?? [])); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Solutions (one per line)</label>
                            <textarea name="ind_solutions[]" rows="4"><?php echo htmlspecialchars(implode("\n", $ind['solutions'] ?? [])); ?></textarea>
                        </div>
                    </div>
                    <div class="stats-label">Stats (3 pairs)</div>
                    <div class="form-row-3" style="margin-bottom: 10px;">
                        <div class="stat-row">
                            <div class="form-group"><label>Stat 1 Label</label><input type="text" name="ind_stat_label1[]" value="<?php echo htmlspecialchars(($ind['stats'][0]['label'] ?? '') ?? ''); ?>"></div>
                            <div class="form-group"><label>Stat 1 Value</label><input type="text" name="ind_stat_value1[]" value="<?php echo htmlspecialchars(($ind['stats'][0]['value'] ?? '') ?? ''); ?>"></div>
                        </div>
                        <div class="stat-row">
                            <div class="form-group"><label>Stat 2 Label</label><input type="text" name="ind_stat_label2[]" value="<?php echo htmlspecialchars(($ind['stats'][1]['label'] ?? '') ?? ''); ?>"></div>
                            <div class="form-group"><label>Stat 2 Value</label><input type="text" name="ind_stat_value2[]" value="<?php echo htmlspecialchars(($ind['stats'][1]['value'] ?? '') ?? ''); ?>"></div>
                        </div>
                        <div class="stat-row">
                            <div class="form-group"><label>Stat 3 Label</label><input type="text" name="ind_stat_label3[]" value="<?php echo htmlspecialchars(($ind['stats'][2]['label'] ?? '') ?? ''); ?>"></div>
                            <div class="form-group"><label>Stat 3 Value</label><input type="text" name="ind_stat_value3[]" value="<?php echo htmlspecialchars(($ind['stats'][2]['value'] ?? '') ?? ''); ?>"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" name="ind_image[]" value="<?php echo htmlspecialchars($ind['image'] ?? ''); ?>" placeholder="https://...">
                    </div>
                    <button type="submit" name="delete_industry" value="<?php echo (int)$i; ?>" class="btn btn-remove" onclick="return confirm('Remove this industry?');">Remove industry</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="item-template" style="display:none;">
                <div class="block">
                    <div class="form-row-3">
                        <div class="form-group"><label>Name</label><input type="text" name="ind_name[]"></div>
                        <div class="form-group"><label>Slug</label><input type="text" name="ind_slug[]"></div>
                        <div class="form-group"><label>Icon</label><input type="text" name="ind_icon[]"></div>
                    </div>
                    <div class="form-group"><label>Tagline</label><input type="text" name="ind_tagline[]"></div>
                    <div class="form-group"><label>Description</label><textarea name="ind_description[]" rows="3"></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>Pain Points</label><textarea name="ind_pain_points[]" rows="4"></textarea></div>
                        <div class="form-group"><label>Solutions</label><textarea name="ind_solutions[]" rows="4"></textarea></div>
                    </div>
                    <div class="form-row-3">
                        <div class="stat-row">
                            <div class="form-group"><label>Stat 1 Label</label><input type="text" name="ind_stat_label1[]"></div>
                            <div class="form-group"><label>Stat 1 Value</label><input type="text" name="ind_stat_value1[]"></div>
                        </div>
                        <div class="stat-row">
                            <div class="form-group"><label>Stat 2 Label</label><input type="text" name="ind_stat_label2[]"></div>
                            <div class="form-group"><label>Stat 2 Value</label><input type="text" name="ind_stat_value2[]"></div>
                        </div>
                        <div class="stat-row">
                            <div class="form-group"><label>Stat 3 Label</label><input type="text" name="ind_stat_label3[]"></div>
                            <div class="form-group"><label>Stat 3 Value</label><input type="text" name="ind_stat_value3[]"></div>
                        </div>
                    </div>
                    <div class="form-group"><label>Image URL</label><input type="text" name="ind_image[]"></div>
                </div>
            </div>
            <button type="button" id="add-item" class="btn">+ Add industry</button>
            <button type="submit" name="save_industries" value="1" class="btn">Save all</button>
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
