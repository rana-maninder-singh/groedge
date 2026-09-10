<?php
require_once 'auth.php';
require_admin();

$data = get_blog_data();
$posts = $data['posts'] ?? [];
$message = '';
$error = '';

function generate_slug($title) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['delete_post']) && is_numeric($_POST['delete_post'])) {
        $i = (int) $_POST['delete_post'];
        if (isset($posts[$i])) {
            array_splice($posts, $i, 1);
            $data['posts'] = $posts;
            if (save_blog_data($data)) {
                header('Location: blog.php?msg=deleted');
                exit;
            }
        }
    }
    if (isset($_POST['save_posts'])) {
        $titles = $_POST['p_title'] ?? [];
        $slugs = $_POST['p_slug'] ?? [];
        $excerpts = $_POST['p_excerpt'] ?? [];
        $contents = $_POST['p_content'] ?? [];
        $authors = $_POST['p_author'] ?? [];
        $dates = $_POST['p_date'] ?? [];
        $categories = $_POST['p_category'] ?? [];
        $readTimes = $_POST['p_read_time'] ?? [];
        $images = $_POST['p_image'] ?? [];
        $posts = [];
        $n = is_array($titles) ? count($titles) : 0;
        for ($i = 0; $i < $n; $i++) {
            $title = trim(is_array($titles) ? ($titles[$i] ?? '') : '');
            if ($title === '') continue;
            $slug = trim(is_array($slugs) ? ($slugs[$i] ?? '') : '');
            if ($slug === '') $slug = generate_slug($title);
            $posts[] = [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => trim(is_array($excerpts) ? ($excerpts[$i] ?? '') : ''),
                'content' => trim(is_array($contents) ? ($contents[$i] ?? '') : ''),
                'author' => trim(is_array($authors) ? ($authors[$i] ?? '') : ''),
                'date' => trim(is_array($dates) ? ($dates[$i] ?? '') : date('Y-m-d')),
                'category' => trim(is_array($categories) ? ($categories[$i] ?? '') : ''),
                'read_time' => trim(is_array($readTimes) ? ($readTimes[$i] ?? '') : ''),
                'image' => trim(is_array($images) ? ($images[$i] ?? '') : '')
            ];
        }
        $data['posts'] = $posts;
        if (save_blog_data($data)) {
            $message = 'Blog posts saved.';
        } else {
            $error = 'Could not save. Check that data/blog.json is writable.';
        }
    }
    $posts = $data['posts'] ?? [];
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = 'Blog post removed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts | GroEdge Admin</title>
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
        .content-textarea { min-height: 200px; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Blog Posts</h1>
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
        <h2>Blog posts</h2>
        <p style="color:#718096; font-size:0.9rem; margin-bottom:16px;">Slug auto-generates from title if left blank. Content supports plain text or HTML.</p>
        <form method="post" action="">
            <?php echo csrf_field(); ?>
            <div id="items-list">
                <?php foreach ($posts as $i => $p): ?>
                <div class="block">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="p_title[]" value="<?php echo htmlspecialchars($p['title'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="p_slug[]" value="<?php echo htmlspecialchars($p['slug'] ?? ''); ?>" placeholder="auto-generated-from-title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Excerpt</label>
                        <textarea name="p_excerpt[]" rows="2"><?php echo htmlspecialchars($p['excerpt'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="p_content[]" rows="8" class="content-textarea"><?php echo htmlspecialchars($p['content'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="p_author[]" value="<?php echo htmlspecialchars($p['author'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="p_date[]" value="<?php echo htmlspecialchars($p['date'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Read Time</label>
                            <input type="text" name="p_read_time[]" value="<?php echo htmlspecialchars($p['read_time'] ?? ''); ?>" placeholder="e.g. 5 min read">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="p_category[]" value="<?php echo htmlspecialchars($p['category'] ?? ''); ?>" placeholder="e.g. Operations">
                        </div>
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="text" name="p_image[]" value="<?php echo htmlspecialchars($p['image'] ?? ''); ?>" placeholder="https://...">
                        </div>
                    </div>
                    <button type="submit" name="delete_post" value="<?php echo (int)$i; ?>" class="btn btn-remove" onclick="return confirm('Remove this post?');">Remove post</button>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="item-template" style="display:none;">
                <div class="block">
                    <div class="form-row">
                        <div class="form-group"><label>Title</label><input type="text" name="p_title[]"></div>
                        <div class="form-group"><label>Slug</label><input type="text" name="p_slug[]" placeholder="auto-generated-from-title"></div>
                    </div>
                    <div class="form-group"><label>Excerpt</label><textarea name="p_excerpt[]" rows="2"></textarea></div>
                    <div class="form-group"><label>Content</label><textarea name="p_content[]" rows="8" class="content-textarea"></textarea></div>
                    <div class="form-row-3">
                        <div class="form-group"><label>Author</label><input type="text" name="p_author[]"></div>
                        <div class="form-group"><label>Date</label><input type="date" name="p_date[]"></div>
                        <div class="form-group"><label>Read Time</label><input type="text" name="p_read_time[]"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Category</label><input type="text" name="p_category[]"></div>
                        <div class="form-group"><label>Image URL</label><input type="text" name="p_image[]"></div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-item" class="btn">+ Add post</button>
            <button type="submit" name="save_posts" value="1" class="btn">Save all</button>
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
