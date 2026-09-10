<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$cfg = get_config();
$base_path = '';

$data = get_blog_data();
$posts = $data['posts'] ?? [];
$slug = $_GET['slug'] ?? '';

$post = null;
foreach ($posts as $p) {
    if (($p['slug'] ?? '') === $slug) {
        $post = $p;
        break;
    }
}

if ($post === null) {
    $page_title = 'Article Not Found | GroEdge';
    $page_description = 'The requested article could not be found.';
    $current_page = 'blog';
    include __DIR__ . '/includes/header.php';
    ?>
    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Article not found</h1>
            <p>The article you are looking for does not exist or may have been moved.</p>
        </div>
    </section>
    <div class="container">
        <div class="section-content" style="text-align: center; padding: 50px 30px;">
            <p style="margin-bottom: 25px; color: var(--muted);">Please check the URL or browse our articles.</p>
            <a href="blog.php" class="cta-button">View all articles</a>
        </div>
    </div>
    <?php
    include __DIR__ . '/includes/footer.php';
    exit;
}

$related = [];
foreach ($posts as $p) {
    if (($p['slug'] ?? '') !== $slug) {
        $related[] = $p;
    }
}
$related = array_slice($related, 0, 2);

$article_url = 'https://groedge.in/article.php?slug=' . urlencode($slug);
$share_title = urlencode($post['title'] ?? '');
$share_text = urlencode($post['excerpt'] ?? '');

$page_title = htmlspecialchars($post['title'] ?? 'Article') . ' | GroEdge Blog';
$page_description = htmlspecialchars($post['excerpt'] ?? '');
$current_page = 'blog';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="page-banner-inner">
        <span class="article-category-badge"><?php echo htmlspecialchars($post['category'] ?? ''); ?></span>
        <h1><?php echo htmlspecialchars($post['title'] ?? ''); ?></h1>
        <div class="article-meta-banner">
            <?php if (!empty($post['author'])): ?>
            <span><?php echo htmlspecialchars($post['author']); ?></span>
            <?php endif; ?>
            <?php if (!empty($post['date'])): ?>
            <span><?php echo htmlspecialchars(date('F d, Y', strtotime($post['date']))); ?></span>
            <?php endif; ?>
            <?php if (!empty($post['read_time'])): ?>
            <span><?php echo htmlspecialchars($post['read_time']); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="container">
    <div class="section-content article-content">

        <?php if (!empty($post['image'])): ?>
        <div class="article-featured-img">
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? ''); ?>">
        </div>
        <?php endif; ?>

        <div class="article-share-top">
            <span class="share-label">Share this article:</span>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $article_url; ?>&title=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-btn share-linkedin">LinkedIn</a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo $article_url; ?>&text=<?php echo $share_text; ?>" target="_blank" rel="noopener" class="share-btn share-twitter">Twitter</a>
            <a href="https://wa.me/?text=<?php echo $share_title . '%20' . $article_url; ?>" target="_blank" rel="noopener" class="share-btn share-whatsapp">WhatsApp</a>
        </div>

        <div class="article-body">
            <?php echo nl2br(htmlspecialchars($post['content'] ?? '')); ?>
        </div>

        <div class="author-bio">
            <div class="author-bio-avatar">RP</div>
            <div class="author-bio-text">
                <h4>About the author</h4>
                <p class="author-bio-name">Rajesh Pal</p>
                <p>Principal consultant at GroEdge Management Consulting. Rajesh brings over 15 years of hands-on experience helping manufacturing, pharmaceutical, and supply chain organisations achieve measurable operational excellence across India.</p>
            </div>
        </div>

        <div class="article-share-bottom">
            <span class="share-label">Share this article:</span>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $article_url; ?>&title=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-btn share-linkedin">LinkedIn</a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo $article_url; ?>&text=<?php echo $share_text; ?>" target="_blank" rel="noopener" class="share-btn share-twitter">Twitter</a>
            <a href="https://wa.me/?text=<?php echo $share_title . '%20' . $article_url; ?>" target="_blank" rel="noopener" class="share-btn share-whatsapp">WhatsApp</a>
        </div>

        <?php if (!empty($related)): ?>
        <section class="related-articles">
            <h2>Related articles</h2>
            <div class="related-grid">
                <?php foreach ($related as $rp): ?>
                <a href="article.php?slug=<?php echo htmlspecialchars($rp['slug'] ?? ''); ?>" class="related-card">
                    <?php if (!empty($rp['image'])): ?>
                    <div class="related-card-img">
                        <img src="<?php echo htmlspecialchars($rp['image']); ?>" alt="<?php echo htmlspecialchars($rp['title'] ?? ''); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="related-card-body">
                        <?php if (!empty($rp['category'])): ?>
                        <span class="blog-card-badge"><?php echo htmlspecialchars($rp['category']); ?></span>
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($rp['title'] ?? ''); ?></h3>
                        <p class="blog-card-meta">
                            <?php if (!empty($rp['date'])): ?>
                            <span><?php echo htmlspecialchars(date('M d, Y', strtotime($rp['date']))); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($rp['read_time'])): ?>
                            <span>&middot; <?php echo htmlspecialchars($rp['read_time']); ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <div class="cta-section">
            <h2>Ready to improve your operations?</h2>
            <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Book a free 60-minute operational assessment. Identify your top constraints and walk away with a clear priority list.</p>
            <div style="text-align: center;">
                <a href="contact.php" class="cta-button">Book free assessment</a>
            </div>
        </div>
    </div>
</div>

<style>
.article-category-badge {
    display: inline-block;
    background: rgba(139, 197, 63, 0.25);
    color: #c4f09a;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 2px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 14px;
}
.article-meta-banner {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 0.95rem;
    opacity: 0.85;
    margin-top: 8px;
}
.article-meta-banner span {
    font-weight: 500;
}
.article-featured-img {
    margin-bottom: 32px;
    border-radius: 2px;
    overflow: hidden;
}
.article-featured-img img {
    width: 100%;
    height: auto;
    max-height: 420px;
    object-fit: cover;
    display: block;
}
.article-share-top,
.article-share-bottom {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.article-share-bottom {
    margin-top: 32px;
    margin-bottom: 0;
    padding-top: 24px;
    border-top: 1px solid var(--line);
}
.share-label {
    font-weight: 600;
    color: var(--ink-mid);
    font-size: 0.9rem;
}
.share-btn {
    display: inline-block;
    padding: 7px 14px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    border-radius: 2px;
    color: #fff;
}
.share-linkedin { background: #0077b5; }
.share-linkedin:hover { background: #005e93; }
.share-twitter { background: #1da1f2; }
.share-twitter:hover { background: #0d8bd9; }
.share-whatsapp { background: #25d366; }
.share-whatsapp:hover { background: #1ebe5d; }
.article-body {
    font-size: 1.08rem;
    line-height: 1.8;
    color: #243447;
    margin-bottom: 40px;
}
.article-body p {
    margin-bottom: 18px;
}
.author-bio {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    background: var(--paper);
    border: 1px solid var(--line);
    border-radius: 2px;
    padding: 28px;
    margin-bottom: 0;
}
.author-bio-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--ink);
    color: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1.4rem;
    font-weight: 700;
    flex-shrink: 0;
}
.author-bio-text h4 {
    margin: 0 0 4px 0;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--muted);
}
.author-bio-name {
    font-weight: 700;
    color: var(--ink);
    margin: 0 0 8px 0;
    font-size: 1.1rem;
}
.author-bio-text p:last-child {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}
.related-articles {
    margin-top: 40px;
    padding-top: 32px;
    border-top: 1px solid var(--line);
}
.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 20px;
}
.related-card {
    display: flex;
    flex-direction: column;
    border: 1px solid var(--line);
    border-radius: 2px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}
.related-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(11, 19, 32, 0.08);
}
.related-card-img {
    height: 160px;
    overflow: hidden;
}
.related-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.related-card-body {
    padding: 20px;
    flex: 1;
}
.related-card-body h3 {
    margin: 8px 0;
    font-size: 1.1rem;
    color: var(--ink);
    line-height: 1.3;
}
.related-card-body .blog-card-meta {
    margin: 0;
    font-size: 0.85rem;
    color: var(--muted);
}
@media (max-width: 600px) {
    .author-bio {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
