<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$cfg = get_config();
$base_path = '';

$data = get_resources_data();
$resources = $data['resources'] ?? [];

$page_title = 'Resources & Downloads | GroEdge';
$page_description = 'Free operational excellence resources for Indian manufacturers: assessments, scorecards, benchmarking tools, and compliance guides from GroEdge consulting.';
$current_page = 'resources';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="page-banner-inner">
        <h1>Resources &amp; downloads</h1>
        <p>Practical tools and guides to help you assess, benchmark, and improve your operational performance.</p>
    </div>
</section>

<div class="container">
    <div class="section-content">
        <?php if (empty($resources)): ?>
        <p style="color: #718096; text-align: center;">Resources are being prepared. Check back shortly.</p>
        <?php else: ?>
        <div class="resources-grid">
            <?php foreach ($resources as $res): ?>
            <div class="resource-card">
                <div class="resource-card-icon"><?php echo $res['icon'] ?? ''; ?></div>
                <span class="resource-card-type"><?php echo htmlspecialchars(ucfirst($res['type'] ?? 'resource')); ?></span>
                <h3><?php echo htmlspecialchars($res['title'] ?? ''); ?></h3>
                <p class="resource-card-desc"><?php echo htmlspecialchars($res['description'] ?? ''); ?></p>
                <?php
                $dlUrl = trim($res['download_url'] ?? '');
                $resTitle = $res['title'] ?? '';
                if ($dlUrl !== '' && $dlUrl !== '#'):
                ?>
                <a href="<?php echo htmlspecialchars($dlUrl); ?>" class="resource-card-btn" target="_blank" rel="noopener">Try tool &rarr;</a>
                <?php else: ?>
                <a href="contact.php?subject=<?php echo urlencode('Request: ' . $resTitle); ?>" class="resource-card-btn">Request this resource &rarr;</a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="cta-section">
            <h2>Need a custom resource?</h2>
            <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">We can develop tailored assessment tools, benchmarking frameworks, and compliance guides specific to your industry and operational context.</p>
            <div style="text-align: center;">
                <a href="contact.php" class="cta-button">Request custom resource</a>
            </div>
        </div>
    </div>
</div>

<style>
.resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 20px;
}
.resource-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 2px;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    border-top: 3px solid var(--accent);
    transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}
.resource-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(11, 19, 32, 0.1);
}
.resource-card-icon {
    font-size: 2rem;
    margin-bottom: 12px;
}
.resource-card-type {
    display: inline-block;
    background: #eef6e3;
    color: var(--accent-deep);
    font-size: 0.78rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 2px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 12px;
    width: fit-content;
}
.resource-card h3 {
    color: var(--ink);
    font-size: 1.2rem;
    margin: 0 0 10px 0;
    font-weight: 600;
}
.resource-card-desc {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 20px 0;
    flex: 1;
}
.resource-card-btn {
    display: inline-block;
    background: var(--ink);
    color: var(--white);
    padding: 10px 22px;
    text-decoration: none;
    border-radius: 2px;
    font-weight: 700;
    font-size: 0.9rem;
    transition: background 0.3s var(--ease);
    width: fit-content;
}
.resource-card-btn:hover {
    background: var(--accent-deep);
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
