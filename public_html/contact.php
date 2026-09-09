<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$form_values = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'industry' => '',
    'employees' => '',
    'service' => '',
    'challenge' => '',
    'message' => ''
];
$form_errors = [];
$status = $_GET['status'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form_values as $key => $_) {
        $form_values[$key] = trim((string) ($_POST[$key] ?? ''));
    }

    if (strlen($form_values['name']) < 2) {
        $form_errors['name'] = 'Full name is required (at least 2 characters).';
    }
    if (!filter_var($form_values['email'], FILTER_VALIDATE_EMAIL)) {
        $form_errors['email'] = 'Please enter a valid business email.';
    }
    $phone_digits = preg_replace('/\D/', '', $form_values['phone']);
    if (strlen($phone_digits) < 10) {
        $form_errors['phone'] = 'Phone number must include at least 10 digits.';
    }
    if (strlen($form_values['company']) < 2) {
        $form_errors['company'] = 'Company name is required.';
    }
    if ($form_values['industry'] === '') {
        $form_errors['industry'] = 'Please select your industry.';
    }
    if (strlen($form_values['challenge']) < 10) {
        $form_errors['challenge'] = 'Please describe your challenge (at least 10 characters).';
    }

    if (empty($form_errors)) {
        $saved = save_submission($form_values);
        if (!$saved) {
            $status = 'save_error';
        } else {
            $cfg = get_config();
            $to = sanitize_header_value($cfg->form_to_email ?? 'info@groedge.in');
            $bcc = sanitize_header_value($cfg->form_bcc ?? 'rajesh@groedge.in, sales@groedge.in');
            $from = sanitize_header_value($cfg->email_info ?? 'info@groedge.in');
            $reply = sanitize_header_value($form_values['email']);
            $safe_name = sanitize_header_value($form_values['name']);
            $subject = 'New Contact Form Submission from ' . $safe_name;

            $body = "Name: {$form_values['name']}\nEmail: {$form_values['email']}\nPhone: {$form_values['phone']}\nCompany: {$form_values['company']}\n";
            $body .= "Industry: {$form_values['industry']}\nCompany Size: {$form_values['employees']}\nPrimary Interest: {$form_values['service']}\n\n";
            $body .= "Biggest Operational Challenge:\n{$form_values['challenge']}\n\n";
            if ($form_values['message'] !== '') {
                $body .= "Additional Details:\n{$form_values['message']}\n";
            }

            $headers = "From: {$from}\r\nReply-To: {$reply}\r\n";
            if ($bcc !== '') {
                $headers .= "Bcc: {$bcc}\r\n";
            }
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            $mailOk = @mail($to, $subject, $body, $headers);
            header('Location: contact.php?status=' . ($mailOk ? 'success' : 'error'));
            exit;
        }
    }
}

$cfg = get_config();
$addr = $cfg->address ?? (object)['company' => '', 'line1' => '', 'line2' => '', 'country' => ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact GroEdge | Book a Free Operational Assessment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <meta name="description" content="Schedule a complimentary 60-minute operational assessment with GroEdge. Identify your top constraints in cost, quality, capacity, or delivery—with clear next steps.">
</head>
<body>
    <div class="site-top">
        <a href="index.html" class="brand">
            <img src="logo.png" alt="GroEdge" class="logo-img">
        </a>
        <nav>
            <a href="index.html">Home</a>
            <a href="about.html">About</a>
            <a href="services.php">Services</a>
            <a href="projects.php">Projects</a>
            <a href="contact.php">Contact</a>
        </nav>
    </div>

    <section class="page-banner">
        <div class="page-banner-inner">
            <h1>Tell us where operations are stuck</h1>
            <p>Share your constraint. We will respond within one business day with a proposed assessment agenda—focused on outcomes, not a sales pitch.</p>
        </div>
    </section>

    <div class="container">
        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
             alt="GroEdge consultants in a strategic planning session with a client"
             class="page-img"
             style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 40px;">

        <div class="section-content">
            <?php if ($status === 'success'): ?>
            <div class="form-status success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Thank you. Your request is with our team. We will contact you within one business day to schedule your assessment.</div>
            <?php elseif ($status === 'error'): ?>
            <div class="form-status error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Your details were saved. Email delivery had a problem on our side—we will still follow up directly.</div>
            <?php elseif ($status === 'save_error'): ?>
            <div class="form-status error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">We could not save your request online. Please email info@groedge.in or call us, and we will take it from there.</div>
            <?php elseif (!empty($form_errors)): ?>
            <div class="form-status error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Please correct the highlighted fields and submit again.</div>
            <?php endif; ?>

            <div style="margin-bottom: 40px;">
                <h2>Leaders lose days to firefighting. Get them back.</h2>
                <p>When processes are unstable, senior time leaks into exceptions, expedites, and status meetings. A short, structured assessment surfaces the few changes that free capacity and calm the operation—before you commit to a larger programme.</p>
                <div style="text-align: center; margin: 30px 0;">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Operations performance review and data-led decision making"
                         style="max-width: 80%; height: auto; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;">
                    <div style="text-align: center; padding: 25px; background: #f8fafc;">
                        <h3 style="color: #2c5282;">60-minute assessment</h3>
                        <p>Clarify your top constraints and a practical shortlist of next moves.</p>
                    </div>
                    <div style="text-align: center; padding: 25px; background: #f8fafc;">
                        <h3 style="color: #2c5282;">No obligation</h3>
                        <p>Useful whether or not you engage us further. You leave with clarity.</p>
                    </div>
                    <div style="text-align: center; padding: 25px; background: #f8fafc;">
                        <h3 style="color: #2c5282;">Sector-aware advice</h3>
                        <p>Guidance grounded in manufacturing, pharma, chemicals, and logistics realities.</p>
                    </div>
                </div>
            </div>

            <div class="contact-info" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 50px;">
                <div class="form-section">
                    <h3>Request your free assessment</h3>
                    <div style="margin-bottom: 30px;">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                             alt="A GroEdge consultant discussing a project plan with a business executive"
                             style="width: 100%; border-radius: 8px;">
                    </div>
                    <form id="contactForm" action="contact.php" method="post" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($form_values['name']); ?>" required>
                            <div class="error-message" id="name-error"><?php echo htmlspecialchars($form_errors['name'] ?? ''); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Business Email *</label>
                            <input type="email" id="email" name="email" placeholder="name@company.com" value="<?php echo htmlspecialchars($form_values['email']); ?>" required>
                            <div class="error-message" id="email-error"><?php echo htmlspecialchars($form_errors['email'] ?? ''); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" placeholder="<?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?>" value="<?php echo htmlspecialchars($form_values['phone']); ?>" required>
                            <div class="error-message" id="phone-error"><?php echo htmlspecialchars($form_errors['phone'] ?? ''); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="company">Company Name *</label>
                            <input type="text" id="company" name="company" placeholder="Your company name" value="<?php echo htmlspecialchars($form_values['company']); ?>" required>
                            <div class="error-message" id="company-error"><?php echo htmlspecialchars($form_errors['company'] ?? ''); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="industry">Industry *</label>
                            <select id="industry" name="industry" required>
                                <option value="">Select your industry</option>
                                <?php
                                $industries = [
                                    'manufacturing' => 'Manufacturing',
                                    'pharmaceutical' => 'Pharmaceuticals',
                                    'chemical' => 'Chemicals',
                                    'engineering' => 'Engineering',
                                    'textiles' => 'Textiles & Garments',
                                    'logistics' => 'Logistics & Supply Chain',
                                    'other' => 'Other',
                                ];
                                foreach ($industries as $val => $label):
                                ?>
                                <option value="<?php echo $val; ?>"<?php echo $form_values['industry'] === $val ? ' selected' : ''; ?>><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="error-message" id="industry-error"><?php echo htmlspecialchars($form_errors['industry'] ?? ''); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="employees">Company Size</label>
                            <select id="employees" name="employees">
                                <option value="">Select number of employees</option>
                                <?php
                                $sizes = ['1-50' => '1-50 Employees', '51-200' => '51-200 Employees', '201-500' => '201-500 Employees', '501-1000' => '501-1000 Employees', '1000+' => '1000+ Employees'];
                                foreach ($sizes as $val => $label):
                                ?>
                                <option value="<?php echo htmlspecialchars($val); ?>"<?php echo $form_values['employees'] === $val ? ' selected' : ''; ?>><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="service">Primary Interest</label>
                            <select id="service" name="service">
                                <option value="">Select area of interest</option>
                                <?php
                                $services = [
                                    'process' => 'Process Optimization',
                                    'digital' => 'Digital Transformation',
                                    'supply' => 'Supply Chain Management',
                                    'quality' => 'Quality Systems (QMS)',
                                    'manufacturing' => 'Manufacturing Excellence',
                                    'cost' => 'Cost Reduction',
                                    'other' => 'Other',
                                ];
                                foreach ($services as $val => $label):
                                ?>
                                <option value="<?php echo $val; ?>"<?php echo $form_values['service'] === $val ? ' selected' : ''; ?>><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="challenge">Biggest Operational Challenge *</label>
                            <textarea id="challenge" name="challenge" rows="4" placeholder="e.g. OTIF below 90%, chronic overtime, inventory rising with sales, quality escapes, capacity cliff in Q3…" required><?php echo htmlspecialchars($form_values['challenge']); ?></textarea>
                            <div class="error-message" id="challenge-error"><?php echo htmlspecialchars($form_errors['challenge'] ?? ''); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="message">Additional Details</label>
                            <textarea id="message" name="message" rows="4" placeholder="Sites involved, timeline pressure, systems in use, or anything else we should know…"><?php echo htmlspecialchars($form_values['message']); ?></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Request free assessment</span>
                                <span class="loading-spinner" style="display:none;">Sending…</span>
                            </button>
                            <p style="font-size: 0.9rem; color: #718096; margin-top: 15px;">We respect confidentiality. A principal consultant typically responds within one business day.</p>
                        </div>
                    </form>
                </div>

                <div>
                    <div class="info-card" style="margin-bottom: 30px;">
                        <h3>Contact Information</h3>
                        <p><strong>Contact Person:</strong> <?php echo htmlspecialchars($cfg->contact_person ?? ''); ?></p>
                        <p><strong>Direct Line:</strong> <a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? $cfg->contact_phone ?? ''); ?>"><?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a></p>
                        <p><strong>Contact:</strong> <a href="mailto:<?php echo htmlspecialchars($cfg->email_contact ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_contact ?? ''); ?></a></p>
                        <p><strong>General Inquiries:</strong> <a href="mailto:<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_info ?? ''); ?></a></p>
                        <p><strong>Sales:</strong> <a href="mailto:<?php echo htmlspecialchars($cfg->email_sales ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_sales ?? ''); ?></a></p>
                        <p><strong>Business Hours:</strong> <?php echo htmlspecialchars($cfg->business_hours ?? ''); ?></p>
                    </div>
                    <div class="info-card" style="margin-bottom: 30px;">
                        <h3>Office Address</h3>
                        <p><strong><?php echo htmlspecialchars($addr->company ?? ''); ?></strong></p>
                        <p><?php echo htmlspecialchars($addr->line1 ?? ''); ?></p>
                        <p><?php echo htmlspecialchars($addr->line2 ?? ''); ?></p>
                        <p><?php echo htmlspecialchars($addr->country ?? ''); ?></p>
                    </div>
                    <div class="info-card">
                        <h3>What happens next</h3>
                        <ol style="padding-left: 20px; margin-top: 15px;">
                            <li style="margin-bottom: 10px;"><strong>Confirmation:</strong> We acknowledge your request and propose times for a 60-minute working session.</li>
                            <li style="margin-bottom: 10px;"><strong>Assessment:</strong> A focused discussion on your constraint, data, and operating context.</li>
                            <li style="margin-bottom: 10px;"><strong>Written summary:</strong> You receive a short priority list and recommended next steps.</li>
                            <li><strong>Optional proposal:</strong> If there is a fit, we outline scope, timeline, and commercial terms—plainly.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div style="margin-top: 50px; padding: 40px; background: #f8fafc; border-radius: 8px;">
                <h2 style="text-align: center;">Where we work</h2>
                <p style="text-align: center; max-width: 800px; margin: 20px auto 30px;">Based in the NCR region with on-site delivery across India’s manufacturing and distribution hubs. We also support multi-site programmes that need one operating standard.</p>
                <div style="text-align: center; margin: 40px 0;">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                         alt="Industrial landscape representing GroEdge client regions"
                         style="max-width: 90%; height: auto; border-radius: 8px; border: 1px solid #e2e8f0;">
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; text-align: center; margin-top: 30px;">
                    <div><h3 style="color: #2c5282;">Pan-India</h3><p>On-site plant support</p></div>
                    <div><h3 style="color: #2c5282;">NCR hub</h3><p>Client access &amp; coordination</p></div>
                    <div><h3 style="color: #2c5282;">Multi-site</h3><p>Standards that travel</p></div>
                    <div><h3 style="color: #2c5282;">Hands-on</h3><p>Floor-led implementation</p></div>
                </div>
            </div>

            <div class="cta-section" style="margin-top: 50px;">
                <div style="margin-bottom: 25px;">
                    <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                         alt="Professional workspace for a client working session"
                         style="width: 100%; border-radius: 8px;">
                </div>
                <h2 style="color: white; text-align: center;">Every week of instability has a cost</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Expedites, overtime, scrap, and missed OTIF rarely fix themselves. Start with a clear read of the constraint—then decide how far to go.</p>
                <div style="text-align: center;">
                    <a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? preg_replace('/\D/', '', $cfg->contact_phone ?? '')); ?>" class="cta-button" style="background: white; color: #1a365d; margin-right: 15px;">Call <?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a>
                    <a href="mailto:<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>" class="cta-button" style="background: transparent; border: 2px solid white;">Email us</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <p style="margin-bottom: 10px;">&copy; 2026 GroEdge Management Consulting. All Rights Reserved.</p>
            <p style="font-size: 0.9rem; opacity: 0.8;">Clarity first. Then execution.</p>
        </div>
    </footer>

    <script src="script.js"></script>
    <script src="contact-script.js"></script>
</body>
</html>
