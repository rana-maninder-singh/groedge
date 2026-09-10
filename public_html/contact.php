<?php
define('DATA_DIR', __DIR__ . '/data');
require_once __DIR__ . '/includes/config.php';

$page_title = 'Contact GroEdge | Book a Free Operational Assessment';
$page_description = 'Schedule a complimentary 60-minute operational assessment with GroEdge. Identify your top constraints in cost, quality, capacity, or delivery.';
$current_page = 'contact';
$base_path = '';

$form_values = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'industry' => '',
    'employees' => '',
    'challenge' => ''
];
$form_errors = [];
$status = $_GET['status'] ?? '';
$subject_prefill = $_GET['subject'] ?? '';
if ($subject_prefill !== '' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $form_values['challenge'] = $subject_prefill;
}

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
    if (strlen($form_values['company']) < 2) {
        $form_errors['company'] = 'Company name is required.';
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

            $body = "Name: {$form_values['name']}\nEmail: {$form_values['email']}\n";
            if ($form_values['phone'] !== '') $body .= "Phone: {$form_values['phone']}\n";
            $body .= "Company: {$form_values['company']}\n";
            if ($form_values['industry'] !== '') $body .= "Industry: {$form_values['industry']}\n";
            if ($form_values['employees'] !== '') $body .= "Company Size: {$form_values['employees']}\n";
            $body .= "\nBiggest Operational Challenge:\n{$form_values['challenge']}\n";

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

require_once __DIR__ . '/includes/header.php';
?>

    <section class="page-banner" style="background: linear-gradient(135deg, #1a365d 0%, #2c5282 50%, #4299e1 100%); padding: 60px 20px; text-align: center; color: white;">
        <div class="page-banner-inner">
            <h1 style="font-size: 2.2rem; margin-bottom: 12px;">Let's fix what's slowing your operations</h1>
            <p style="max-width: 650px; margin: 0 auto; font-size: 1.05rem; opacity: 0.9;">Share your biggest constraint. We will respond within one business day with a proposed assessment agenda — focused on outcomes, not a sales pitch.</p>
        </div>
    </section>

    <div class="container">
        <div class="section-content">
            <?php if ($status === 'success'): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Thank you. Your request is with our team. We will contact you within one business day.</div>
            <?php elseif ($status === 'error'): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Your details were saved. Email delivery had a problem on our side — we will still follow up directly.</div>
            <?php elseif ($status === 'save_error'): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">We could not save your request online. Please email info@groedge.in or call us.</div>
            <?php elseif (!empty($form_errors)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px;">Please correct the highlighted fields and submit again.</div>
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0 40px;">
                <div style="text-align: center; padding: 25px; background: #f8fafc; border-radius: 8px;">
                    <h3 style="color: #2c5282; margin-bottom: 8px;">60-minute assessment</h3>
                    <p style="color: #4a5568;">Clarify your top constraints and a practical shortlist of next moves.</p>
                </div>
                <div style="text-align: center; padding: 25px; background: #f8fafc; border-radius: 8px;">
                    <h3 style="color: #2c5282; margin-bottom: 8px;">No obligation</h3>
                    <p style="color: #4a5568;">Useful whether or not you engage us further. You leave with clarity.</p>
                </div>
                <div style="text-align: center; padding: 25px; background: #f8fafc; border-radius: 8px;">
                    <h3 style="color: #2c5282; margin-bottom: 8px;">Sector-aware advice</h3>
                    <p style="color: #4a5568;">Guidance grounded in manufacturing, pharma, chemicals, and logistics realities.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 50px;">
                <div>
                    <h3 style="color: #1a365d; margin-bottom: 20px;">Request your free assessment</h3>
                    <form id="contactForm" action="contact.php" method="post">
                        <div style="margin-bottom: 16px;">
                            <label for="name" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Full Name *</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($form_values['name']); ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
                            <?php if (!empty($form_errors['name'])): ?><div style="color: #c53030; font-size: 0.85rem; margin-top: 4px;"><?php echo htmlspecialchars($form_errors['name']); ?></div><?php endif; ?>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label for="email" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Business Email *</label>
                            <input type="email" id="email" name="email" placeholder="name@company.com" value="<?php echo htmlspecialchars($form_values['email']); ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
                            <?php if (!empty($form_errors['email'])): ?><div style="color: #c53030; font-size: 0.85rem; margin-top: 4px;"><?php echo htmlspecialchars($form_errors['email']); ?></div><?php endif; ?>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label for="company" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Company Name *</label>
                            <input type="text" id="company" name="company" placeholder="Your company name" value="<?php echo htmlspecialchars($form_values['company']); ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
                            <?php if (!empty($form_errors['company'])): ?><div style="color: #c53030; font-size: 0.85rem; margin-top: 4px;"><?php echo htmlspecialchars($form_errors['company']); ?></div><?php endif; ?>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label for="challenge" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Biggest Operational Challenge *</label>
                            <textarea id="challenge" name="challenge" rows="4" placeholder="e.g. OTIF below 90%, chronic overtime, inventory rising with sales, quality escapes..." required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; box-sizing: border-box;"><?php echo htmlspecialchars($form_values['challenge']); ?></textarea>
                            <?php if (!empty($form_errors['challenge'])): ?><div style="color: #c53030; font-size: 0.85rem; margin-top: 4px;"><?php echo htmlspecialchars($form_errors['challenge']); ?></div><?php endif; ?>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label for="phone" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+91 XXXXX XXXXX" value="<?php echo htmlspecialchars($form_values['phone']); ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                            <div>
                                <label for="industry" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Industry</label>
                                <select id="industry" name="industry" style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
                                    <option value="">Select industry</option>
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
                            </div>
                            <div>
                                <label for="employees" style="display: block; font-weight: 500; margin-bottom: 4px; color: #2d3748;">Company Size</label>
                                <select id="employees" name="employees" style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
                                    <option value="">Select size</option>
                                    <?php
                                    $sizes = ['1-50' => '1-50 Employees', '51-200' => '51-200 Employees', '201-500' => '201-500 Employees', '501-1000' => '501-1000 Employees', '1000+' => '1000+ Employees'];
                                    foreach ($sizes as $val => $label):
                                    ?>
                                    <option value="<?php echo htmlspecialchars($val); ?>"<?php echo $form_values['employees'] === $val ? ' selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top: 24px;">
                            <button type="submit" style="background: #2c5282; color: #fff; padding: 12px 28px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 1rem;">Request free assessment</button>
                            <p style="font-size: 0.85rem; color: #718096; margin-top: 10px;">We respect confidentiality. A principal consultant typically responds within one business day.</p>
                        </div>
                    </form>

                    <div style="margin-top: 30px; padding: 20px; background: #f0fff4; border: 1px solid #c6f6d5; border-radius: 8px; text-align: center;">
                        <h4 style="color: #276749; margin-bottom: 8px;">Prefer to chat on WhatsApp?</h4>
                        <a href="https://wa.me/<?php echo htmlspecialchars($cfg->contact_phone_raw ?? preg_replace('/\D/', '', $cfg->contact_phone ?? '')); ?>" target="_blank" rel="noopener" style="display: inline-block; background: #25d366; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600;">Chat on WhatsApp</a>
                    </div>
                </div>

                <div>
                    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <h3 style="color: #1a365d; margin-bottom: 15px;">Contact Information</h3>
                        <p style="margin-bottom: 8px;"><strong>Contact Person:</strong> <?php echo htmlspecialchars($cfg->contact_person ?? ''); ?></p>
                        <p style="margin-bottom: 8px;"><strong>Direct Line:</strong> <a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? $cfg->contact_phone ?? ''); ?>"><?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a></p>
                        <p style="margin-bottom: 8px;"><strong>Contact:</strong> <a href="mailto:<?php echo htmlspecialchars($cfg->email_contact ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_contact ?? ''); ?></a></p>
                        <p style="margin-bottom: 8px;"><strong>General Inquiries:</strong> <a href="mailto:<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_info ?? ''); ?></a></p>
                        <p style="margin-bottom: 8px;"><strong>Sales:</strong> <a href="mailto:<?php echo htmlspecialchars($cfg->email_sales ?? ''); ?>"><?php echo htmlspecialchars($cfg->email_sales ?? ''); ?></a></p>
                        <p><strong>Business Hours:</strong> <?php echo htmlspecialchars($cfg->business_hours ?? ''); ?></p>
                    </div>

                    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <h3 style="color: #1a365d; margin-bottom: 15px;">Office Address</h3>
                        <p style="font-weight: 600;"><?php echo htmlspecialchars($addr->company ?? ''); ?></p>
                        <p><?php echo htmlspecialchars($addr->line1 ?? ''); ?></p>
                        <p><?php echo htmlspecialchars($addr->line2 ?? ''); ?></p>
                        <p><?php echo htmlspecialchars($addr->country ?? ''); ?></p>
                    </div>

                    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <h3 style="color: #1a365d; margin-bottom: 15px;">Prefer to talk? Call us</h3>
                        <a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? preg_replace('/\D/', '', $cfg->contact_phone ?? '')); ?>" style="display: inline-block; background: #2c5282; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600;">Call <?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a>
                    </div>

                    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <h3 style="color: #1a365d; margin-bottom: 15px;">Schedule a Call</h3>
                        <div id="calendly-embed" style="min-height: 400px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #718096; border: 2px dashed #cbd5e0;">
                            <p>Calendly scheduling widget will appear here.<br><small>Add your Calendly link to replace this placeholder.</small></p>
                        </div>
                    </div>

                    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3 style="color: #1a365d; margin-bottom: 15px;">What happens next</h3>
                        <ol style="padding-left: 20px; margin-top: 10px;">
                            <li style="margin-bottom: 10px;"><strong>Confirmation:</strong> We acknowledge your request and propose times for a 60-minute working session.</li>
                            <li style="margin-bottom: 10px;"><strong>Assessment:</strong> A focused discussion on your constraint, data, and operating context.</li>
                            <li style="margin-bottom: 10px;"><strong>Written summary:</strong> You receive a short priority list and recommended next steps.</li>
                            <li><strong>Optional proposal:</strong> If there is a fit, we outline scope, timeline, and commercial terms — plainly.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="cta-section" style="margin-top: 50px;">
                <h2 style="color: white; text-align: center;">Every week of instability has a cost</h2>
                <p style="color: rgba(255,255,255,0.9); text-align: center; max-width: 700px; margin: 20px auto 30px;">Expedites, overtime, scrap, and missed OTIF rarely fix themselves. Start with a clear read of the constraint — then decide how far to go.</p>
                <div style="text-align: center;">
                    <a href="tel:<?php echo htmlspecialchars($cfg->contact_phone_raw ?? preg_replace('/\D/', '', $cfg->contact_phone ?? '')); ?>" class="cta-button" style="background: white; color: #1a365d; margin-right: 15px;">Call <?php echo htmlspecialchars($cfg->contact_phone ?? ''); ?></a>
                    <a href="mailto:<?php echo htmlspecialchars($cfg->email_info ?? ''); ?>" class="cta-button" style="background: transparent; border: 2px solid white;">Email us</a>
                </div>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
