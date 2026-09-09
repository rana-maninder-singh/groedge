<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$data = get_projects_data();
$key_achievements = $data['key_achievements'] ?? [];
$projects = $data['projects'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects & Achievements | GroEdge</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <meta name="description" content="Explore GroEdge's project portfolio and key achievements in operational excellence, lean transformation, and process improvement.">
</head>
<body>
    <header>
        <div class="logo logo-dark">
            <a href="index.html"><img src="logo.png" alt="GroEdge" class="logo-img"></a>
            <h1>GROEDGE</h1>
            <p class="tagline">OPERATIONAL EXCELLENCE CONSULTANTS</p>
        </div>
        <h1>Projects & Achievements</h1>
        <p>Track record of delivering measurable improvements across industries.</p>
    </header>

    <nav>
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="services.php">Services</a>
        <a href="projects.php">Projects</a>
        <a href="contact.php">Contact</a>
    </nav>

    <div class="container">
        <div class="section-content">
            <?php if (!empty($key_achievements)): ?>
            <div style="margin-bottom: 50px;">
                <h2>Key Achievements</h2>
                <p style="margin-bottom: 25px;">Our impact at a glance across engagements and years of practice.</p>
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
                <h2>Selected Projects</h2>
                <p style="margin-bottom: 30px;">A sample of our work: objectives, approach, and outcomes.</p>

                <?php if (empty($projects)): ?>
                <p style="color: #718096;">No projects have been added yet. Check back soon.</p>
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
                <h2 style="color: white; text-align: center;">Start Your Own Success Story</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Discuss how we can deliver similar results for your organization.</p>
                <div style="text-align: center;">
                    <a href="contact.php" class="cta-button">Get in Touch</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div style="max-width: 1200px; margin: 0 auto;">
            <p style="margin-bottom: 10px;">&copy; 2025 GroEdge Management Consulting. All Rights Reserved.</p>
            <p style="font-size: 0.9rem; opacity: 0.8;">Transforming Operations • Driving Performance • Delivering Results</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
