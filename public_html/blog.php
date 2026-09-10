<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$cfg = get_config();
$base_path = '';

$data = get_blog_data();
$posts = $data['posts'] ?? [];

$page_title = 'Insights & Perspectives | GroEdge Blog';
$page_description = 'Read expert insights on operational excellence, Lean manufacturing, supply chain resilience, quality management, and digital transformation from GroEdge consulting.';
$current_page = 'blog';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="page-banner-inner">
        <h1>Insights &amp; perspectives</h1>
        <p>Practical thinking on operational excellence, supply chain resilience, and manufacturing performance from the GroEdge team.</p>
    </div>
</section>

<div class="container">
    <div class="section-content">
        <?php if (empty($posts)): ?>
        <p style="color: #718096; text-align: center;">Articles are being published soon. Check back shortly.</p>
        <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <article class="blog-card">
                <?php if (!empty($post['image'])): ?>
                <div class="blog-card-img">
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? ''); ?>">
                </div>
                <?php endif; ?>
                <div class="blog-card-body">
                    <?php if (!empty($post['category'])): ?>
                    <span class="blog-card-badge"><?php echo htmlspecialchars($post['category']); ?></span>
                    <?php endif; ?>
                    <h3><a href="article.php?slug=<?php echo htmlspecialchars($post['slug'] ?? ''); ?>"><?php echo htmlspecialchars($post['title'] ?? ''); ?></a></h3>
                    <p class="blog-card-excerpt"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></p>
                    <div class="blog-card-meta">
                        <?php if (!empty($post['author'])): ?>
                        <span class="blog-card-author"><?php echo htmlspecialchars($post['author']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post['date'])): ?>
                        <span class="blog-card-date"><?php echo htmlspecialchars(date('M d, Y', strtotime($post['date']))); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post['read_time'])): ?>
                        <span class="blog-card-readtime"><?php echo htmlspecialchars($post['read_time']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
}
.blog-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 2px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}
.blog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(11, 19, 32, 0.1);
}
.blog-card-img {
    height: 200px;
    overflow: hidden;
}
.blog-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.blog-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.blog-card-badge {
    display: inline-block;
    background: #eef6e3;
    color: var(--accent-deep);
    font-size: 0.8rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 2px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 12px;
    width: fit-content;
}
.blog-card h3 {
    margin: 0 0 10px 0;
    font-size: 1.25rem;
    line-height: 1.3;
}
.blog-card h3 a {
    color: var(--ink);
    text-decoration: none;
}
.blog-card h3 a:hover {
    color: var(--accent-deep);
}
.blog-card-excerpt {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 16px 0;
    flex: 1;
}
.blog-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 0.85rem;
    color: var(--muted);
    border-top: 1px solid var(--line);
    padding-top: 14px;
}
.blog-card-author {
    font-weight: 600;
    color: var(--ink-mid);
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
