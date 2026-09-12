<?php
$page_title = 'Rajesh Pal | Operational Excellence Consultant in India | GroEdge';
$page_description = 'Rajesh Pal is a PMP and Six Sigma Black Belt. GroEdge helps manufacturers in India raise throughput, cut loss, and shorten supply-chain lead times — on the floor, not in a slide deck.';
$current_page = 'home';
$base_path = '';

define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$cfg = get_config();
$testimonials_data = get_testimonials_data();
$testimonials = $testimonials_data['testimonials'] ?? [];
$blog_data = get_blog_data();
$blog_posts = $blog_data['posts'] ?? [];
$services_data = get_services_data();

$faq = [
    [
        'q' => 'Who is Rajesh Pal?',
        'a' => 'Rajesh Pal is the founder and principal consultant of GroEdge Management Consulting in Gurugram, India. He is a PMP and Six Sigma Black Belt with more than 18 years in change management, operations excellence, lean, and supply chain. He holds a degree in Business Administration and a Master’s in Business Leadership from the School of Inspired Leadership (SOL).',
    ],
    [
        'q' => 'What does GroEdge do?',
        'a' => 'GroEdge helps manufacturers and service operations improve throughput, yield, dispatch, and lead time. The work uses lean, structured problem solving, process re-engineering, TQM, TPM, 5S, kaizen, and large-scale interactive process (LIP) workshops so the plant can run the change.',
    ],
    [
        'q' => 'What results has Rajesh Pal delivered?',
        'a' => 'On a textile line in Uttar Pradesh, throughput rose from 12,000 to 16,500 metres a day and monthly dispatch top line moved from ₹5 crore to ₹8.9 crore. At a paper manufacturer in Punjab, finishing loss fell from 8.80% to 5.00%. Other work includes organised fruit-and-vegetable retail supply chain and operations due diligence for a German heavy-equipment manufacturer.',
    ],
    [
        'q' => 'Where does GroEdge work?',
        'a' => 'GroEdge is based in Gurugram, National Capital Region, and works on site across India. Completed work includes textiles in Uttar Pradesh and north India, paper in Punjab, organised retail supply chain, and industrial equipment.',
    ],
];
$page_schema = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(function ($item) {
        return [
            '@type' => 'Question',
            'name' => $item['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['a'],
            ],
        ];
    }, $faq),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

include __DIR__ . '/includes/header.php';
?>

    <!-- A) HERO SECTION -->
    <section class="hero" aria-label="GroEdge introduction">
        <div class="hero-media" style="background-image: url('hero.jpg');" role="img" aria-label="Manufacturing plant floor"></div>
        <div class="hero-content">
            <img src="logo.png" alt="GroEdge" class="hero-logo">
            <h1>Where strategy meets the shop floor</h1>
            <p class="hero-lead">Turn bottlenecks, rework, and firefighting into reliable flow — so cost, quality, and delivery improve together, and stay improved.</p>
            <div class="hero-cta">
                <a href="contact.php" class="btn btn-accent">Book free assessment</a>
                <a href="services.php" class="btn btn-ghost">See how we help</a>
            </div>
        </div>
    </section>

    <!-- B) TRUST BAR -->
    <div class="trust-bar">
        <div class="trust-bar-inner">
            <div class="trust-stat"><strong>18+</strong> Years on the work</div>
            <div class="trust-stat"><strong>16,500</strong> Metres/day, textile line</div>
            <div class="trust-stat"><strong>₹8.9 cr</strong> Monthly dispatch top line</div>
            <div class="trust-stat"><strong>5%</strong> Finishing loss, from 8.8%</div>
        </div>
    </div>

    <div class="container">
        <div class="section-content">

            <!-- C) WHERE STRATEGY MEETS THE SHOP FLOOR -->
            <div class="home-band reveal">
                <h2>Where strategy meets the shop floor</h2>
                <p>Most companies already know what "good" looks like. The gap is execution: unstable processes, unclear ownership, and improvements that fade after the kick-off workshop. GroEdge closes that gap—we diagnose with data, redesign with your people, and stay through implementation until the new way of working is the default.</p>

                <div class="outcome-row">
                    <div class="outcome-item">
                        <h3>Tied to business outcomes</h3>
                        <p>Every workstream maps to a commercial goal—lower unit cost, higher OTIF, faster cash conversion, or capacity without new capex.</p>
                    </div>
                    <div class="outcome-item">
                        <h3>Measured, not marketed</h3>
                        <p>We agree baselines and targets up front. Progress is tracked with a short KPI set your leadership can review weekly.</p>
                    </div>
                    <div class="outcome-item">
                        <h3>Built to last</h3>
                        <p>Standard work, visual management, and supervisor capability stay with your team—so gains do not leave with the consultants.</p>
                    </div>
                </div>
            </div>

            <!-- D) TESTIMONIALS CAROUSEL -->
            <?php if (!empty($testimonials)): ?>
            <section class="testimonials-section reveal">
                <h2 style="text-align:center;">What our clients say</h2>
                <p style="text-align:center; color:var(--muted); margin-bottom:30px;">Verified feedback from operations leaders we have worked with.</p>
                <div class="testimonial-carousel" id="testimonialCarousel">
                    <div class="testimonial-track">
                        <?php foreach ($testimonials as $t): ?>
                        <div class="testimonial-card">
                            <div class="testimonial-stars">★★★★★</div>
                            <blockquote class="testimonial-quote">"<?php echo htmlspecialchars($t['quote'] ?? ''); ?>"</blockquote>
                            <div class="testimonial-author">
                                <div class="testimonial-avatar"><img src="<?php echo htmlspecialchars($t['avatar'] ?? ''); ?>" alt="<?php echo htmlspecialchars($t['name'] ?? ''); ?>"></div>
                                <div>
                                    <strong><?php echo htmlspecialchars($t['name'] ?? ''); ?></strong>
                                    <span><?php echo htmlspecialchars(($t['role'] ?? '') . ', ' . ($t['company'] ?? '')); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-btn carousel-prev" aria-label="Previous">&#10094;</button>
                    <button class="carousel-btn carousel-next" aria-label="Next">&#10095;</button>
                    <div class="carousel-dots"></div>
                </div>
            </section>
            <?php endif; ?>

            <!-- E) RESULTS CLIENTS TYPICALLY UNLOCK -->
            <div class="home-band reveal">
                <h2>Results from the work, not a range</h2>
                <p style="margin-bottom: 8px;">These are outcomes from engagements led by Rajesh Pal. Your number depends on the starting point — we will not promise a band we cannot stand behind.</p>
                <div class="stats-container">
                    <div class="stat">
                        <h3>18+</h3>
                        <p>Years in change, operations, and lean</p>
                    </div>
                    <div class="stat">
                        <h3>16,500</h3>
                        <p>Metres a day, up from 12,000 on a textile line</p>
                    </div>
                    <div class="stat">
                        <h3>₹8.9 cr</h3>
                        <p>Monthly dispatch top line, up from ₹5 cr</p>
                    </div>
                    <div class="stat">
                        <h3>5.00%</h3>
                        <p>Finishing loss, down from 8.80% in paper</p>
                    </div>
                </div>
                <p style="margin-top: 20px;"><a href="projects.php">See the engagements</a></p>
            </div>

            <!-- F) SECTORS WE KNOW WELL -->
            <div class="home-band reveal">
                <h2>Where this work has already landed</h2>
                <p>Textiles, paper, organised fresh retail, and industrial equipment — manufacturing and services, where flow, yield, and lead time show up in the P&amp;L.</p>
                <div class="sector-strip">
                    <span>Textiles</span>
                    <span>Paper</span>
                    <span>Retail supply chain</span>
                    <span>Industrial equipment</span>
                    <span>Manufacturing</span>
                    <span>Services</span>
                </div>
            </div>

            <!-- G) HOW WE WORK DIFFERENTLY -->
            <div class="home-band reveal" style="margin-bottom: 0;">
                <h2>How we work differently</h2>
                <div class="difference-list">
                    <div>
                        <h3>Partners on the floor</h3>
                        <p>We observe real work, not only meeting-room narratives—then design changes operators and supervisors can run daily.</p>
                    </div>
                    <div>
                        <h3>Evidence before opinion</h3>
                        <p>Recommendations come from process data, loss trees, and benchmarks—not generic frameworks renamed for your industry.</p>
                    </div>
                    <div>
                        <h3>From pilot to plant</h3>
                        <p>We prove value in a controlled area, then scale with a clear playbook so multi-site rollouts stay consistent.</p>
                    </div>
                    <div>
                        <h3>Practical over perfect</h3>
                        <p>Executable 90-day plans beat 200-page strategy books. We prioritise the few moves that move the needle.</p>
                    </div>
                </div>
            </div>

            <!-- H) INSIGHTS PREVIEW -->
            <?php
            $latest_posts = array_slice($blog_posts, 0, 3);
            if (!empty($latest_posts)):
            ?>
            <section class="insights-preview reveal">
                <h2 style="text-align:center;">Latest insights</h2>
                <p style="text-align:center; color:var(--muted); margin-bottom:30px;">Practical perspectives on operational excellence, supply chain, and manufacturing performance.</p>
                <div class="blog-grid">
                    <?php foreach ($latest_posts as $post): ?>
                    <article class="blog-card">
                        <div class="blog-card-image"><img src="<?php echo htmlspecialchars($post['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? ''); ?>"></div>
                        <div class="blog-card-body">
                            <span class="blog-card-category"><?php echo htmlspecialchars($post['category'] ?? ''); ?></span>
                            <h3><a href="article.php?slug=<?php echo htmlspecialchars($post['slug'] ?? ''); ?>"><?php echo htmlspecialchars($post['title'] ?? ''); ?></a></h3>
                            <p><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></p>
                            <div class="blog-card-meta"><?php echo htmlspecialchars(($post['author'] ?? '') . ' · ' . ($post['date'] ?? '') . ' · ' . ($post['read_time'] ?? '')); ?></div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <div style="text-align:center; margin-top:30px;">
                    <a href="blog.php" class="btn btn-accent">View all insights</a>
                </div>
            </section>
            <?php endif; ?>

            <!-- I) FAQ — visible answers for search and AI -->
            <section class="home-band reveal" id="faq">
                <h2>Questions buyers ask</h2>
                <?php foreach ($faq as $item): ?>
                <h3><?php echo htmlspecialchars($item['q']); ?></h3>
                <p><?php echo htmlspecialchars($item['a']); ?></p>
                <?php endforeach; ?>
            </section>

            <!-- J) CTA SECTION -->
            <div class="cta-section reveal">
                <h2 style="color: white; text-align: center;">Find your highest-ROI operational fix</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Book a complimentary 60-minute assessment. We will pressure-test your biggest constraint and leave you with a shortlist of priorities—whether or not we work together next.</p>
                <div style="text-align: center;">
                    <a href="contact.php" class="cta-button">Book free assessment</a>
                    <a href="services.php" class="cta-button" style="background: transparent; border: 2px solid white; margin-left: 15px; color: white;">See how we help</a>
                </div>
            </div>

        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
