<?php
$page_title = 'Page Not Found | GroEdge';
$page_description = 'The page you are looking for does not exist or has been moved.';
$current_page = '';
$base_path = '';

define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

include __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Page not found</h1>
            <p>The page you requested does not exist or has been moved.</p>
        </div>
    </section>

    <div class="container">
        <div class="section-content" style="text-align: center; padding: 60px 20px;">
            <h2 style="margin-bottom: 20px;">404</h2>
            <p style="margin-bottom: 30px; color: var(--muted);">We could not find the page you were looking for. It may have been renamed, moved, or removed.</p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="index.php" class="btn btn-accent">Go to homepage</a>
                <a href="services.php" class="btn btn-ghost">View our services</a>
                <a href="contact.php" class="btn btn-ghost">Contact us</a>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
