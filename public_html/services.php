<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$data = get_services_data();
$page_title = $data['page_title'] ?? 'Our Services';
$page_intro = $data['page_intro'] ?? '';
$intro_paragraph = $data['intro_paragraph'] ?? '';
$pillars = $data['pillars'] ?? [];
$approach_steps = $data['approach_steps'] ?? [];
$services = $data['services'] ?? [];
$cta_heading = $data['cta_heading'] ?? '';
$cta_paragraph = $data['cta_paragraph'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulting Services | GroEdge</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <meta name="description" content="Comprehensive management consulting services including process optimization, operational strategy, and performance improvement solutions.">
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.html"><img src="logo.png" alt="GroEdge" class="logo-img"></a>
            <h1>GROEDGE</h1>
            <p class="tagline">OPERATIONAL EXCELLENCE CONSULTANTS</p>
        </div>
        <h1><?php echo htmlspecialchars($page_title); ?></h1>
        <p><?php echo htmlspecialchars($page_intro); ?></p>
    </header>

    <nav>
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="services.php">Services</a>
        <a href="projects.php">Projects</a>
        <a href="contact.php">Contact</a>
    </nav>

    <div class="container">
        <img src="services.jpg" alt="Consulting services" class="page-img">

        <div class="section-content services-page">
            <!-- Jump navigation: quick access to each service -->
            <?php if (count($services) > 0): ?>
            <nav class="services-jump" aria-label="Services quick links">
                <h2 class="services-jump-title">Services at a glance</h2>
                <ul class="services-jump-list">
                    <?php foreach ($services as $s): ?>
                    <li><a href="#service-<?php echo htmlspecialchars($s['id'] ?? ''); ?>"><?php echo htmlspecialchars($s['title'] ?? ''); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <?php endif; ?>

            <?php if ($intro_paragraph !== ''): ?>
            <section class="services-intro">
                <p><?php echo nl2br(htmlspecialchars($intro_paragraph)); ?></p>
            </section>
            <?php endif; ?>

            <?php if (count($pillars) > 0): ?>
            <section class="services-pillars">
                <h2>Our approach</h2>
                <div class="pillars-grid">
                    <?php foreach ($pillars as $p): ?>
                    <div class="pillar-card">
                        <h3><?php echo htmlspecialchars($p['title'] ?? ''); ?></h3>
                        <p><?php echo htmlspecialchars($p['description'] ?? ''); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Service cards: clear, scannable -->
            <section class="services-list">
                <h2>What we offer</h2>
                <?php if (empty($services)): ?>
                <p class="services-empty">No services have been added yet.</p>
                <?php else: ?>
                <?php foreach ($services as $s): ?>
                <article class="service-card" id="service-<?php echo htmlspecialchars($s['id'] ?? ''); ?>">
                    <h3><?php echo htmlspecialchars($s['title'] ?? ''); ?></h3>
                    <?php if (!empty($s['short_desc'])): ?>
                    <p class="service-card-teaser"><?php echo htmlspecialchars($s['short_desc']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($s['description'])): ?>
                    <p class="service-card-desc"><?php echo nl2br(htmlspecialchars($s['description'])); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($s['bullets']) && is_array($s['bullets'])): ?>
                    <ul class="service-card-bullets">
                        <?php foreach ($s['bullets'] as $b): ?>
                        <li><?php echo htmlspecialchars($b); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <a href="contact.php" class="service-card-cta">Discuss this service →</a>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <?php if (count($approach_steps) > 0): ?>
            <section class="services-methodology">
                <h2>Our engagement methodology</h2>
                <div class="methodology-steps">
                    <?php foreach ($approach_steps as $step): ?>
                    <div class="methodology-step">
                        <span class="methodology-num"><?php echo (int)($step['number'] ?? 0); ?></span>
                        <h3><?php echo htmlspecialchars($step['title'] ?? ''); ?></h3>
                        <p><?php echo htmlspecialchars($step['description'] ?? ''); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <div class="cta-section">
                <h2 style="color: white; text-align: center;"><?php echo htmlspecialchars($cta_heading); ?></h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;"><?php echo htmlspecialchars($cta_paragraph); ?></p>
                <div style="text-align: center;">
                    <a href="contact.php" class="cta-button">Schedule consultation</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div style="max-width: 1200px; margin: 0 auto;">
            <p style="margin-bottom: 10px;">&copy; 2025 GroEdge Management Consulting. All Rights Reserved.</p>
            <p style="font-size: 0.9rem; opacity: 0.8;">Strategic Consulting • Operational Excellence • Sustainable Results</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
