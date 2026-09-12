<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';
$cfg = get_config();
$base_path = '';

$data = get_projects_data();
$key_achievements = $data['key_achievements'] ?? [];
$projects = $data['projects'] ?? [];

$page_title = 'Results | GroEdge — work led by Rajesh Pal';
$page_description = 'Selected results from Rajesh Pal: textile throughput and dispatch, paper finishing loss, retail supply chain, and operations due diligence. Anonymous clients. Numbers from the work.';
$current_page = 'projects';
include __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Results a plant can measure</h1>
            <p>Work led by Rajesh Pal. Clients are unnamed. Every number below is from the engagement, not a typical range.</p>
        </div>
    </section>

    <div class="container">
        <div class="section-content">
            <?php if (!empty($key_achievements)): ?>
            <div style="margin-bottom: 50px;">
                <h2>What changed</h2>
                <p style="margin-bottom: 25px;">Proof from completed work. A similar number on your line depends on the starting point — we will say so before we start.</p>
                <div class="stats-container">
                    <?php foreach ($key_achievements as $a): ?>
                    <div class="stat">
                        <h3><?php echo htmlspecialchars($a['label'] ?? ''); ?></h3>
                        <p><?php echo htmlspecialchars($a['description'] ?? ''); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div style="margin-bottom: 50px;">
                <h2>Engagements</h2>
                <p style="margin-bottom: 30px;">If your constraint looks like one of these — output, yield, dispatch, lead time, or a deal that needs an operating view — start with a conversation.</p>

                <?php if (empty($projects)): ?>
                <p style="color: #718096;">Case studies are being updated. Contact us for relevant references in your sector.</p>
                <?php else: ?>
                <div class="projects-list">
                    <?php foreach ($projects as $p): ?>
                    <article class="project-card">
                        <div class="project-meta">
                            <span class="project-industry"><?php echo htmlspecialchars($p['industry'] ?? ''); ?></span>
                            <?php if (!empty($p['year'])): ?><span class="project-year"><?php echo htmlspecialchars($p['year']); ?></span><?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($p['title'] ?? ''); ?></h3>
                        <?php if (!empty($p['client'])): ?>
                        <p class="project-client"><?php echo htmlspecialchars($p['client']); ?></p>
                        <?php endif; ?>
                        <p class="project-desc"><?php echo nl2br(htmlspecialchars($p['description'] ?? '')); ?></p>
                        <?php if (!empty($p['achievements']) && is_array($p['achievements'])): ?>
                        <ul class="project-achievements">
                            <?php foreach ($p['achievements'] as $ach): ?>
                            <li><?php echo htmlspecialchars($ach); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="cta-section">
                <h2 style="color: white; text-align: center;">Bring Rajesh the constraint that is costing you</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">One conversation. He will tell you whether this kind of work fits your plant — and what the first move should be.</p>
                <div style="text-align: center;">
                    <a href="contact.php" class="cta-button">Talk to Rajesh</a>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
