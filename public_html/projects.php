<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';
$cfg = get_config();
$base_path = '';

$data = get_projects_data();
$key_achievements = $data['key_achievements'] ?? [];
$projects = $data['projects'] ?? [];

$page_title = 'Projects & Results | GroEdge';
$page_description = 'Selected GroEdge engagements: lead-time cuts, Lean throughput gains, DC redesign, and operational diligence—with outcomes leadership can verify.';
$current_page = 'projects';
include __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Work that shows up in the numbers</h1>
            <p>Selected engagements across manufacturing, healthcare equipment, distribution, and industrial integration.</p>
        </div>
    </section>

    <div class="container">
        <div class="section-content">
            <?php if (!empty($key_achievements)): ?>
            <div style="margin-bottom: 50px;">
                <h2>Impact at a glance</h2>
                <p style="margin-bottom: 25px;">Ranges from recent programmes. Your baseline and scope determine the outcome band.</p>
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
                <h2>Selected engagements</h2>
                <p style="margin-bottom: 30px;">Anonymous where required. Outcomes are what we were measured on.</p>

                <?php if (empty($projects)): ?>
                <p style="color: #718096;">Case studies are being updated. Contact us for relevant references in your sector.</p>
                <?php else: ?>
                <div class="projects-list">
                    <?php foreach ($projects as $p): ?>
                    <article class="project-card">
                        <div class="project-meta">
                            <span class="project-industry"><?php echo htmlspecialchars($p['industry'] ?? ''); ?></span>
                            <span class="project-year"><?php echo htmlspecialchars($p['year'] ?? ''); ?></span>
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
                <h2 style="color: white; text-align: center;">Want results like these in your operation?</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Tell us your constraint. We will say plainly whether a similar approach fits—and what a first 90 days could look like.</p>
                <div style="text-align: center;">
                    <a href="contact.php" class="cta-button">Book an assessment</a>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
