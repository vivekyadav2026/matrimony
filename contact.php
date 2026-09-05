<?php
$page_title = "Contact Us & Assistance Helpline";
require_once __DIR__ . '/header.php';

$success_msg = '';
$wa_url = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? 'General Inquiry');
    $message = trim($_POST['message'] ?? '');

    if ($name && $phone && $message) {
        $ins = $pdo->prepare("INSERT INTO inquiries (name, email, phone, gender, message) VALUES (?, ?, ?, ?, ?)");
        $details = "[$subject] " . $message;
        $ins->execute([$name, $email, $phone, 'N/A', $details]);

        $wa_msg = "Hello Sain Matrimony Desk,\n\n"
            . "📩 *NEW WEBSITE CONTACT INQUIRY*\n"
            . "-----------------------------------\n"
            . "*Name:* " . $name . "\n"
            . "*Mobile:* " . $phone . "\n"
            . "*Email:* " . ($email ?: 'N/A') . "\n"
            . "*Subject:* " . $subject . "\n"
            . "*Message:* " . $message;

        $wa_url = build_whatsapp_link($wa_msg);
        $success_msg = "Thank you! Your message has been saved. Opening WhatsApp to send details directly to Sain Matrimony Desk...";
    }
}
?>

<!-- Hero Header Banner -->
<div class="contact-hero-banner">
    <div class="container">
        <div class="contact-pill-tag"><i class="fa fa-phone"></i> GET IN TOUCH</div>
        <h1 class="contact-hero-title">Ready to Submit <span>Your Biodata?</span></h1>
        <p class="contact-hero-subtitle">
            Fill out the biodata form on our website, or message us on WhatsApp. We will guide you through the process and add you to our community groups.
        </p>
    </div>
</div>

<div class="section" style="background-color: #fcfcfc; padding: 45px 0 60px;">
    <div class="container" style="max-width: 960px;">
        
        <?php if ($success_msg): ?>
            <div style="background-color: #f0fdf4; color: #166534; padding: 18px 20px; border-radius: 12px; margin-bottom: 35px; border: 1px solid #bbf7d0; font-size: 15px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: <?php echo $wa_url ? '12px' : '0'; ?>;">
                    <i class="fa fa-check-circle" style="font-size: 24px; color: #22c55e;"></i>
                    <span><?php echo $success_msg; ?></span>
                </div>
                <?php if ($wa_url): ?>
                    <div style="margin-top: 10px;">
                        <a href="<?php echo $wa_url; ?>" target="_blank" class="btn-profile-wa" style="display: inline-flex; width: auto; padding: 10px 20px; font-size: 14px; text-decoration: none; background: #25D366; color: #fff; border-radius: 8px; font-weight: 700;">
                            <i class="fab fa-whatsapp" style="font-size: 18px;"></i> Open WhatsApp Now to Notify Admin
                        </a>
                    </div>
                    <script>
                        setTimeout(function() {
                            window.open(<?php echo json_encode($wa_url); ?>, '_blank');
                        }, 500);
                    </script>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- 4 Top Contact Info Cards -->
        <div class="contact-cards-grid">
            
            <!-- WhatsApp -->
            <div class="contact-info-card">
                <div class="contact-card-icon whatsapp-bg">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h4>WhatsApp</h4>
                <p>Fastest way to reach us</p>
                <a href="<?php echo build_whatsapp_link('Hello SainMatrimony Team'); ?>" target="_blank" class="contact-link">+91 85286 00100</a>
            </div>

            <!-- Call Us -->
            <div class="contact-info-card">
                <div class="contact-card-icon red-bg">
                    <i class="fa fa-phone-alt"></i>
                </div>
                <h4>Call Us</h4>
                <p>Speak with our team</p>
                <a href="tel:+918528600100" class="contact-link">+91 85286 00100</a>
            </div>

            <!-- Email -->
            <div class="contact-info-card">
                <div class="contact-card-icon red-bg">
                    <i class="fa fa-envelope"></i>
                </div>
                <h4>Email</h4>
                <p>For detailed inquiries</p>
                <a href="mailto:support@sainmatrimony.in" class="contact-link">support@sainmatrimony.in</a>
            </div>

            <!-- Location -->
            <div class="contact-info-card">
                <div class="contact-card-icon red-bg">
                    <i class="fa fa-map-marker-alt"></i>
                </div>
                <h4>Location</h4>
                <p>Serving families across</p>
                <div class="contact-link" style="color: #1e293b;">Punjab & All India</div>
            </div>

        </div>

        <!-- Assistance Helpline Wide Card -->
        <div class="helpline-wide-card">
            <div class="helpline-icon-circle">
                <i class="fa fa-headset"></i>
            </div>
            <h3 class="helpline-title">Assistance Helpline</h3>
            <p class="helpline-subtitle">
                Need help assembling biodata, uploading a profile, or connecting with a family? Contact our WhatsApp helpline team.
            </p>
            <div class="helpline-time">
                <i class="fa fa-clock" style="color: var(--primary-red);"></i> Mon - Sun: 9:00 AM - 9:00 PM IST
            </div>
            <div class="contact-btn-group">
                <a href="tel:+918528600100" class="btn-red" style="padding: 12px 28px; font-size: 15px;"><i class="fa fa-phone-alt"></i> Call +91 85286 00100</a>
                <a href="<?php echo build_whatsapp_link('Hello SainMatrimony Helpline'); ?>" target="_blank" class="btn-outline" style="color: #25D366 !important; border-color: #25D366; padding: 12px 28px; font-size: 15px;"><i class="fab fa-whatsapp"></i> WhatsApp Helpline</a>
            </div>
        </div>

        <!-- We Are Here to Help Action Card -->
        <div class="help-action-card">
            <div class="help-icon-circle">
                <i class="fa fa-comment-dots"></i>
            </div>
            <h3 class="helpline-title">We Are Here to Help</h3>
            <p class="helpline-subtitle">
                Submit your biodata online for the fastest response, or message us on WhatsApp and our team will guide you through the process.
            </p>
            <div class="contact-btn-group" style="margin-top: 20px;">
                <a href="register.php" class="btn-red" style="padding: 12px 28px; font-size: 15px;"><i class="fa fa-paper-plane"></i> Submit Biodata</a>
                <a href="<?php echo build_whatsapp_link('Hello I want to submit my biodata'); ?>" target="_blank" class="btn-outline" style="color: #475569 !important; border-color: #cbd5e1; padding: 12px 28px; font-size: 15px;"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
            </div>
        </div>

        <!-- FAQ Accordion Section -->
        <div class="section-tag-centered">
            <span class="pill-tag">FAQ</span>
            <h2>Common Questions</h2>
        </div>

        <div class="faq-accordion-list">
            
            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> Is this service free?</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes! Registering and browsing candidate profiles on SainMatrimony.in is free. We connect families across Sain and Nai Samaj with verified matrimonial profiles.
                </div>
            </div>

            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> How do I join the community?</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    You can join by clicking <strong>Submit Biodata</strong> to fill out our online multi-step registration form, or simply send your candidate biodata PDF/Image directly to our admin WhatsApp desk.
                </div>
            </div>

            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> How long does approval take?</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    Our admin verification team reviews new profiles within 2 to 4 hours. Once verified, your candidate profile goes live on our search portal.
                </div>
            </div>

            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> Can I update my biodata later?</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    Yes, absolutely. You can contact our support helpline on WhatsApp anytime to update photo, education, occupation, or family details.
                </div>
            </div>

            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> Who can see my biodata?</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    Your personal contact numbers and private family address are protected. Only verified families who request contact permissions are granted access by our admin team.
                </div>
            </div>

            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> How do I browse profiles?</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    Visit our <a href="search.php" style="color: var(--primary-red); font-weight: 700;">Search Profiles</a> page to filter candidate profiles by Age, Gender, Education, City, and State.
                </div>
            </div>

        </div>

        <!-- Privacy & Guidelines Accordion Section -->
        <div class="section-tag-centered" style="margin-top: 60px;">
            <span class="pill-tag">POLICIES</span>
            <h2>Privacy & Guidelines</h2>
        </div>

        <div class="faq-accordion-list" style="margin-bottom: 60px;">
            
            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> Privacy Policy</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    We respect candidate privacy. All submitted information is strictly used for matrimonial matchmaking. We do not sell or display contact numbers publicly on open pages.
                </div>
            </div>

            <div class="faq-accordion-item">
                <div class="faq-question">
                    <div class="faq-question-text"><span class="faq-dot"></span> Community Guidelines</div>
                    <i class="fa fa-chevron-down faq-toggle-icon"></i>
                </div>
                <div class="faq-answer">
                    Members must submit genuine candidate details. Misrepresentation of age, marital status, or educational qualifications will lead to immediate profile removal.
                </div>
            </div>

        </div>

        <!-- Direct Web Message Form Card -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 35px 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 6px; text-align: center;"><i class="fa fa-envelope" style="color: var(--primary-red);"></i> Send Us a Direct Web Message</h3>
            <p style="font-size: 13.5px; color: #64748b; margin-bottom: 25px; text-align: center;">Prefer sending an email inquiry? Fill in your details below and our team will reply within 24 hours.</p>

            <form action="contact.php" method="POST" style="display: grid; gap: 16px; max-width: 650px; margin: 0 auto;">
                <div>
                    <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Your Full Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Ramesh Sain" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Mobile Number *</label>
                        <input type="text" name="phone" required placeholder="10-digit mobile" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
                    </div>
                    <div>
                        <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Email Address</label>
                        <input type="email" name="email" placeholder="email@example.com" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
                    </div>
                </div>

                <div>
                    <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Subject</label>
                    <select name="subject" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
                        <option value="General Inquiry">General Inquiry</option>
                        <option value="Profile Verification">Profile Verification</option>
                        <option value="Membership Package">Membership & Verification</option>
                        <option value="Assisted Matchmaking">Assisted Matchmaking Support</option>
                    </select>
                </div>

                <div>
                    <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Your Message / Query *</label>
                    <textarea name="message" rows="3" required placeholder="Type your message here..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px 12px; font-size: 13.5px;"></textarea>
                </div>

                <button type="submit" name="submit_contact" class="btn-red" style="padding: 12px; font-size: 15px; border-radius: 6px; font-weight: 700; width: 100%; text-transform: uppercase;">
                    <i class="fa fa-paper-plane"></i> Send Web Inquiry
                </button>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(q => {
        q.addEventListener('click', function() {
            const item = this.parentElement;
            item.classList.toggle('active');
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>

