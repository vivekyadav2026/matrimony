<?php
$page_title = "Register Free & Upload Profile";
require_once __DIR__ . '/header.php';

$message_sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $gender = trim($_POST['gender'] ?? 'Female');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $age = (int)($_POST['age'] ?? 24);
    $caste = trim($_POST['caste'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $msg_text = trim($_POST['message'] ?? '');

    if ($name && $phone && $caste) {
        // Save to inquiries
        $ins = $pdo->prepare("INSERT INTO inquiries (name, email, phone, gender, message) VALUES (?, ?, ?, ?, ?)");
        $details = "Free Profile Registration Request: Age: $age, Caste: $caste, City: $city. Note: $msg_text";
        $ins->execute([$name, $email, $phone, $gender, $details]);
        $message_sent = true;
    } else {
        $error = "Please fill in all mandatory fields marked with (*).";
    }
}
?>

<div class="section" style="background-color: #f8fafc; padding: 40px 0;">
    <div class="container" style="max-width: 720px;">
        
        <div style="background: #ffffff; padding: 35px 30px; border-radius: 12px; box-shadow: 0 6px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            
            <div style="text-align: center; margin-bottom: 28px;">
                <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
                    <i class="fa fa-user-plus" style="color: var(--primary-red); margin-right: 6px;"></i> Free Candidate Registration
                </h2>
                <p style="color: #64748b; font-size: 14.5px; margin: 0;">Create your matrimony profile to connect with 100% verified Manglik matches.</p>
            </div>

            <?php if ($message_sent): ?>
                <div style="background-color: #f0fdf4; color: #166534; padding: 25px 20px; border-radius: 10px; border: 1px solid #bbf7d0; text-align: center;">
                    <i class="fa fa-check-circle" style="font-size: 45px; margin-bottom: 12px; color: #22c55e;"></i>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Registration Request Received!</h3>
                    <p style="font-size: 14.5px; color: #15803d; max-width: 500px; margin: 0 auto 18px; line-height: 1.6;">
                        Thank you <strong><?php echo htmlspecialchars($name); ?></strong>. Our matrimony desk will verify your details and activate your profile within 24 hours.
                    </p>
                    <a href="search.php" class="btn-red" style="padding: 10px 25px; font-size: 14.5px; border-radius: 20px; display: inline-block;">
                        <i class="fa fa-search"></i> Browse Matching Profiles
                    </a>
                </div>
            <?php else: ?>

                <?php if ($error): ?>
                    <div style="background-color: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 22px; border: 1px solid #fecaca; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-exclamation-circle" style="color: #dc2626; font-size: 16px;"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST" style="display: grid; gap: 18px;">
                    
                    <div class="form-group">
                        <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Candidate Full Name *</label>
                        <div style="position: relative;">
                            <i class="fa fa-user" style="position: absolute; left: 14px; top: 14px; color: #94a3b8;"></i>
                            <input type="text" name="name" required placeholder="Enter candidate full name" class="form-control" style="padding-left: 40px; background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Gender *</label>
                            <select name="gender" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px; font-weight: 500;">
                                <option value="Female">Female (Bride)</option>
                                <option value="Male">Male (Groom)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Age (Years) *</label>
                            <input type="number" name="age" value="25" min="18" max="70" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px; text-align: center;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Phone / Mobile Number *</label>
                            <div style="position: relative;">
                                <i class="fa fa-phone" style="position: absolute; left: 14px; top: 14px; color: #94a3b8;"></i>
                                <input type="text" name="phone" required placeholder="10-digit mobile number" class="form-control" style="padding-left: 40px; background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Email Address</label>
                            <div style="position: relative;">
                                <i class="fa fa-envelope" style="position: absolute; left: 14px; top: 14px; color: #94a3b8;"></i>
                                <input type="email" name="email" placeholder="email@example.com" class="form-control" style="padding-left: 40px; background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px;">
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Caste / Community *</label>
                            <input type="text" name="caste" required placeholder="e.g. Rajput, Brahmin, Punjabi" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px;">
                        </div>
                        <div class="form-group">
                            <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">City / Location</label>
                            <input type="text" name="city" placeholder="e.g. New Delhi, Mumbai" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 44px; border-radius: 6px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="color: #334155; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; display: block;">Education / Occupation / Partner Expectations</label>
                        <textarea name="message" rows="3" placeholder="Mention qualification, occupation, or specific partner expectations..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px; padding: 10px 12px;"></textarea>
                    </div>

                    <button type="submit" class="btn-red" style="padding: 13px; font-size: 16px; border-radius: 6px; font-weight: 700; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 5px;">
                        <i class="fa fa-paper-plane"></i> Submit Free Profile Request
                    </button>
                </form>

            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
