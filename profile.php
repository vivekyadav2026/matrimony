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

$page_title = $profile['name'] . " (" . $profile['profile_id'] . ") - Candidate Matrimonial Biodata";
require_once __DIR__ . '/header.php';

// Handle Contact Interest Form Submission
$success_msg = '';
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
        $success_msg = "Your express interest request for " . htmlspecialchars($profile['name']) . " has been sent! Our desk team will contact you shortly.";
    }
}

// Fallback values for rich candidate display
$marital_status = !empty($profile['marital_status']) ? $profile['marital_status'] : 'Never Married';
$height = !empty($profile['height']) ? $profile['height'] : '5\'10" - 178 Cm';
$weight = !empty($profile['weight']) ? $profile['weight'] : '72 kg';
$complexion = !empty($profile['complexion']) ? $profile['complexion'] : 'Wheatish';
$diet = !empty($profile['diet']) ? $profile['diet'] : 'Veg / Non-Veg';
$manglik = !empty($profile['manglik']) ? $profile['manglik'] : 'Non-Manglik';
$mother_tongue = !empty($profile['mother_tongue']) ? $profile['mother_tongue'] : 'Punjabi';

$education_detail = !empty($profile['education_detail']) ? $profile['education_detail'] : 'B.Tech — Computer Science, PEC Chandigarh';
$organization = !empty($profile['organization']) ? $profile['organization'] : 'Tech Lead at an IT Services company';
$income = !empty($profile['income']) ? $profile['income'] : '15-22 LPA';
$work_location = !empty($profile['work_location']) ? $profile['work_location'] : ($profile['city'] . ' (Remote-friendly)');

$sub_caste = !empty($profile['sub_caste']) ? $profile['sub_caste'] : 'Sandhu';
$gotra = !empty($profile['gotra']) ? $profile['gotra'] : 'Gill';
$father_occ = !empty($profile['father_occ']) ? $profile['father_occ'] : 'Retired Government Officer';
$mother_occ = !empty($profile['mother_occ']) ? $profile['mother_occ'] : 'Homemaker';
$siblings = !empty($profile['siblings']) ? $profile['siblings'] : '1 Sister (Married)';
$family_type = !empty($profile['family_type']) ? $profile['family_type'] : 'Nuclear Family';
$family_values = !empty($profile['family_values']) ? $profile['family_values'] : 'Education focused, respectful Sikh/Hindu family';

$partner_age = !empty($profile['partner_age']) ? $profile['partner_age'] : '24 - 30';
$partner_education = !empty($profile['partner_education']) ? $profile['partner_education'] : 'Graduate / Masters';
$partner_location = !empty($profile['partner_location']) ? $profile['partner_location'] : ($profile['state'] ? $profile['state'] : 'Punjab');
$partner_notes = !empty($profile['partner_notes']) ? $profile['partner_notes'] : 'Educated, caring, family-oriented partner, based in ' . ($profile['state'] ? $profile['state'] : 'Punjab');

// Photo file path check
$photo_path = 'images/' . htmlspecialchars($profile['photo']);
if (!file_exists(__DIR__ . '/' . $photo_path) && file_exists(__DIR__ . '/uploads/' . htmlspecialchars($profile['photo']))) {
    $photo_path = 'uploads/' . htmlspecialchars($profile['photo']);
}
?>

<div class="profile-page-section">
    <div class="profile-page-container">
        
        <!-- Back Navigation Link -->
        <a href="search.php" class="profile-back-link">
            <i class="fa fa-arrow-left"></i> Back to Profiles
        </a>

        <?php if ($success_msg): ?>
            <div style="background-color: #dcfce7; color: #166534; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 12px; font-size: 14.5px;">
                <i class="fa fa-check-circle" style="font-size: 24px; color: #22c55e;"></i> <?php echo htmlspecialchars($success_msg); ?>
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
                        <span class="profile-pill-item"><i class="fa fa-user"></i> <?php echo htmlspecialchars($sub_caste); ?></span>
                        <span class="profile-pill-item">Gotra: <?php echo htmlspecialchars($gotra); ?></span>
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
                <button type="button" class="btn-profile-interest" onclick="toggleInterestModal()">
                    <i class="fa fa-paper-plane"></i> Send Interest
                </button>

                <button type="button" class="btn-profile-connect" onclick="toggleInterestModal()">
                    <i class="fa fa-address-book"></i> Request Contact
                </button>

                <?php 
                    $wa_text = rawurlencode("Hello Sain Matrimony Desk,\n\nI am interested in Candidate Profile:\nName: " . $profile['name'] . "\nProfile ID: " . $profile['profile_id'] . "\nAge: " . $profile['age'] . " Yrs\nCaste: " . $profile['caste'] . "\nCity: " . $profile['city'] . "\n\nPlease share details and connect us.");
                ?>
                <a href="https://wa.me/918528600100?text=<?php echo $wa_text; ?>" target="_blank" class="btn-profile-wa">
                    <i class="fab fa-whatsapp"></i> WhatsApp
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
                        <div class="profile-field-icon-circle"><i class="fa fa-dna"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">SUB COMMUNITY</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($sub_caste); ?></div>
                        </div>
                    </div>

                    <div class="profile-field-row">
                        <div class="profile-field-icon-circle"><i class="fa fa-bookmark"></i></div>
                        <div class="profile-field-content">
                            <div class="profile-field-label">GOTRA</div>
                            <div class="profile-field-val"><?php echo htmlspecialchars($gotra); ?></div>
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

<!-- Send Interest Modal -->
<div id="interestModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); z-index: 9999; align-items: center; justify-content: center; padding: 15px;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 500px; width: 100%; padding: 30px; position: relative; box-shadow: 0 20px 40px rgba(0,0,0,0.25); animation: fadeInStep 0.3s ease;">
        <button type="button" onclick="toggleInterestModal()" style="position: absolute; right: 18px; top: 18px; background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;">
            <i class="fa fa-times"></i>
        </button>

        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 50px; height: 50px; background: #fef2f2; color: var(--primary-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 10px;">
                <i class="fa fa-paper-plane"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Express Interest</h3>
            <p style="font-size: 13px; color: #64748b;">Send direct interest request for candidate <strong><?php echo htmlspecialchars($profile['name']); ?></strong> (ID: <?php echo htmlspecialchars($profile['profile_id']); ?>)</p>
        </div>

        <form action="profile.php?id=<?php echo $profile['id']; ?>" method="POST" style="display: grid; gap: 14px;">
            <div class="form-group-custom">
                <label>Your Full Name <span class="required">*</span></label>
                <input type="text" name="name" required placeholder="Enter your full name" class="input-custom-noicon">
            </div>

            <div class="form-grid-2">
                <div class="form-group-custom">
                    <label>Mobile Number <span class="required">*</span></label>
                    <input type="tel" name="phone" required placeholder="Your 10-digit mobile" class="input-custom-noicon">
                </div>
                <div class="form-group-custom">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" class="input-custom-noicon">
                </div>
            </div>

            <div class="form-group-custom">
                <label>Message / Note for Candidate Family</label>
                <textarea name="message" rows="3" placeholder="Write a short message introducing yourself..." class="textarea-custom"></textarea>
            </div>

            <button type="submit" name="submit_interest" class="btn-profile-interest" style="width: 100%; justify-content: center; padding: 12px;">
                <i class="fa fa-paper-plane"></i> Submit Express Interest Request
            </button>
        </form>
    </div>
</div>

<script>
function toggleInterestModal() {
    const modal = document.getElementById('interestModal');
    if (modal) {
        modal.style.display = (modal.style.display === 'flex') ? 'none' : 'flex';
    }
}

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

