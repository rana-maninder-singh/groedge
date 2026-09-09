<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $industry = trim($_POST['industry'] ?? '');
    $employees = trim($_POST['employees'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $challenge = trim($_POST['challenge'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $submission = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'industry' => $industry,
        'employees' => $employees,
        'service' => $service,
        'challenge' => $challenge,
        'message' => $message
    ];
    save_submission($submission);

    $cfg = get_config();
    $to = $cfg->form_to_email ?? 'info@groedge.in';
    $bcc = $cfg->form_bcc ?? 'rajest@groedge.in, sales@groedge.in';
    $subject = "New Contact Form Submission from " . htmlspecialchars($name);
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nCompany: $company\n";
    $body .= "Industry: $industry\nCompany Size: $employees\nPrimary Interest: $service\n\n";
    $body .= "Biggest Operational Challenge:\n$challenge\n\n";
    if ($message) {
        $body .= "Additional Details:\n$message\n";
    }
    $headers = "From: $email\r\nBcc: $bcc";

    $mailOk = @mail($to, $subject, $body, $headers);
    header("Location: contact.php?status=" . ($mailOk ? "success" : "error"));
    exit;
}

$cfg = get_config();
$addr = $cfg->address ?? (object)['company' => '', 'line1' => '', 'line2' => '', 'country' => ''];
$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact GroEdge | Schedule Your Free Consultation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <meta name="description" content="Contact GroEdge for a free operational assessment. Schedule a consultation with our experts to transform your business processes.">
</head>
<body>
    <header>
        <div class="logo logo-dark">
            <a href="index.html"><img src="logo.png" alt="GroEdge" class="logo-img"></a>
            <h1>GROEDGE</h1>
            <p class="tagline">OPERATIONAL EXCELLENCE CONSULTANTS</p>
        </div>
        <h1>Start Your Transformation Journey</h1>
        <p>Schedule a free consultation with our experts. Let's discuss how we can drive measurable improvements in your operations.</p>
    </header>

    <nav>
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="services.php">Services</a>
        <a href="projects.php">Projects</a>
        <a href="contact.php">Contact</a>
    </nav>

    <div class="container">
        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
             alt="GroEdge consultants in a strategic planning session with a client"
             class="page-img"
             style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 40px;">

        <div class="section-content">
            <?php if ($status === 'success'): ?>
            <div class="form-status success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Thank you! Your request has been submitted. We'll contact you within 24 business hours.</div>
            <?php elseif ($status === 'error'): ?>
            <div class="form-status error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Your message was saved. There was a problem sending the email; we'll still get in touch.</div>
            <?php endif; ?>

            <div style="margin-bottom: 40px;">
                <h2>Your Time is Valuable. We Make Every Second Count.</h2>
                <p>Up to <strong>40% of a leader's time goes to managing backend operations and firefighting.</strong> Our consultation helps you reclaim this time by implementing efficient, scalable processes.</p>
                <div style="text-align: center; margin: 30px 0;">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Visualization of efficient workflow and data analysis"
                         style="max-width: 80%; height: auto; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;">
                    <div style="text-align: center; padding: 25px; background: #f8fafc;">
                        <h3 style="color: #2c5282;">Free Initial Assessment</h3>
                        <p>60-minute consultation to identify your top 3 improvement opportunities</p>
                    </div>
                    <div style="text-align: center; padding: 25px; background: #f8fafc;">
                        <h3 style="color: #2c5282;">No Obligation</h3>
                        <p>Explore possibilities without commitment. We provide clear value upfront.</p>
                    </div>
                    <div style="text-align: center; padding: 25px; background: #f8fafc;">
                        <h3 style="color: #2c5282;">Industry-Specific Insights</h3>
                        <p>Get recommendations tailored to your specific sector and challenges.</p>
                    </div>
                </div>
            </div>

            <div class="contact-info" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 50px;">
                <div class="form-section">
                    <h3>Schedule Your Free Consultation</h3>
                    <div style="margin-bottom: 30px;">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                             alt="A GroEdge consultant discussing a project plan with a business executive"
                             style="width: 100%; border-radius: 8px;">
                    </div>
                    <form id="contactForm" action="contact.php" method="post" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                            <div class="error-message" id="name-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Business Email *</label>
                            <input type="email" id="email" name="email" placeholder="name@company.com" required>
                            <div class="error-message" id="email-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" placeholder="<?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?>" required>
                            <div class="error-message" id="phone-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="company">Company Name *</label>
                            <input type="text" id="company" name="company" placeholder="Your company name" required>
                            <div class="error-message" id="company-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="industry">Industry *</label>
                            <select id="industry" name="industry" required>
                                <option value="">Select your industry</option>
                                <option value="manufacturing">Manufacturing</option>
                                <option value="pharmaceutical">Pharmaceuticals</option>
                                <option value="chemical">Chemicals</option>
                                <option value="engineering">Engineering</option>
                                <option value="textiles">Textiles & Garments</option>
                                <option value="logistics">Logistics & Supply Chain</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="error-message" id="industry-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="employees">Company Size</label>
                            <select id="employees" name="employees">
                                <option value="">Select number of employees</option>
                                <option value="1-50">1-50 Employees</option>
                                <option value="51-200">51-200 Employees</option>
                                <option value="201-500">201-500 Employees</option>
                                <option value="501-1000">501-1000 Employees</option>
                                <option value="1000+">1000+ Employees</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="service">Primary Interest</label>
                            <select id="service" name="service">
                                <option value="">Select area of interest</option>
                                <option value="process">Process Optimization</option>
                                <option value="digital">Digital Transformation</option>
                                <option value="supply">Supply Chain Management</option>
                                <option value="quality">Quality Systems (QMS)</option>
                                <option value="manufacturing">Manufacturing Excellence</option>
                                <option value="cost">Cost Reduction</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="challenge">Biggest Operational Challenge *</label>
                            <textarea id="challenge" name="challenge" rows="4" placeholder="Briefly describe your biggest operational challenge..." required></textarea>
                            <div class="error-message" id="challenge-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="message">Additional Details</label>
                            <textarea id="message" name="message" rows="4" placeholder="Any other details you'd like to share..."></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Schedule Free Consultation</span>
                                <span class="loading-spinner" style="display:none;">Scheduling...</span>
                            </button>
                            <p style="font-size: 0.9rem; color: #718096; margin-top: 15px;">By submitting this form, you agree to our Privacy Policy. We'll contact you within 24 business hours.</p>
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
                        <h3>What Happens Next?</h3>
                        <ol style="padding-left: 20px; margin-top: 15px;">
                            <li style="margin-bottom: 10px;"><strong>Confirmation Call:</strong> We'll call to confirm details and schedule your consultation.</li>
                            <li style="margin-bottom: 10px;"><strong>Free Consultation:</strong> 60-minute session with a senior consultant.</li>
                            <li style="margin-bottom: 10px;"><strong>Assessment Report:</strong> Receive a high-level analysis of your top improvement opportunities.</li>
                            <li><strong>Optional Proposal:</strong> If interested, we'll provide a detailed project proposal.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div style="margin-top: 50px; padding: 40px; background: #f8fafc; border-radius: 8px;">
                <h2 style="text-align: center;">Serving Businesses Across India & Globally</h2>
                <p style="text-align: center; max-width: 800px; margin: 20px auto 30px;">We've successfully delivered projects across 30+ states in India and have supported clients in the Middle East and Southeast Asia.</p>
                <div style="text-align: center; margin: 40px 0;">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                         alt="Global map highlighting GroEdge's service regions"
                         style="max-width: 90%; height: auto; border-radius: 8px; border: 1px solid #e2e8f0;">
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; text-align: center; margin-top: 30px;">
                    <div><h3 style="color: #2c5282;">30+</h3><p>States in India</p></div>
                    <div><h3 style="color: #2c5282;">5+</h3><p>Countries</p></div>
                    <div><h3 style="color: #2c5282;">200+</h3><p>Successful Clients</p></div>
                    <div><h3 style="color: #2c5282;">1M+</h3><p>Consulting Hours</p></div>
                </div>
            </div>

            <div class="cta-section" style="margin-top: 50px;">
                <div style="margin-bottom: 25px;">
                    <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                         alt="Team celebrating a successful project milestone"
                         style="width: 100%; border-radius: 8px;">
                </div>
                <h2 style="color: white; text-align: center;">Don't Let Inefficiency Cost You Another Day</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Every day of operational inefficiency costs your business revenue, growth opportunities, and competitive advantage. Start your transformation today.</p>
                <div style="text-align: center;">
                    <a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? preg_replace('/\D/', '', $cfg->contact_phone ?? '')); ?>" class="cta-button" style="background: white; color: #1a365d; margin-right: 15px;">📞 Call Now: <?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a>
                    <a href="mailto:<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>" class="cta-button" style="background: transparent; border: 2px solid white;">✉️ Email Us</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <p style="margin-bottom: 10px;">&copy; 2025 GroEdge Management Consulting. All Rights Reserved.</p>
            <p style="font-size: 0.9rem; opacity: 0.8;">Ready to Transform • Schedule Today • Drive Excellence</p>
        </div>
    </footer>

    <script src="script.js"></script>
    <script src="contact-script.js"></script>
</body>
</html>
