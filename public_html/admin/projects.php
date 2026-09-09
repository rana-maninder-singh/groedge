<?php
require_once 'auth.php';
require_admin();

$data = get_projects_data();
$key_achievements = $data['key_achievements'] ?? [];
$projects = $data['projects'] ?? [];

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_achievement']) && is_numeric($_POST['delete_achievement'])) {
        $i = (int) $_POST['delete_achievement'];
        if (isset($key_achievements[$i])) {
            array_splice($key_achievements, $i, 1);
            $data['key_achievements'] = $key_achievements;
            if (save_projects_data($data)) {
                header('Location: projects.php?msg=achievement_deleted');
                exit;
            }
        }
    }
    if (isset($_POST['delete_project']) && strlen(trim($_POST['delete_project'] ?? '')) > 0) {
        $id = trim($_POST['delete_project']);
        $data['projects'] = array_values(array_filter($projects, function ($p) use ($id) {
            return ($p['id'] ?? '') !== $id;
        }));
        if (save_projects_data($data)) {
            header('Location: projects.php?msg=project_deleted');
            exit;
        }
    }
    if (isset($_POST['save_achievements'])) {
        $labels = $_POST['ach_label'] ?? [];
        $descs = $_POST['ach_desc'] ?? [];
        $key_achievements = [];
        if (is_array($labels) && is_array($descs)) {
            $n = max(count($labels), count($descs));
            for ($i = 0; $i < $n; $i++) {
                $label = trim(is_array($labels) ? ($labels[$i] ?? '') : '');
                $desc = trim(is_array($descs) ? ($descs[$i] ?? '') : '');
                if ($label !== '' || $desc !== '') {
                    $key_achievements[] = ['label' => $label, 'description' => $desc];
                }
            }
        }
        $data['key_achievements'] = $key_achievements;
        if (save_projects_data($data)) {
            $message = 'Key achievements saved.';
        } else {
            $error = 'Could not save key achievements.';
        }
    }
    if (isset($_POST['save_projects'])) {
        $ids = $_POST['project_id'] ?? [];
        $titles = $_POST['project_title'] ?? [];
        $clients = $_POST['project_client'] ?? [];
        $industries = $_POST['project_industry'] ?? [];
        $years = $_POST['project_year'] ?? [];
        $descriptions = $_POST['project_description'] ?? [];
        $achievementsBlobs = $_POST['project_achievements'] ?? [];
        $projects = [];
        $n = is_array($titles) ? count($titles) : 0;
        for ($i = 0; $i < $n; $i++) {
            $title = trim(is_array($titles) ? ($titles[$i] ?? '') : '');
            if ($title === '') continue;
            $id = trim(is_array($ids) ? ($ids[$i] ?? '') : '');
            if ($id === '') $id = 'proj-' . uniqid();
            $achText = is_array($achievementsBlobs) ? ($achievementsBlobs[$i] ?? '') : '';
            $achList = array_filter(array_map('trim', explode("\n", $achText)));
            $projects[] = [
                'id' => $id,
                'title' => $title,
                'client' => trim(is_array($clients) ? ($clients[$i] ?? '') : ''),
                'industry' => trim(is_array($industries) ? ($industries[$i] ?? '') : ''),
                'year' => trim(is_array($years) ? ($years[$i] ?? '') : ''),
                'description' => trim(is_array($descriptions) ? ($descriptions[$i] ?? '') : ''),
                'achievements' => array_values($achList)
            ];
        }
        $data['projects'] = $projects;
        if (save_projects_data($data)) {
            $message = 'Projects saved.';
        } else {
            $error = 'Could not save projects.';
        }
    }
    $key_achievements = $data['key_achievements'] ?? [];
    $projects = $data['projects'] ?? [];
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'achievement_deleted') $message = 'Achievement removed.';
    if ($_GET['msg'] === 'project_deleted') $message = 'Project removed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects & Achievements | GroEdge Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { padding: 20px; max-width: 900px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .admin-header h1 { color: #1a365d; font-size: 1.5rem; }
        .admin-nav a { margin-left: 15px; color: #2c5282; text-decoration: none; }
        .admin-nav a:hover { text-decoration: underline; }
        section { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        section h2 { color: #1a365d; font-size: 1.1rem; margin-bottom: 18px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748; font-size: 0.9rem; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; }
        .form-group textarea { min-height: 80px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        button[type=submit], .btn { background: #2c5282; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem; }
        button[type=submit]:hover, .btn:hover { background: #1a365d; }
        .btn-remove { background: #c53030; padding: 6px 12px; font-size: 0.85rem; }
        .btn-remove:hover { background: #9b2c2c; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .err { color: #c53030; margin-bottom: 15px; }
        .ach-row, .proj-block { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; }
        .ach-row input, .proj-block .fields { flex: 1; min-width: 200px; }
        .proj-block { flex-direction: column; padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; }
        .proj-block .fields { display: contents; }
        .proj-block .form-group { margin-bottom: 12px; }
        #add-ach, #add-proj { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Projects & Achievements</h1>
        <div class="admin-nav">
            <a href="dashboard.php">Submissions</a>
            <a href="settings.php">Site settings</a>
            <a href="services.php">Services</a>
            <a href="projects.php">Projects</a>
            <a href="logout.php">Log out</a>
            <a href="../projects.php">View projects page</a>
        </div>
    </div>

    <?php if ($message): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error): ?><p class="err"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <section>
        <h2>Key achievements (stats on projects page)</h2>
        <p style="color:#718096; font-size:0.9rem; margin-bottom:16px;">These appear as the highlight stats at the top of the Projects page (e.g. "15+ Years Experience").</p>
        <form method="post" action="">
            <div id="achievements-list">
                <?php foreach ($key_achievements as $i => $a): ?>
                <div class="ach-row">
                    <input type="text" name="ach_label[]" value="<?php echo htmlspecialchars($a['label'] ?? ''); ?>" placeholder="Label (e.g. 15+)">
                    <input type="text" name="ach_desc[]" value="<?php echo htmlspecialchars($a['description'] ?? ''); ?>" placeholder="Description">
                    <button type="submit" name="delete_achievement" value="<?php echo (int)$i; ?>" class="btn btn-remove" onclick="return confirm('Remove this achievement?');">Remove</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="ach-template" style="display:none;">
                <div class="ach-row">
                    <input type="text" name="ach_label[]" placeholder="Label (e.g. 15+)">
                    <input type="text" name="ach_desc[]" placeholder="Description">
                </div>
            </div>
            <button type="button" id="add-ach" class="btn">+ Add achievement</button>
            <button type="submit" name="save_achievements" value="1" class="btn">Save achievements</button>
        </form>
    </section>

    <section>
        <h2>Projects</h2>
        <p style="color:#718096; font-size:0.9rem; margin-bottom:16px;">Each project is shown as a card on the Projects page. Achievements: one per line in the textarea.</p>
        <form method="post" action="">
            <div id="projects-list">
                <?php foreach ($projects as $i => $p): ?>
                <div class="proj-block">
                    <input type="hidden" name="project_id[]" value="<?php echo htmlspecialchars($p['id'] ?? ''); ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="project_title[]" value="<?php echo htmlspecialchars($p['title'] ?? ''); ?>" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Client</label>
                            <input type="text" name="project_client[]" value="<?php echo htmlspecialchars($p['client'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Industry</label>
                            <input type="text" name="project_industry[]" value="<?php echo htmlspecialchars($p['industry'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="project_year[]" value="<?php echo htmlspecialchars($p['year'] ?? ''); ?>" placeholder="e.g. 2024">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="project_description[]" rows="3"><?php echo htmlspecialchars($p['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Achievements (one per line)</label>
                        <textarea name="project_achievements[]" rows="4"><?php echo htmlspecialchars(implode("\n", $p['achievements'] ?? [])); ?></textarea>
                    </div>
                    <button type="submit" name="delete_project" value="<?php echo htmlspecialchars($p['id'] ?? ''); ?>" class="btn btn-remove" onclick="return confirm('Remove this project?');">Remove project</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="proj-template" style="display:none;">
                <div class="proj-block">
                    <input type="hidden" name="project_id[]" value="">
                    <div class="form-group"><label>Title</label><input type="text" name="project_title[]" required></div>
                    <div class="form-row">
                        <div class="form-group"><label>Client</label><input type="text" name="project_client[]"></div>
                        <div class="form-group"><label>Industry</label><input type="text" name="project_industry[]"></div>
                    </div>
                    <div class="form-group"><label>Year</label><input type="text" name="project_year[]" placeholder="e.g. 2024"></div>
                    <div class="form-group"><label>Description</label><textarea name="project_description[]" rows="3"></textarea></div>
                    <div class="form-group"><label>Achievements (one per line)</label><textarea name="project_achievements[]" rows="4"></textarea></div>
                </div>
            </div>
            <button type="button" id="add-proj" class="btn">+ Add project</button>
            <button type="submit" name="save_projects" value="1" class="btn">Save projects</button>
        </form>
    </section>

    <script>
        document.getElementById('add-ach').addEventListener('click', function() {
            var t = document.getElementById('ach-template');
            var clone = t.querySelector('.ach-row').cloneNode(true);
            document.getElementById('achievements-list').appendChild(clone);
        });
        document.getElementById('add-proj').addEventListener('click', function() {
            var t = document.getElementById('proj-template');
            var clone = t.querySelector('.proj-block').cloneNode(true);
            document.getElementById('projects-list').appendChild(clone);
        });
    </script>
</body>
</html>
