<?php
require_once __DIR__ . '/config.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = ? AND status = 'active'");
$stmt->execute([$id]);
$profile = $stmt->fetch();

if (!$profile) {
    header("Location: search.php");
    exit;
}

$page_title = $profile['name'] . " (" . $profile['profile_id'] . ") - Manglik Profile";
require_once __DIR__ . '/header.php';

// Handle Contact Interest Form Submission
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_interest'])) {
    $sender_name = trim($_POST['name']);
    $sender_email = trim($_POST['email']);
    $sender_phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    if ($sender_name && $sender_phone) {
        $insInq = $pdo->prepare("INSERT INTO inquiries (name, email, phone, gender, message) VALUES (?, ?, ?, ?, ?)");
        $insInq->execute([$sender_name, $sender_email, $sender_phone, 'N/A', "Interest shown for Profile ID: " . $profile['profile_id'] . " (" . $profile['name'] . "). Note: " . $message]);
        $success_msg = "Your interest has been sent successfully! Our matchmaking team will contact you shortly.";
    }
}
?>

<div class="section" style="background-color: #f8fafc; padding: 40px 20px;">
    <div class="container" style="max-width: 950px;">
        
        <?php if ($success_msg): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
                <i class="fa fa-check-circle" style="font-size: 22px; color: #28a745;"></i> <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>

        <div style="background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; display: flex; flex-wrap: wrap;">
            
            <!-- Photo Side -->
            <div style="flex: 1; min-width: 320px; background: linear-gradient(180deg, var(--dark-navy) 0%, #0d121a 100%); position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px 20px;">
                <div style="width: 250px; height: 310px; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.4); position: relative; border: 3px solid rgba(255,255,255,0.15);">
                    <img src="images/<?php echo htmlspecialchars($profile['photo']); ?>" alt="<?php echo htmlspecialchars($profile['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php if ($profile['is_premium']): ?>
                        <span class="premium-tag"><i class="fa fa-crown"></i> PREMIUM</span>
                    <?php endif; ?>
                    <span class="verified-tag"><i class="fa fa-check-circle"></i> Verified</span>
                </div>
                <h3 style="color: #ffffff; margin-top: 18px; font-size: 22px; font-weight: 700; text-align: center;"><?php echo htmlspecialchars($profile['name']); ?></h3>
                <span style="color: var(--secondary-gold); font-weight: 600; font-size: 13.5px; margin-top: 2px;">Profile ID: <?php echo htmlspecialchars($profile['profile_id']); ?></span>
            </div>

            <!-- Details Side -->
            <div style="flex: 1.5; min-width: 320px; padding: 35px 30px;">
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: 800; border-bottom: 2px solid var(--primary-red); padding-bottom: 10px; margin-bottom: 20px; color: #0f172a;">
                    Personal Profile Details
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 14px; margin-bottom: 25px; color: #334155;">
                    <div><strong style="color: #0f172a;">Gender:</strong> <?php echo htmlspecialchars($profile['gender']); ?></div>
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && !empty($profile['mobile'])): ?>
                    <div><strong style="color: #0f172a;">Mobile:</strong> <?php echo htmlspecialchars($profile['mobile']); ?> (Admin Only)</div>
                    <?php endif; ?>
                    <div><strong style="color: #0f172a;">Age:</strong> <?php echo htmlspecialchars($profile['age']); ?> Years</div>
                    <div><strong style="color: #0f172a;">Religion:</strong> <?php echo htmlspecialchars($profile['religion']); ?></div>
                    <div><strong style="color: #0f172a;">Caste:</strong> <?php echo htmlspecialchars($profile['caste']); ?></div>
                    <div><strong style="color: #0f172a;">State:</strong> <?php echo htmlspecialchars($profile['state']); ?></div>
                    <div><strong style="color: #0f172a;">City:</strong> <?php echo htmlspecialchars($profile['city']); ?></div>
                    <div><strong style="color: #0f172a;">Education:</strong> <?php echo htmlspecialchars($profile['education']); ?></div>
                    <div><strong style="color: #0f172a;">Occupation:</strong> <?php echo htmlspecialchars($profile['occupation']); ?></div>
                </div>

                <div style="background: #fff8f8; border-left: 4px solid var(--primary-red); padding: 14px 16px; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
                    <h4 style="color: var(--primary-red); margin-bottom: 4px; font-size: 14.5px; font-weight: 700;"><i class="fa fa-shield-alt"></i> 100% Verified Profile</h4>
                    <p style="font-size: 12.5px; color: #475569; margin: 0; line-height: 1.5;">This candidate profile has been government ID & phone OTP verified for authentic matchmaking.</p>
                </div>

                <!-- Contact Interest Form -->
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 12px; color: #0f172a;">Express Interest & Contact Candidate Family</h4>
                <form action="profile.php?id=<?php echo $profile['id']; ?>" method="POST" style="display: grid; gap: 12px;">
                    <input type="text" name="name" placeholder="Your Full Name *" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <input type="email" name="email" placeholder="Your Email Address" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                        <input type="text" name="phone" placeholder="Your Mobile Number *" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                    </div>
                    <textarea name="message" rows="2" placeholder="Write a short introduction or message for candidate..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;"></textarea>
                    <button type="submit" name="submit_interest" class="btn-red" style="padding: 10px; font-size: 14.5px; border-radius: 6px;"><i class="fa fa-paper-plane"></i> Send Direct Express Interest</button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
