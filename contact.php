<?php
$page_title = "Contact Us - Sain & Nai Matrimony Desk";
require_once __DIR__ . '/header.php';

$success_msg = '';
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
        $success_msg = "Thank you! Your message has been sent to Sain Matrimony Desk. We will get back to you within 24 hours.";
    }
}
?>

<!-- Page Banner -->
<div style="background: linear-gradient(180deg, var(--dark-navy) 0%, #0d121a 100%); color: #fff; padding: 45px 20px 40px; text-align: center;">
    <div class="container">
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 38px; font-weight: 800; margin-bottom: 8px;">Contact Support & Help Desk</h1>
        <p style="color: #cbd5e1; font-size: 15px;">We are here to assist you in finding the right matrimonial match</p>
    </div>
</div>

<div class="section" style="background-color: #f8fafc; padding: 50px 0;">
    <div class="container" style="max-width: 950px;">
        
        <?php if ($success_msg): ?>
            <div style="background-color: #f0fdf4; color: #166534; padding: 18px 20px; border-radius: 10px; margin-bottom: 30px; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 12px; font-size: 15px;">
                <i class="fa fa-check-circle" style="font-size: 24px; color: #22c55e;"></i> <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1.4fr; gap: 35px; background: #ffffff; border-radius: 16px; box-shadow: 0 6px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden;">
            
            <!-- Contact Info Side -->
            <div style="background: linear-gradient(180deg, var(--dark-navy) 0%, #151d2a 100%); padding: 40px 30px; color: #ffffff; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: 700; margin-bottom: 12px; color: var(--secondary-gold);">Get in Touch</h3>
                    <p style="color: #cbd5e1; font-size: 13.5px; line-height: 1.6; margin-bottom: 30px;">
                        Have questions about candidate verification, membership plans, or horoscope matching? Feel free to write to us or call our helpline.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 20px; font-size: 14px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.1); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #94a3b8; font-weight: 500;">Helpline / WhatsApp</div>
                                <div style="font-weight: 700; color: #fff;">+91 98765 43210</div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.1); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #94a3b8; font-weight: 500;">Email Support</div>
                                <div style="font-weight: 700; color: #fff;">support@sainmatrimony.in</div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.1); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #94a3b8; font-weight: 500;">Office Address</div>
                                <div style="font-weight: 700; color: #fff;">New Delhi, India</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 30px;">
                    <div style="font-size: 12px; color: #94a3b8; margin-bottom: 8px;">Working Hours:</div>
                    <div style="font-size: 13px; font-weight: 600; color: #e2e8f0;">Monday – Saturday: 10:00 AM – 7:00 PM</div>
                </div>
            </div>

            <!-- Form Side -->
            <div style="padding: 40px 35px;">
                <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Send Us a Message</h3>
                <p style="font-size: 13.5px; color: #64748b; margin-bottom: 25px;">Fill out the form below and our matchmaking representative will get back to you.</p>

                <form action="contact.php" method="POST" style="display: grid; gap: 16px;">
                    <div>
                        <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Your Full Name *</label>
                        <input type="text" name="name" required placeholder="Enter your name" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
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
                            <option value="Membership Package">Membership & Membership Plans</option>
                            <option value="Kundli / Horoscope">Kundli & Astro Consultation</option>
                        </select>
                    </div>

                    <div>
                        <label style="color: #334155; font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Your Message / Query *</label>
                        <textarea name="message" rows="4" required placeholder="Type your message here..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px 12px; font-size: 13.5px;"></textarea>
                    </div>

                    <button type="submit" name="submit_contact" class="btn-red" style="padding: 12px; font-size: 15px; border-radius: 6px; font-weight: 700; width: 100%; text-transform: uppercase;">
                        <i class="fa fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
