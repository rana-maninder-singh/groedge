<?php if (!isset($cfg)) { $cfg = get_config(); } if (!isset($base_path)) $base_path = ''; ?>
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <img src="<?php echo $base_path; ?>logo.png" alt="GroEdge" class="footer-logo">
                <p><?php echo htmlspecialchars($cfg->tagline ?? 'Where strategy meets the shop floor'); ?></p>
                <div class="footer-social">
                    <a href="<?php echo htmlspecialchars($cfg->linkedin_url ?? '#'); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                    <a href="<?php echo htmlspecialchars($cfg->twitter_url ?? '#'); ?>" target="_blank" rel="noopener" aria-label="Twitter"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    <a href="<?php echo htmlspecialchars($cfg->youtube_url ?? '#'); ?>" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Services</h4>
                <a href="<?php echo $base_path; ?>services.php#service-operational-process">Process &amp; Flow</a>
                <a href="<?php echo $base_path; ?>services.php#service-performance-strategy">Performance Systems</a>
                <a href="<?php echo $base_path; ?>services.php#service-supply-chain">Supply Chain</a>
                <a href="<?php echo $base_path; ?>services.php#service-ai-ready-operations">AI-Ready Operations</a>
                <a href="<?php echo $base_path; ?>services.php#service-sustainable-operations">ESG &amp; Sustainability</a>
                <a href="<?php echo $base_path; ?>services.php#service-workforce-capability">Workforce Capability</a>
            </div>
            <div class="footer-links">
                <h4>Industries</h4>
                <a href="<?php echo $base_path; ?>industry.php?slug=pharmaceuticals">Pharmaceuticals</a>
                <a href="<?php echo $base_path; ?>industry.php?slug=manufacturing">Manufacturing</a>
                <a href="<?php echo $base_path; ?>industry.php?slug=logistics">Logistics</a>
                <a href="<?php echo $base_path; ?>industry.php?slug=chemicals">Chemicals</a>
                <a href="<?php echo $base_path; ?>industry.php?slug=textiles">Textiles</a>
                <a href="<?php echo $base_path; ?>industry.php?slug=engineering">Engineering</a>
            </div>
            <div class="footer-links">
                <h4>Company</h4>
                <a href="<?php echo $base_path; ?>about.php">About Us</a>
                <a href="<?php echo $base_path; ?>projects.php">Case Studies</a>
                <a href="<?php echo $base_path; ?>blog.php">Insights</a>
                <a href="<?php echo $base_path; ?>resources.php">Resources</a>
                <a href="<?php echo $base_path; ?>contact.php">Contact</a>
                <a href="<?php echo $base_path; ?>admin/">Admin</a>
            </div>
            <div class="footer-contact">
                <h4>Contact</h4>
                <p><strong><?php echo htmlspecialchars($cfg->contact_person ?? 'GroEdge Management Consulting'); ?></strong></p>
                <p><a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? ''); ?>"><?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a></p>
                <p><a href="mailto:<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_info ?? ''); ?></a></p>
                <p><?php echo htmlspecialchars($cfg->address->line1 ?? 'Gurugram, NCR'); ?></p>
                <p><?php echo htmlspecialchars($cfg->business_hours ?? 'Mon-Fri: 9 AM - 6 PM IST'); ?></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> GroEdge Management Consulting. All Rights Reserved.</p>
            <p><?php echo htmlspecialchars($cfg->secondary_tagline ?? 'Diagnosis. Implementation. Capability that stays.'); ?></p>
        </div>
    </footer>

    <script src="<?php echo $base_path; ?>script.js"></script>
</body>
</html>
