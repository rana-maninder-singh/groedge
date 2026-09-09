<?php
require_once 'auth.php';
require_admin();

$data = get_services_data();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_services'])) {
    require_csrf();
    $data['page_title'] = trim($_POST['page_title'] ?? '');
    $data['page_intro'] = trim($_POST['page_intro'] ?? '');
    $data['intro_paragraph'] = trim($_POST['intro_paragraph'] ?? '');
    $data['cta_heading'] = trim($_POST['cta_heading'] ?? '');
    $data['cta_paragraph'] = trim($_POST['cta_paragraph'] ?? '');

    $pillar_titles = $_POST['pillar_title'] ?? [];
    $pillar_descs = $_POST['pillar_description'] ?? [];
    $data['pillars'] = [];
    $n = is_array($pillar_titles) ? count($pillar_titles) : 0;
    for ($i = 0; $i < $n; $i++) {
        $data['pillars'][] = [
            'title' => trim(is_array($pillar_titles) ? ($pillar_titles[$i] ?? '') : ''),
            'description' => trim(is_array($pillar_descs) ? ($pillar_descs[$i] ?? '') : '')
        ];
    }

    $step_nums = $_POST['step_number'] ?? [];
    $step_titles = $_POST['step_title'] ?? [];
    $step_descs = $_POST['step_description'] ?? [];
    $data['approach_steps'] = [];
    $n = is_array($step_titles) ? count($step_titles) : 0;
    for ($i = 0; $i < $n; $i++) {
        $data['approach_steps'][] = [
            'number' => (int)(is_array($step_nums) ? ($step_nums[$i] ?? $i + 1) : $i + 1),
            'title' => trim(is_array($step_titles) ? ($step_titles[$i] ?? '') : ''),
            'description' => trim(is_array($step_descs) ? ($step_descs[$i] ?? '') : '')
        ];
    }

    $ids = $_POST['service_id'] ?? [];
    $titles = $_POST['service_title'] ?? [];
    $short_descs = $_POST['service_short_desc'] ?? [];
    $descriptions = $_POST['service_description'] ?? [];
    $bulletsBlobs = $_POST['service_bullets'] ?? [];
    $data['services'] = [];
    $n = is_array($titles) ? count($titles) : 0;
    for ($i = 0; $i < $n; $i++) {
        $title = trim(is_array($titles) ? ($titles[$i] ?? '') : '');
        if ($title === '') continue;
        $id = trim(is_array($ids) ? ($ids[$i] ?? '') : '');
        if ($id === '') $id = 'service-' . preg_replace('/[^a-z0-9-]/', '-', strtolower(substr($title, 0, 30)));
        $bulletsText = is_array($bulletsBlobs) ? ($bulletsBlobs[$i] ?? '') : '';
        $bullets = array_values(array_filter(array_map('trim', explode("\n", $bulletsText))));
        $data['services'][] = [
            'id' => $id,
            'title' => $title,
            'short_desc' => trim(is_array($short_descs) ? ($short_descs[$i] ?? '') : ''),
            'description' => trim(is_array($descriptions) ? ($descriptions[$i] ?? '') : ''),
            'bullets' => $bullets
        ];
    }

    if (save_services_data($data)) {
        $message = 'Services page saved.';
    } else {
        $error = 'Could not save. Check that data/services.json is writable.';
    }
}

$pillars = $data['pillars'] ?? [];
$approach_steps = $data['approach_steps'] ?? [];
$services = $data['services'] ?? [];
while (count($pillars) < 4) { $pillars[] = ['title' => '', 'description' => '']; }
while (count($approach_steps) < 4) { $approach_steps[] = ['number' => count($approach_steps) + 1, 'title' => '', 'description' => '']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | GroEdge Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { padding: 20px; max-width: 720px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .admin-header h1 { color: #1a365d; font-size: 1.5rem; }
        .admin-nav a { margin-left: 12px; color: #2c5282; text-decoration: none; }
        .admin-nav a:hover { text-decoration: underline; }
        section { background: #fff; padding: 22px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 22px; }
        section h2 { color: #1a365d; font-size: 1.05rem; margin-bottom: 14px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748; font-size: 0.9rem; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; }
        .form-group textarea { min-height: 70px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        button[type=submit], .btn { background: #2c5282; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem; }
        button[type=submit]:hover, .btn:hover { background: #1a365d; }
        .btn-remove { background: #c53030; padding: 6px 12px; font-size: 0.85rem; }
        .btn-remove:hover { background: #9b2c2c; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 18px; }
        .err { color: #c53030; margin-bottom: 12px; }
        .svc-block { padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; margin-bottom: 14px; }
        .svc-block .form-group { margin-bottom: 10px; }
        #services-list { margin-bottom: 14px; }
        #service-template { display: none; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Services page</h1>
        <div class="admin-nav">
            <a href="dashboard.php">Submissions</a>
            <a href="settings.php">Site settings</a>
            <a href="projects.php">Projects</a>
            <a href="services.php">Services</a>
            <a href="logout.php">Log out</a>
            <a href="../services.php">View services page</a>
        </div>
    </div>

    <?php if ($message): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error): ?><p class="err"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <form method="post" action="">
        <?php echo csrf_field(); ?>
        <section>
            <h2>Page header</h2>
            <div class="form-group">
                <label>Page title (header)</label>
                <input type="text" name="page_title" value="<?php echo htmlspecialchars($data['page_title'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Page intro (subtitle under title)</label>
                <textarea name="page_intro" rows="2"><?php echo htmlspecialchars($data['page_intro'] ?? ''); ?></textarea>
            </div>
        </section>

        <section>
            <h2>Intro paragraph (below jump links)</h2>
            <div class="form-group">
                <textarea name="intro_paragraph" rows="4"><?php echo htmlspecialchars($data['intro_paragraph'] ?? ''); ?></textarea>
            </div>
        </section>

        <section>
            <h2>Our approach (4 pillars)</h2>
            <?php for ($i = 0; $i < 4; $i++): $p = $pillars[$i] ?? ['title' => '', 'description' => '']; ?>
            <div class="form-row">
                <div class="form-group">
                    <label>Pillar <?php echo $i + 1; ?> title</label>
                    <input type="text" name="pillar_title[]" value="<?php echo htmlspecialchars($p['title'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Pillar <?php echo $i + 1; ?> description</label>
                    <input type="text" name="pillar_description[]" value="<?php echo htmlspecialchars($p['description'] ?? ''); ?>">
                </div>
            </div>
            <?php endfor; ?>
        </section>

        <section>
            <h2>Engagement methodology (4 steps)</h2>
            <?php for ($i = 0; $i < 4; $i++): $s = $approach_steps[$i] ?? ['number' => $i + 1, 'title' => '', 'description' => '']; ?>
            <div class="form-group">
                <label>Step <?php echo $i + 1; ?> title</label>
                <input type="text" name="step_title[]" value="<?php echo htmlspecialchars($s['title'] ?? ''); ?>">
                <input type="hidden" name="step_number[]" value="<?php echo $i + 1; ?>">
            </div>
            <div class="form-group">
                <label>Step <?php echo $i + 1; ?> description</label>
                <input type="text" name="step_description[]" value="<?php echo htmlspecialchars($s['description'] ?? ''); ?>">
            </div>
            <?php endfor; ?>
        </section>

        <section>
            <h2>Services (order = display order)</h2>
            <p style="color:#718096; font-size:0.85rem; margin-bottom:12px;">Bullets: one per line. ID is used for anchor links (e.g. operational-process).</p>
            <div id="services-list">
                <?php foreach ($services as $svc): ?>
                <div class="svc-block">
                    <input type="hidden" name="service_id[]" value="<?php echo htmlspecialchars($svc['id'] ?? ''); ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="service_title[]" value="<?php echo htmlspecialchars($svc['title'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Short description (teaser)</label>
                        <input type="text" name="service_short_desc[]" value="<?php echo htmlspecialchars($svc['short_desc'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="service_description[]" rows="3"><?php echo htmlspecialchars($svc['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Bullets (one per line)</label>
                        <textarea name="service_bullets[]" rows="5"><?php echo htmlspecialchars(implode("\n", $svc['bullets'] ?? [])); ?></textarea>
                    </div>
                    <button type="button" class="btn btn-remove remove-svc">Remove service</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="service-template" class="svc-block" style="display:none;">
                <input type="hidden" name="service_id[]" value="" disabled>
                <div class="form-group"><label>Title</label><input type="text" name="service_title[]" disabled></div>
                <div class="form-group"><label>Short description (teaser)</label><input type="text" name="service_short_desc[]" disabled></div>
                <div class="form-group"><label>Description</label><textarea name="service_description[]" rows="3" disabled></textarea></div>
                <div class="form-group"><label>Bullets (one per line)</label><textarea name="service_bullets[]" rows="5" disabled></textarea></div>
                <button type="button" class="btn btn-remove remove-svc">Remove service</button>
            </div>
            <button type="button" id="add-service" class="btn">+ Add service</button>
        </section>

        <section>
            <h2>Bottom CTA</h2>
            <div class="form-group">
                <label>CTA heading</label>
                <input type="text" name="cta_heading" value="<?php echo htmlspecialchars($data['cta_heading'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>CTA paragraph</label>
                <textarea name="cta_paragraph" rows="2"><?php echo htmlspecialchars($data['cta_paragraph'] ?? ''); ?></textarea>
            </div>
        </section>

        <button type="submit" name="save_services" value="1" class="btn">Save all</button>
    </form>

    <script>
        document.getElementById('add-service').addEventListener('click', function() {
            var t = document.getElementById('service-template');
            var clone = t.cloneNode(true);
            clone.id = '';
            clone.style.display = 'block';
            clone.querySelectorAll('input, textarea').forEach(function(el) { el.disabled = false; });
            clone.querySelector('input[name="service_title[]"]').setAttribute('required', 'required');
            document.getElementById('services-list').appendChild(clone);
        });
        document.body.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-svc')) {
                e.target.closest('.svc-block').remove();
            }
        });
    </script>
</body>
</html>
