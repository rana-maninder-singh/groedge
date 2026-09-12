<?php
if (!isset($base_path)) $base_path = '';
if (!isset($page_title)) $page_title = 'Rajesh Pal | Operational Excellence Consultant in India | GroEdge';
if (!isset($page_description)) $page_description = 'GroEdge is the operational excellence practice of Rajesh Pal, PMP and Six Sigma Black Belt. Lean, change, and supply-chain work for manufacturers in India.';
if (!isset($current_page)) $current_page = '';
if (!isset($page_canonical)) {
    $canonical_paths = [
        'home' => 'https://groedge.in/',
        'about' => 'https://groedge.in/about.php',
        'services' => 'https://groedge.in/services.php',
        'projects' => 'https://groedge.in/projects.php',
        'contact' => 'https://groedge.in/contact.php',
        'blog' => 'https://groedge.in/blog.php',
        'industries' => 'https://groedge.in/industries.php',
        'resources' => 'https://groedge.in/resources.php',
    ];
    $page_canonical = $canonical_paths[$current_page] ?? 'https://groedge.in/';
}
if (!isset($cfg)) { define('DATA_DIR', __DIR__ . '/../data'); require_once __DIR__ . '/config.php'; $cfg = get_config(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>style.css">
    <link rel="icon" type="image/png" href="https://groedge.in/logo.png">
    <link rel="canonical" href="<?php echo htmlspecialchars($page_canonical); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="Rajesh Pal">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($page_canonical); ?>">
    <meta property="og:image" content="https://groedge.in/logo.png">
    <meta property="og:locale" content="en_IN">
    <meta property="og:site_name" content="GroEdge Management Consulting">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="https://groedge.in/logo.png">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "ProfessionalService",
          "@id": "https://groedge.in/#organization",
          "name": "GroEdge Management Consulting",
          "url": "https://groedge.in/",
          "logo": "https://groedge.in/logo.png",
          "image": "https://groedge.in/logo.png",
          "description": "Operational excellence consulting led by Rajesh Pal. Change, lean, supply chain, and process work for manufacturers in India.",
          "telephone": "+919870255501",
          "email": "info@groedge.in",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Gurugram",
            "addressRegion": "Haryana",
            "addressCountry": "IN"
          },
          "areaServed": "IN",
          "founder": { "@id": "https://groedge.in/about.php#rajesh" },
          "knowsAbout": ["Operational excellence", "Lean manufacturing", "Change management", "Supply chain", "Six Sigma", "TQM", "TPM"]
        },
        {
          "@type": "Person",
          "@id": "https://groedge.in/about.php#rajesh",
          "name": "Rajesh Pal",
          "jobTitle": "Founder and Principal Consultant",
          "worksFor": { "@id": "https://groedge.in/#organization" },
          "url": "https://groedge.in/about.php#rajesh",
          "email": "rajesh@groedge.in",
          "telephone": "+919870255501",
          "description": "PMP and Six Sigma Black Belt with more than 18 years in change, operations excellence, lean, and supply chain across manufacturing and services in India.",
          "alumniOf": "School of Inspired Leadership",
          "hasCredential": ["PMP", "Six Sigma Black Belt"]
        }
      ]
    }
    </script>
    <?php if (!empty($page_schema)): ?>
    <script type="application/ld+json"><?php echo $page_schema; ?></script>
    <?php endif; ?>
</head>
<body>

<!-- WhatsApp Float -->
<a href="https://wa.me/<?php echo htmlspecialchars($cfg->whatsapp_number ?? '919870255501'); ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <svg viewBox="0 0 32 32" width="28" height="28" fill="white"><path d="M16.004 0h-.008C7.174 0 0 7.176 0 16c0 3.5 1.132 6.744 3.054 9.374L1.054 31.25l6.118-1.978A15.912 15.912 0 0016.004 32C24.83 32 32 24.822 32 16S24.83 0 16.004 0zm9.34 22.594c-.39 1.094-1.932 2.006-3.16 2.27-.836.178-1.93.32-5.624-1.21-4.734-1.96-7.776-6.766-8.01-7.076-.226-.31-1.888-2.51-1.888-4.788 0-2.276 1.196-3.394 1.62-3.858.39-.428.924-.55 1.23-.55.31 0 .618.004.888.016.284.012.664-.106 1.036.79.39.942 1.326 3.228 1.44 3.462.114.234.19.506.038.816-.152.312-.228.506-.454.78-.226.274-.454.5-.664.712-.226.226-.44.47-.188.864.254.394 1.128 1.86 2.416 3.014 1.66 1.484 3.034 1.944 3.482 2.162.39.19.836.142 1.134-.19.314-.352.704-.934 1.098-1.502.284-.41.646-.462 1.094-.312.454.152 2.878 1.36 3.372 1.604.494.244.824.366.948.566.126.198.126 1.146-.264 2.24z"/></svg>
</a>

<!-- Floating CTA -->
<a href="<?php echo $base_path; ?>contact.php" class="floating-cta">Book Free Assessment</a>

<div class="site-top">
    <a href="<?php echo $base_path; ?>index.php" class="brand">
        <img src="<?php echo $base_path; ?>logo.png" alt="GroEdge" class="logo-img">
    </a>
    <nav class="main-nav" aria-label="Main navigation">
        <a href="<?php echo $base_path; ?>index.php"<?php if ($current_page === 'home') echo ' class="active"'; ?>>Home</a>

        <div class="nav-dropdown">
            <button class="nav-dropdown-toggle" aria-expanded="false">
                Services <span class="dropdown-arrow">&#9662;</span>
            </button>
            <div class="mega-menu">
                <div class="mega-menu-inner">
                    <div class="mega-col">
                        <h4>Core Services</h4>
                        <a href="<?php echo $base_path; ?>services.php">All Services</a>
                        <a href="<?php echo $base_path; ?>services.php#service-operational-process">Process &amp; Flow</a>
                        <a href="<?php echo $base_path; ?>services.php#service-performance-strategy">Performance Systems</a>
                        <a href="<?php echo $base_path; ?>services.php#service-org-design">Operating Model</a>
                        <a href="<?php echo $base_path; ?>services.php#service-technology-advisory">Technology Advisory</a>
                        <a href="<?php echo $base_path; ?>services.php#service-supply-chain">Supply Chain</a>
                        <a href="<?php echo $base_path; ?>services.php#service-quality-management">Quality Systems</a>
                    </div>
                    <div class="mega-col">
                        <h4>Growth Areas</h4>
                        <a href="<?php echo $base_path; ?>services.php#service-ai-ready-operations">AI-Ready Operations</a>
                        <a href="<?php echo $base_path; ?>services.php#service-sustainable-operations">Sustainable Ops &amp; ESG</a>
                        <a href="<?php echo $base_path; ?>services.php#service-supply-chain-resilience">Supply Chain Resilience</a>
                        <a href="<?php echo $base_path; ?>services.php#service-operational-due-diligence">Operational Due Diligence</a>
                        <a href="<?php echo $base_path; ?>services.php#service-workforce-capability">Workforce Capability</a>
                    </div>
                    <div class="mega-cta">
                        <p>Not sure which service fits?</p>
                        <a href="<?php echo $base_path; ?>contact.php" class="btn btn-accent">Book free assessment</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-dropdown">
            <button class="nav-dropdown-toggle" aria-expanded="false">
                Industries <span class="dropdown-arrow">&#9662;</span>
            </button>
            <div class="mega-menu mega-menu-industries">
                <div class="mega-menu-inner">
                    <div class="mega-col">
                        <a href="<?php echo $base_path; ?>industries.php">All Industries</a>
                        <a href="<?php echo $base_path; ?>industry.php?slug=pharmaceuticals">Pharmaceuticals</a>
                        <a href="<?php echo $base_path; ?>industry.php?slug=manufacturing">Manufacturing</a>
                        <a href="<?php echo $base_path; ?>industry.php?slug=logistics">Logistics &amp; Distribution</a>
                    </div>
                    <div class="mega-col">
                        <a href="<?php echo $base_path; ?>industry.php?slug=chemicals">Chemicals</a>
                        <a href="<?php echo $base_path; ?>industry.php?slug=textiles">Textiles &amp; Garments</a>
                        <a href="<?php echo $base_path; ?>industry.php?slug=engineering">Engineering</a>
                    </div>
                </div>
            </div>
        </div>

        <a href="<?php echo $base_path; ?>projects.php"<?php if ($current_page === 'projects') echo ' class="active"'; ?>>Projects</a>

        <div class="nav-dropdown">
            <button class="nav-dropdown-toggle" aria-expanded="false">
                Insights <span class="dropdown-arrow">&#9662;</span>
            </button>
            <div class="mega-menu">
                <div class="mega-menu-inner">
                    <div class="mega-col">
                        <a href="<?php echo $base_path; ?>blog.php">Blog &amp; Articles</a>
                        <a href="<?php echo $base_path; ?>resources.php">Resources &amp; Downloads</a>
                    </div>
                </div>
            </div>
        </div>

        <a href="<?php echo $base_path; ?>about.php"<?php if ($current_page === 'about') echo ' class="active"'; ?>>About</a>
        <a href="<?php echo $base_path; ?>contact.php"<?php if ($current_page === 'contact') echo ' class="active"'; ?>>Contact</a>
        <a href="<?php echo $base_path; ?>contact.php" class="nav-cta">Book Assessment</a>
    </nav>
    <button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</div>
