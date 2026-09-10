<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$cfg = get_config();
$base_path = '';

$data = get_industries_data();
$industries = $data['industries'] ?? [];
$slug = $_GET['slug'] ?? '';

$industry = null;
foreach ($industries as $ind) {
    if (($ind['slug'] ?? '') === $slug) {
        $industry = $ind;
        break;
    }
}

if ($industry === null) {
    $page_title = 'Industry Not Found | GroEdge';
    $page_description = 'The requested industry page could not be found.';
    $current_page = 'industries';
    include __DIR__ . '/includes/header.php';
    ?>
    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Industry not found</h1>
            <p>The industry you are looking for does not exist or may have been moved.</p>
        </div>
    </section>
    <div class="container">
        <div class="section-content" style="text-align: center; padding: 50px 30px;">
            <p style="margin-bottom: 25px; color: var(--muted);">Please check the URL or browse our available industries.</p>
            <a href="industries.php" class="cta-button">View all industries</a>
        </div>
    </div>
    <?php
    include __DIR__ . '/includes/footer.php';
    exit;
}

$page_title = htmlspecialchars($industry['name']) . ' Industry | GroEdge';
$page_description = htmlspecialchars($industry['tagline'] ?? '');
$current_page = 'industries';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="page-banner-inner">
        <span class="industry-banner-icon"><?php echo $industry['icon'] ?? ''; ?></span>
        <h1><?php echo htmlspecialchars($industry['name'] ?? ''); ?></h1>
        <p><?php echo htmlspecialchars($industry['tagline'] ?? ''); ?></p>
    </div>
</section>

<div class="container">
    <div class="section-content">

        <div class="industry-full-desc">
            <p><?php echo nl2br(htmlspecialchars($industry['description'] ?? '')); ?></p>
        </div>

        <?php if (!empty($industry['pain_points']) && is_array($industry['pain_points'])): ?>
        <section class="industry-pain-points">
            <h2>Common challenges in <?php echo htmlspecialchars($industry['name'] ?? ''); ?></h2>
            <div class="pain-points-grid">
                <?php foreach ($industry['pain_points'] as $pp): ?>
                <div class="pain-point-card">
                    <div class="pain-point-icon">&#9888;</div>
                    <p><?php echo htmlspecialchars($pp); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($industry['solutions']) && is_array($industry['solutions'])): ?>
        <section class="industry-solutions">
            <h2>How we help</h2>
            <ul class="solutions-list">
                <?php foreach ($industry['solutions'] as $sol): ?>
                <li><?php echo htmlspecialchars($sol); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <?php if (!empty($industry['stats']) && is_array($industry['stats'])): ?>
        <section class="industry-stats">
            <h2>Impact at a glance</h2>
            <div class="stats-container">
                <?php foreach ($industry['stats'] as $st): ?>
                <div class="stat">
                    <h3><?php echo htmlspecialchars($st['value'] ?? ''); ?></h3>
                    <p><?php echo htmlspecialchars($st['label'] ?? ''); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <div class="cta-section">
            <h2>Relevant services for <?php echo htmlspecialchars($industry['name'] ?? ''); ?></h2>
            <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Our consulting services are tailored to address the specific operational challenges of the <?php echo htmlspecialchars(strtolower($industry['name'] ?? '')); ?> sector.</p>
            <div style="text-align: center;">
                <a href="services.php" class="cta-button" style="margin-right: 15px;">Explore services</a>
                <a href="contact.php" class="cta-button" style="background: transparent; color: white; border: 2px solid white;">Book free assessment</a>
            </div>
        </div>
    </div>
</div>

<style>
.industry-banner-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 12px;
}
.industry-full-desc {
    margin-bottom: 40px;
}
.industry-full-desc p {
    color: #243447;
    line-height: 1.75;
    font-size: 1.08rem;
}
.industry-pain-points {
    margin-bottom: 40px;
}
.pain-points-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}
.pain-point-card {
    background: #fff8f0;
    border: 1px solid #f0dcc0;
    border-radius: 2px;
    padding: 24px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.pain-point-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
    line-height: 1;
}
.pain-point-card p {
    margin: 0;
    color: #243447;
    line-height: 1.6;
    font-size: 0.95rem;
}
.industry-solutions {
    margin-bottom: 40px;
}
.solutions-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 14px;
}
.solutions-list li {
    background: #eef6e3;
    border-left: 4px solid var(--accent);
    padding: 18px 20px;
    color: #243447;
    line-height: 1.6;
    font-size: 0.95rem;
}
.industry-stats {
    margin-bottom: 20px;
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
