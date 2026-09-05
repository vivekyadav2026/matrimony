<?php
require_once __DIR__ . '/config.php';

$id = (int)($_GET['id'] ?? 0);
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true);

if ($is_admin) {
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = ? AND status = 'active'");
}
$stmt->execute([$id]);
$profile = $stmt->fetch();

if (!$profile) {
    header("Location: search.php");
    exit;
}

$page_title = $profile['name'] . " (" . $profile['profile_id'] . ") - Candidate Matrimonial Biodata";
require_once __DIR__ . '/header.php';
?>

<?php if (isset($_GET['approved'])): ?>
    <div style="background: #dcfce7; border-bottom: 2px solid #22c55e; padding: 14px 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 9999;">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <div style="color: #15803d; font-size: 14.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-check-circle" style="font-size: 20px; color: #22c55e;"></i>
                <span>Profile Approved Successfully! Candidate profile is now LIVE for all users on website.</span>
            </div>
            <a href="admin/profiles.php" style="color: #15803d; font-weight: 600; text-decoration: underline; font-size: 13px;">Go to Admin Panel →</a>
        </div>
    </div>
<?php endif; ?>

<?php if ($is_admin && $profile['status'] !== 'active'): ?>
    <div style="background: #fffbe6; border-bottom: 2px solid #f59e0b; padding: 14px 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 9999;">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <div style="color: #92400e; font-size: 14.5px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-exclamation-triangle" style="font-size: 18px; color: #f59e0b;"></i>
                <span>ADMIN PREVIEW: This profile is currently <strong>Pending Admin Approval (Inactive)</strong>. Review all candidate details below.</span>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="admin/profiles.php?action=approve&id=<?php echo $profile['id']; ?>&redirect=profile" class="btn-sm" style="background: #10b981; color: #ffffff; text-decoration: none; padding: 7px 16px; border-radius: 6px; font-weight: 700; font-size: 13.5px;" onclick="return confirm('Approve and publish this candidate profile live on website?');"><i class="fa fa-check"></i> Approve & Publish Profile</a>
                <a href="admin/edit-profile.php?id=<?php echo $profile['id']; ?>" class="btn-sm" style="background: #0284c7; color: #ffffff; text-decoration: none; padding: 7px 16px; border-radius: 6px; font-weight: 600; font-size: 13.5px;"><i class="fa fa-edit"></i> Edit Profile</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php

// Handle Contact Interest Form Submission
$success_msg = '';
$wa_url = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_interest'])) {
    $sender_name = trim($_POST['name'] ?? '');
    $sender_email = trim($_POST['email'] ?? '');
    $sender_phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($sender_name && $sender_phone) {
        $insInq = $pdo->prepare("INSERT INTO inquiries (name, email, phone, gender, message) VALUES (?, ?, ?, ?, ?)");
        $insInq->execute([
            $sender_name, 
            $sender_email, 
            $sender_phone, 
            'N/A', 
            "Express Interest for Candidate: " . $profile['name'] . " (" . $profile['profile_id'] . "). Note: " . $message
        ]);

        $wa_text = "Hello Sain Matrimony Desk,\n\n"
            . "👉 *EXPRESS INTEREST REQUEST*\n"
            . "-----------------------------------\n"
            . "*Candidate:* " . $profile['name'] . " (" . $profile['profile_id'] . ")\n"
            . "*Sender Name:* " . $sender_name . "\n"
            . "*Sender Mobile:* " . $sender_phone . "\n"
            . "*Sender Email:* " . ($sender_email ?: 'N/A') . "\n"
            . "*Note:* " . ($message ?: 'Interested in connecting') . "\n\n"
            . "Please arrange contact details and connect us.";

        $wa_url = build_whatsapp_link($wa_text);
        $success_msg = "Your express interest request for <strong>" . htmlspecialchars($profile['name']) . "</strong> has been saved! Opening WhatsApp to notify Sain Matrimony Desk...";
    }
}

// Fallback values for rich candidate display
$marital_status = !empty($profile['marital_status']) ? $profile['marital_status'] : 'Never Married';
$height = !empty($profile['height']) ? $profile['height'] : '5\'10"';
$weight = !empty($profile['weight']) ? $profile['weight'] : '';
$complexion = !empty($profile['complexion']) ? $profile['complexion'] : '';
$diet = !empty($profile['diet']) ? $profile['diet'] : '';
$manglik = !empty($profile['manglik']) ? $profile['manglik'] : 'ਨਹੀਂ';
$mother_tongue = !empty($profile['mother_tongue']) ? $profile['mother_tongue'] : 'Punjabi';

$time_of_birth = !empty($profile['time_of_birth']) ? $profile['time_of_birth'] : '';
$place_of_birth = !empty($profile['place_of_birth']) ? $profile['place_of_birth'] : '';
$father_name = !empty($profile['father_name']) ? $profile['father_name'] : '';
$mother_name = !empty($profile['mother_name']) ? $profile['mother_name'] : '';
$family_gotra = !empty($profile['family_gotra']) ? $profile['family_gotra'] : '';
$mother_gotra = !empty($profile['mother_gotra']) ? $profile['mother_gotra'] : '';
$district = !empty($profile['district']) ? $profile['district'] : $profile['city'];
$tehsil_post = !empty($profile['tehsil_post']) ? $profile['tehsil_post'] : '';
$manglik_required = !empty($profile['manglik_required']) ? $profile['manglik_required'] : 'ਹਾਂ';
$note = !empty($profile['note']) ? $profile['note'] : '';

$education_detail = !empty($profile['education_detail']) ? $profile['education_detail'] : '';
$organization = !empty($profile['organization']) ? $profile['organization'] : '';
$income = !empty($profile['income']) ? $profile['income'] : '';
$work_location = !empty($profile['work_location']) ? $profile['work_location'] : ($district . ', Punjab');

$sub_caste = !empty($profile['sub_caste']) ? $profile['sub_caste'] : '';
$gotra = !empty($profile['gotra']) ? $profile['gotra'] : '';
$father_occ = !empty($profile['father_occ']) ? $profile['father_occ'] : '';
$mother_occ = !empty($profile['mother_occ']) ? $profile['mother_occ'] : '';
$siblings = !empty($profile['siblings']) ? $profile['siblings'] : '';
$family_type = !empty($profile['family_type']) ? $profile['family_type'] : '';
$family_values = !empty($profile['family_values']) ? $profile['family_values'] : '';

$partner_age = !empty($profile['partner_age']) ? $profile['partner_age'] : '';
$partner_education = !empty($profile['partner_education']) ? $profile['partner_education'] : '';
$partner_location = !empty($profile['partner_location']) ? $profile['partner_location'] : '';
$partner_notes = !empty($profile['partner_notes']) ? $profile['partner_notes'] : '';

// Photo file path check
$photo_path = get_profile_photo_url($profile['photo'], false);
?>

<div class="profile-page-section">
    <div class="profile-page-container">
        
        <!-- Back Navigation Link -->
        <a href="search.php" class="profile-back-link">
            <i class="fa fa-arrow-left"></i> Back to Profiles
        </a>

        <?php if ($success_msg): ?>
            <div style="background-color: #dcfce7; color: #166534; padding: 18px 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #bbf7d0; font-size: 14.5px;">
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

        <!-- Main Profile Hero Header Card -->
        <div class="profile-hero-card">
            
            <div class="profile-hero-top">
                <!-- Avatar Image -->
                <div class="profile-avatar-wrapper">
                    <img src="<?php echo $photo_path; ?>" alt="<?php echo htmlspecialchars($profile['name']); ?>" class="profile-avatar-img" onerror="this.src='images/shlini.jpg';">
                    <div class="profile-verified-badge" title="Verified Candidate Profile">
                        <i class="fa fa-check"></i>
                    </div>
                </div>

                <!-- Info Header -->
                <div class="profile-hero-info">
                    <span class="profile-id-tag">Profile ID: <?php echo htmlspecialchars($profile['profile_id']); ?></span>
                    <h1 class="profile-name-heading"><?php echo htmlspecialchars($profile['name']); ?></h1>
                    
                    <!-- Attribute Pills -->
                    <div class="profile-pills-row">
                        <span class="profile-pill-item"><i class="fa fa-camera"></i> 1</span>
                        <span class="profile-pill-item">Dadke Gotra: <?php echo htmlspecialchars($gotra ?: ($family_gotra ?: 'N/A')); ?></span>
                        <span class="profile-pill-item">Nanke Gotra: <?php echo htmlspecialchars($mother_gotra ?: 'N/A'); ?></span>
                        <span class="profile-pill-item"><i class="fa fa-briefcase"></i> <?php echo htmlspecialchars($profile['occupation']); ?></span>
                    </div>

                    <!-- Key Stats Summary -->
                    <div class="profile-stats-grid">
                        <div class="profile-stat-box">
                            <span class="profile-stat-label">AGE</span>
                            <span class="profile-stat-value"><?php echo htmlspecialchars($profile['age']); ?> Years</span>
                        </div>
                        <div class="profile-stat-box">
                            <span class="profile-stat-label">HEIGHT</span>
                            <span class="profile-stat-value"><?php echo htmlspecialchars($height); ?></span>
                        </div>
                        <div class="profile-stat-box">
                            <span class="profile-stat-label">LOCATION</span>
                            <span class="profile-stat-value"><?php echo htmlspecialchars($profile['city']); ?>, <?php echo htmlspecialchars($profile['state']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy Alert Banner -->
            <div class="profile-privacy-banner">
                <i class="fa fa-lock"></i>
                <div>
                    Member contact details stay private. Request an Introduction via WhatsApp — we share numbers only on mutual interest.
                </div>
            </div>

            <!-- Action Buttons Grid -->
            <div class="profile-actions-bar">
                <?php 
                    $wa_direct_msg = "Hello Sain Matrimony Desk / ਸਤਿ ਸ਼੍ਰੀ ਅਕਾਲ,\n\n"
                        . "👉 *EXPRESS INTEREST / ਰਿਸ਼ਤੇ ਲਈ ਸੁਨੇਹਾ*\n"
                        . "-----------------------------------\n"
                        . "*Candidate / ਉਮੀਦਵਾਰ:* " . $profile['name'] . " (" . $profile['profile_id'] . ")\n"
                        . "*Age / ਉਮਰ:* " . $profile['age'] . " Yrs | *Caste / ਜਾਤ:* " . $profile['caste'] . "\n"
                        . "*Location / ਸ਼ਹਿਰ:* " . $profile['city'] . ", " . $profile['state'] . "\n"
                        . "*Education / ਪੜ੍ਹਾਈ:* " . ($profile['education'] ?: 'Graduate') . "\n"
                        . "*Occupation / ਕੰਮ:* " . ($profile['occupation'] ?: 'Professional') . "\n\n"
                        . "Please share contact details and connect us with this candidate's family.\n"
                        . "ਕਿਰਪਾ ਕਰਕੇ ਇਸ ਉਮੀਦਵਾਰ ਦੇ ਪਰਿਵਾਰ ਨਾਲ ਸਾਡਾ ਸੰਪਰਕ ਕਰਵਾਓ।";
                    $wa_direct_url = build_whatsapp_link($wa_direct_msg);
                ?>
                <a href="<?php echo $wa_direct_url; ?>" target="_blank" class="btn-profile-interest">
                    <i class="fa fa-paper-plane"></i> Send Interest
                </a>

                <a href="<?php echo $wa_direct_url; ?>" target="_blank" class="btn-profile-connect">
                    <i class="fa fa-address-book"></i> Request Contact
                </a>

                <a href="<?php echo $wa_direct_url; ?>" target="_blank" class="btn-profile-wa">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
            </div>

            <div class="profile-actions-share-row">
                <button type="button" class="btn-profile-share" onclick="shareProfile()">
                    <i class="fa fa-share-alt"></i> Share Candidate Profile
                </button>
            </div>

        </div>

        <!-- 4 Detailed Section Cards (2x2 Grid) -->
        <div class="profile-grid-2x2">
            
            <!-- CARD 1: PERSONAL DETAILS -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <i class="fa fa-user-circle"></i> Personal Details
                </div>
                <div class="profile-fields-list">
                    
                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-heart"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">MARITAL STATUS</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($marital_status); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-venus-mars"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">GENDER</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($profile['gender']); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-smile"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">COMPLEXION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($complexion); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-ruler-vertical"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">HEIGHT</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($height); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-weight"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">WEIGHT</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($weight); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-utensils"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">DIET</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($diet); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-sun"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">MANGLIK</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($manglik); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-map-marker-alt"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">BIRTH PLACE</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($profile['city']); ?>, <?php echo htmlspecialchars($profile['state']); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-language"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">MOTHER TONGUE</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($mother_tongue); ?></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CARD 2: CAREER DETAILS -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <i class="fa fa-briefcase"></i> Career Details
                </div>
                <div class="profile-fields-list">
                    
                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-graduation-cap"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">EDUCATION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($profile['education']); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-university"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">EDUCATION DETAIL</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($education_detail); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-laptop-code"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">PROFESSION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($profile['occupation']); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-building"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">OCCUPATION</div>
                            <div class="profile-field-val">Working</div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-user-tie"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">OCCUPATION DETAIL</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($organization); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-wallet"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">ANNUAL INCOME</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($income); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-globe"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">WORK LOCATION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($work_location); ?></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CARD 3: FAMILY DETAILS -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <i class="fa fa-home"></i> Family Details
                </div>
                <div class="profile-fields-list">
                    
                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-users"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">COMMUNITY</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($profile['caste']); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-bookmark"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">DADKE GOTRA (ਪਿਤਾ ਦਾ ਗੋਤ)</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($gotra ?: ($family_gotra ?: 'N/A')); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-hand-holding-heart"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">NANKE GOTRA (ਮਾਤਾ ਦਾ ਗੋਤ)</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($mother_gotra ?: 'N/A'); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-user-shield"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">FATHER'S OCCUPATION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($father_occ); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-female"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">MOTHER'S OCCUPATION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($mother_occ); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-user-friends"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">SIBLINGS</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($siblings); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-home"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">FAMILY TYPE</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($family_type); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-city"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">NATIVE PLACE</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($profile['city']); ?>, <?php echo htmlspecialchars($profile['state']); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-heart"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">FAMILY VALUES</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($family_values); ?></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CARD 4: PARTNER PREFERENCES -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <i class="fa fa-heart"></i> Partner Preferences
                </div>
                <div class="profile-fields-list">
                    
                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-search"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">LOOKING FOR</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($partner_notes); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-calendar-alt"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">PREFERRED AGE</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($partner_age); ?> Yrs</div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-graduation-cap"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">PREFERRED EDUCATION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($partner_education); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-map-marker-alt"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">PREFERRED LOCATION</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($partner_location); ?></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Footer note -->
        <div class="profile-footer-note">
            Posted: <?php echo date('d M Y', strtotime($profile['created_at'])); ?> — Contact details shared only with mutual interest.
        </div>

    </div>
</div>

<script>
function shareProfile() {
    if (navigator.share) {
        navigator.share({
            title: '<?php echo htmlspecialchars($profile['name']); ?> - Matrimonial Profile',
            text: 'Check out <?php echo htmlspecialchars($profile['name']); ?>\'s Matrimonial Biodata on Sainmatrimony.in',
            url: window.location.href
        }).catch(() => {});
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Profile link copied to clipboard!');
    }
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>

