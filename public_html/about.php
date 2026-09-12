<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';
$cfg = get_config();
$base_path = '';
$page_title = 'About GroEdge | Hands-On Operational Excellence Consulting';
$page_description = 'GroEdge is an India-rooted operational excellence practice. We bridge strategy and shop-floor execution for manufacturers, pharma, and supply-chain organisations.';
$current_page = 'about';
include __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Built for leaders who need results on the floor</h1>
            <p>Strategy without execution is theatre. We exist to make operational change stick—plant by plant, shift by shift.</p>
        </div>
    </section>

    <div class="container">
        <img src="about.jpg" alt="GroEdge consultants working with a client operations team" class="page-img">

        <div class="section-content">
            <div class="journey-section" style="margin-bottom: 50px;">
                <h2>Why we started GroEdge</h2>
                <p>After years inside manufacturing plants, we saw a pattern: expensive consulting reports that never survived the first production rush. Leadership wanted transformation; supervisors needed something they could run on Monday morning.</p>

                <p>GroEdge was founded on a simple rule: <strong>if it cannot be implemented with your people, under your constraints, it is not a recommendation—it is a suggestion.</strong> We still do rigorous analysis. We simply refuse to stop at the PowerPoint.</p>

                <div style="background: #f8fafc; padding: 25px; margin: 30px 0; border-left: 4px solid #2c5282;">
                    <p style="font-style: italic; margin: 0;">"Clients do not hire us for clever frameworks. They hire us to stand with their teams until throughput, quality, and delivery actually move—and stay moved."</p>
                    <p style="text-align: right; margin-top: 15px; font-weight: 500;">— Rajesh Pal, Founder &amp; Principal Consultant</p>
                </div>
            </div>

            <div class="mission-vision" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 50px;">
                <div style="padding: 30px; background: #ffffff; border: 1px solid #e2e8f0;">
                    <h3 style="color: #1a365d;">Mission</h3>
                    <p>Help Indian and regional enterprises convert operational ambition into measurable performance—lower cost, higher reliability, and stronger customer service—through hands-on excellence work.</p>
                </div>
                <div style="padding: 30px; background: #ffffff; border: 1px solid #e2e8f0;">
                    <h3 style="color: #1a365d;">Vision</h3>
                    <p>Be the partner operators trust when the stakes are real: capacity is tight, margins are under pressure, and "business as usual" is no longer good enough.</p>
                </div>
            </div>

            <div class="approach-section" style="margin-bottom: 50px;">
                <h2>Our working method</h2>
                <p>Lean discipline, practical analytics, and co-ownership with your line managers. Four steps, no mystery.</p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-top: 30px;">
                    <div style="text-align: center; padding: 25px;">
                        <div style="background: #2c5282; color: white; width: 50px; height: 50px; line-height: 50px; border-radius: 50%; margin: 0 auto 20px; font-weight: bold;">1</div>
                        <h3 style="color: #1a365d;">See the real work</h3>
                        <p>Gemba walks, loss analysis, and interviews—so we solve the constraint that exists, not the one reported in meetings.</p>
                    </div>
                    <div style="text-align: center; padding: 25px;">
                        <div style="background: #2c5282; color: white; width: 50px; height: 50px; line-height: 50px; border-radius: 50%; margin: 0 auto 20px; font-weight: bold;">2</div>
                        <h3 style="color: #1a365d;">Design with your team</h3>
                        <p>Solutions are co-created with supervisors and process owners. Buy-in is designed in, not bolted on later.</p>
                    </div>
                    <div style="text-align: center; padding: 25px;">
                        <div style="background: #2c5282; color: white; width: 50px; height: 50px; line-height: 50px; border-radius: 50%; margin: 0 auto 20px; font-weight: bold;">3</div>
                        <h3 style="color: #1a365d;">Implement on site</h3>
                        <p>We support pilots, standard work, and daily management until the new process runs without heroics.</p>
                    </div>
                    <div style="text-align: center; padding: 25px;">
                        <div style="background: #2c5282; color: white; width: 50px; height: 50px; line-height: 50px; border-radius: 50%; margin: 0 auto 20px; font-weight: bold;">4</div>
                        <h3 style="color: #1a365d;">Leave capability behind</h3>
                        <p>Training, visual controls, and a rhythm of review so improvement continues after we step back.</p>
                    </div>
                </div>
            </div>

            <div class="why-choose" style="background: #f0f7ff; padding: 40px; margin: 50px 0; border-radius: 8px;">
                <h2 style="text-align: center;">Why leadership teams choose us</h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 30px;">
                    <div>
                        <h3 style="color: #2c5282; margin-bottom: 15px;">Industry realism</h3>
                        <p>Deep experience across manufacturing, pharmaceuticals, chemicals, engineering, textiles, and distribution—where compliance, labour, and logistics constraints are non-negotiable.</p>
                    </div>
                    <div>
                        <h3 style="color: #2c5282; margin-bottom: 15px;">Presence where work happens</h3>
                        <p>We spend meaningful time on site. Problems that only appear at 2 a.m. on a packing line rarely show up in a conference call.</p>
                    </div>
                    <div>
                        <h3 style="color: #2c5282; margin-bottom: 15px;">Decisions from data</h3>
                        <p>Baselines, targets, and a lean set of KPIs. Debate focuses on facts, not opinions dressed as strategy.</p>
                    </div>
                    <div>
                        <h3 style="color: #2c5282; margin-bottom: 15px;">End-to-end ownership</h3>
                        <p>Assessment through sustainment. One accountable partner from diagnosis to handover—not a revolving door of specialists.</p>
                    </div>
                </div>
            </div>

            <div class="founder-profile" id="rajesh">
                <div class="founder-profile-head">
                    <div class="founder-avatar" aria-hidden="true">RP</div>
                    <div>
                        <p class="founder-kicker">Founder &amp; Principal Consultant</p>
                        <h2>Rajesh Pal</h2>
                        <p class="founder-meta">PMP · Six Sigma Black Belt · 18+ years</p>
                    </div>
                </div>
                <p>Rajesh has spent more than 18 years leading change, business excellence, and process work across manufacturing and services. His programmes cover operations excellence, supply chain, and lean management systems — including the workshops that get a leadership team to a shared plan, not only a report.</p>
                <p>He holds a degree in Business Administration and a Master’s in Business Leadership from the School of Inspired Leadership (SOL). He is a certified PMP and Six Sigma Black Belt, and works with LIP (Large-scale Interactive Process), TQM, TPM, lean, 5S, and kaizen.</p>
                <h3>Selected results</h3>
                <ul class="founder-results">
                    <li><strong>Textile manufacturer, Uttar Pradesh.</strong> Business transformation using real-time strategic change, lean manufacturing, structured problem solving, and process re-engineering. Throughput rose from 12,000 to 16,500 metres a day. Monthly dispatch top line moved from ₹5 crore to ₹8.9 crore.</li>
                    <li><strong>Paper manufacturer, Punjab.</strong> Finishing loss cut from 8.80% to 5.00%.</li>
                    <li><strong>Organised fruit &amp; vegetable retail.</strong> Backward-integration strategy that improved supply-chain efficiency and reduced lead times, plus market analysis used to shape the growth plan.</li>
                    <li><strong>German manufacturer of heavy road-construction equipment.</strong> Operations due diligence.</li>
                    <li><strong>Textile firm, north India.</strong> Higher throughput and machine efficiency; a daily monitoring and order-dispatch system; root-cause work on reprocessing and fabric quality.</li>
                </ul>
                <p class="founder-cta"><a href="contact.php" class="btn btn-accent">Talk to Rajesh</a></p>
            </div>

            <div style="text-align: center; margin-top: 50px; padding: 40px; background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%); color: white; border-radius: 8px;">
                <h2 style="color: white;">Start with a conversation</h2>
                <p style="max-width: 700px; margin: 20px auto 30px; opacity: 0.9;">If your plant or network is under pressure—cost, capacity, quality, or delivery—let us walk the problem with you for an hour. No slide theatre. Clear next steps.</p>
                <a href="contact.php" class="cta-button" style="background: white; color: #1a365d;">Talk to our leadership</a>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
