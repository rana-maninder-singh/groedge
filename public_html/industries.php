<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$cfg = get_config();
$base_path = '';

$data = get_industries_data();
$industries = $data['industries'] ?? [];

$page_title = 'Industries | Textiles, Paper, Manufacturing | GroEdge';
$page_description = 'GroEdge, led by Rajesh Pal, has delivered operational work in textiles, paper, organised retail supply chain, and industrial equipment across India.';
$current_page = 'industries';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="page-banner-inner">
        <h1>Industries we serve</h1>
        <p>Operational excellence is industry-agnostic but sector-aware. We bring deep domain knowledge to every engagement.</p>
    </div>
</section>

<div class="container">
    <div class="section-content">
        <div class="industries-grid">
            <?php if (empty($industries)): ?>
            <p style="color: #718096; text-align: center;">Industry information is being updated. Contact us to discuss your sector.</p>
            <?php else: ?>
            <?php foreach ($industries as $ind): ?>
            <a href="industry.php?slug=<?php echo htmlspecialchars($ind['slug'] ?? ''); ?>" class="industry-card">
                <div class="industry-card-icon"><?php echo $ind['icon'] ?? ''; ?></div>
                <h3><?php echo htmlspecialchars($ind['name'] ?? ''); ?></h3>
                <p class="industry-card-tagline"><?php echo htmlspecialchars($ind['tagline'] ?? ''); ?></p>
                <p class="industry-card-desc"><?php echo htmlspecialchars(mb_strimwidth($ind['description'] ?? '', 0, 150, '...')); ?></p>
                <span class="industry-card-link">Explore this industry &rarr;</span>
            </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="cta-section">
            <h2>Your industry has unique challenges. We speak the language.</h2>
            <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Every sector has specific constraints, regulations, and operational realities. Book a free assessment to discuss your industry-specific challenges.</p>
            <div style="text-align: center;">
                <a href="contact.php" class="cta-button">Book free assessment</a>
            </div>
        </div>
    </div>
</div>

<style>
.industries-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    margin-bottom: 20px;
}
.industry-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 2px;
    padding: 32px 28px;
    text-decoration: none;
    color: inherit;
    border-top: 3px solid var(--accent);
    transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}
.industry-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(11, 19, 32, 0.1);
}
.industry-card-icon {
    font-size: 2.4rem;
    margin-bottom: 16px;
}
.industry-card h3 {
    color: var(--ink);
    font-size: 1.4rem;
    margin: 0 0 8px 0;
    font-weight: 600;
}
.industry-card-tagline {
    color: var(--accent-deep);
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0 0 12px 0;
    line-height: 1.4;
}
.industry-card-desc {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 16px 0;
    flex: 1;
}
.industry-card-link {
    color: var(--accent-deep);
    font-weight: 700;
    font-size: 0.95rem;
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
