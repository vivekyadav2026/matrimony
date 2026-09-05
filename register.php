<?php
$page_title = "Complete Matrimonial Biodata Form";
require_once __DIR__ . '/header.php';

$message_sent = false;
$error = '';
$uploaded_photo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Personal Details
    $name = trim($_POST['name'] ?? '');
    $gender = trim($_POST['gender'] ?? 'ਲੜਕਾ');
    $age = (int)($_POST['age'] ?? 25);
    $dob = trim($_POST['dob'] ?? '');
    $time_of_birth = trim($_POST['time_of_birth'] ?? '');
    $place_of_birth = trim($_POST['place_of_birth'] ?? '');
    $height = trim($_POST['height'] ?? '');
    $marital_status = trim($_POST['marital_status'] ?? 'Never Married');
    $religion = trim($_POST['religion'] ?? 'ਹਿੰਦੂ');
    $caste = trim($_POST['caste'] ?? 'ਨਾਈ');
    $sub_caste = '';
    $gotra = trim($_POST['gotra'] ?? '');
    $family_gotra = trim($_POST['family_gotra'] ?? '');
    if (empty($family_gotra)) {
        $family_gotra = $gotra;
    }
    if (empty($gotra)) {
        $gotra = $family_gotra;
    }
    $mother_gotra = trim($_POST['mother_gotra'] ?? ($_POST['mother_gotra_step4'] ?? ''));

    // Step 2: Location & Contact
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $country = trim($_POST['country'] ?? 'India');
    $state = trim($_POST['state'] ?? 'Punjab');
    $city = trim($_POST['city'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $tehsil_post = trim($_POST['tehsil_post'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Step 3: Education & Profession
    $education = trim($_POST['education'] ?? '');
    $education_detail = trim($_POST['education_detail'] ?? '');
    $occupation = trim($_POST['occupation'] ?? '');
    $organization = trim($_POST['organization'] ?? '');
    $income = trim($_POST['income'] ?? '');

    // Step 4: Family Details
    $father_name = trim($_POST['father_name'] ?? '');
    $father_occ = trim($_POST['father_occ'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $mother_occ = trim($_POST['mother_occ'] ?? '');
    $family_gotra = trim($_POST['family_gotra'] ?? '');
    $mother_gotra = trim($_POST['mother_gotra'] ?? '');
    $family_type = trim($_POST['family_type'] ?? 'Nuclear');
    $family_values = trim($_POST['family_values'] ?? 'Moderate');
    $brothers = trim($_POST['brothers'] ?? '0');
    $sisters = trim($_POST['sisters'] ?? '0');
    $siblings = trim($_POST['siblings'] ?? '');

    // Step 5: Partner Preferences
    $partner_age = trim($_POST['partner_age'] ?? '');
    $partner_height = trim($_POST['partner_height'] ?? '');
    $partner_caste = trim($_POST['partner_caste'] ?? '');
    $partner_education = trim($_POST['partner_education'] ?? '');
    $partner_location = trim($_POST['partner_location'] ?? '');
    $partner_notes = trim($_POST['partner_notes'] ?? '');
    $manglik_required = trim($_POST['manglik_required'] ?? 'ਹਾਂ');

    // Step 6: Photos & Additional Info
    $manglik = trim($_POST['manglik'] ?? 'ਨਹੀਂ');
    $rashi = trim($_POST['rashi'] ?? '');
    $complexion = trim($_POST['complexion'] ?? '');
    $diet = trim($_POST['diet'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $note = trim($_POST['note'] ?? '');

    // Handle Photo Upload safely
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'candidate_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/images/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $uploaded_photo = $newFileName;
            }
        }
    }

    if (empty($uploaded_photo)) {
        $error = "ਪ੍ਰੋਫਾਈਲ ਫੋਟੋ ਅਪਲੋਡ ਕਰਨੀ ਲਾਜ਼ਮੀ ਹੈ। ਕਿਰਪਾ ਕਰਕੇ ਫੋਟੋ ਅਪਲੋਡ ਕਰੋ। (Profile picture is mandatory. Please upload a photo.)";
    } elseif ($name && $phone && $caste) {
        try {
            // Save to inquiries table
            $ins_inq = $pdo->prepare("INSERT INTO inquiries (name, email, phone, gender, message) VALUES (?, ?, ?, ?, ?)");
            $compiled_message = "FULL BIODATA SUBMISSION:\n"
                . "DOB: $dob ($time_of_birth, $place_of_birth), Age: $age, Height: $height, Marital: $marital_status\n"
                . "Religion: $religion, Caste: $caste, Gotra: $gotra, Family Gotra: $family_gotra, Mother Gotra: $mother_gotra\n"
                . "Location: $city, $district, $tehsil_post, $state. Address: $address\n"
                . "Edu: $education ($education_detail), Occ: $occupation ($organization), Income: $income\n"
                . "Father: $father_name ($father_occ), Mother: $mother_name ($mother_occ)\n"
                . "Family: $family_type, Siblings: $siblings (Bros: $brothers, Sis: $sisters)\n"
                . "Manglik: $manglik, Manglik Match Needed: $manglik_required, Note: $note, Bio: $bio";
            $ins_inq->execute([$name, $email, $phone, $gender, $compiled_message]);

            // Save to profiles table
            $new_prof_id = 'SAIN' . rand(10000, 99999);
            $photo_to_save = $uploaded_photo ? $uploaded_photo : 'default.jpg';
            $db_gender = (in_array($gender, ['Female', 'ਲੜਕੀ', 'Bride']) ? 'Female' : 'Male');
            
            $ins_prof = $pdo->prepare("INSERT INTO profiles 
                (profile_id, name, gender, mobile, age, dob, time_of_birth, place_of_birth, height, education, occupation, income, address, father_name, mother_name, manglik, siblings, gotra, caste, manglik_required, religion, family_gotra, mother_gotra, district, tehsil_post, note, city, state, photo, status, is_premium) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'inactive', 0)");
            $ins_prof->execute([
                $new_prof_id, $name, $db_gender, $phone, $age, $dob, $time_of_birth, $place_of_birth, $height, $education, $occupation, $income, $address,
                $father_name, $mother_name, $manglik, $siblings, $gotra, $caste, $manglik_required, $religion, $family_gotra, $mother_gotra,
                $district, $tehsil_post, $note, ($city ?: ($district ?: 'Amritsar')), ($state ?: 'Punjab'), $photo_to_save
            ]);

            $message_sent = true;
        } catch (Exception $e) {
            $error = "Error saving biodata. Please try again: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all mandatory fields marked with (*).";
    }
}
?>

<div class="biodata-section">
    <div class="biodata-container">
        
        <!-- Form Header -->
        <div class="biodata-header">
            <div class="biodata-badge"><i class="fa fa-heart" style="margin-right: 5px;"></i> SUBMIT YOUR BIODATA</div>
            <h1 class="biodata-title">Complete Matrimonial <span>Biodata Form</span></h1>
            <p class="biodata-subtitle">Complete your biodata step by step — personal details, education, family background, and partner preferences. Takes about 5 minutes. After final review, submit for admin verification & approval.</p>
        </div>

        <?php if ($message_sent): ?>
            <!-- Success Confirmation Screen -->
            <div class="multistep-card" style="text-align: center; padding: 45px 30px;">
                <div style="width: 70px; height: 70px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 34px; margin: 0 auto 20px; box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);">
                    <i class="fa fa-check-circle"></i>
                </div>
                <h2 style="font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Biodata Submitted Successfully!</h2>
                
                <!-- Prominent Profile ID Box -->
                <div style="background: linear-gradient(135deg, #fef2f2 0%, #fffbeb 100%); border: 2px dashed var(--primary-red); padding: 18px 28px; border-radius: 16px; display: inline-block; margin: 15px auto 22px; box-shadow: 0 4px 15px rgba(204,30,43,0.08);">
                    <div style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">YOUR PROFILE ID</div>
                    <div style="font-size: 36px; font-weight: 900; color: var(--primary-red); font-family: monospace; letter-spacing: 2px; margin-top: 4px;"><?php echo htmlspecialchars($new_prof_id); ?></div>
                    <div style="font-size: 12px; color: #d97706; font-weight: 700; margin-top: 4px;"><i class="fa fa-clock"></i> Status: Pending Admin Approval</div>
                </div>

                <p style="color: #475569; font-size: 15px; max-width: 620px; margin: 0 auto 25px; line-height: 1.6;">
                    Thank you <strong><?php echo htmlspecialchars($name); ?></strong>! Please note down your <strong>Profile ID: <?php echo htmlspecialchars($new_prof_id); ?></strong> for future reference. Our admin desk will verify your details and approve your profile shortly.
                </p>

                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <?php 
                        $reg_wa_text = "Hello Sain Matrimony Desk,\n\n"
                            . "📝 *NEW BIODATA REGISTRATION*\n"
                            . "-----------------------------------\n"
                            . "*Profile ID:* " . $new_prof_id . "\n"
                            . "*Name:* " . $name . "\n"
                            . "*Gender:* " . $gender . "\n"
                            . "*Age:* " . $age . " Yrs\n"
                            . "*Caste:* " . $caste . "\n"
                            . "*City:* " . ($city ?: 'N/A') . "\n"
                            . "*Mobile:* " . $phone . "\n\n"
                            . "I have registered my biodata on your website. Please connect me with suitable matching profiles.";
                        $reg_wa_url = build_whatsapp_link($reg_wa_text);
                    ?>
                    <a href="<?php echo $reg_wa_url; ?>" target="_blank" class="btn-step-next" style="background: #25D366; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35); text-decoration: none;">
                        <i class="fab fa-whatsapp" style="font-size: 18px;"></i> Send Registration Details on WhatsApp
                    </a>
                    <a href="search.php" class="btn-step-back" style="text-decoration: none;">
                        <i class="fa fa-search"></i> Browse Matching Profiles
                    </a>
                </div>
                <script>
                    setTimeout(function() {
                        window.open(<?php echo json_encode($reg_wa_url); ?>, '_blank');
                    }, 500);
                </script>
            </div>

        <?php else: ?>

            <?php if ($error): ?>
                <div style="background-color: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #fecaca; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-exclamation-circle" style="color: #dc2626; font-size: 18px;"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Progress Indicator -->
            <div class="step-progress-wrapper">
                <div class="step-progress-info">
                    <span id="stepProgressText">Step 1 of 7</span>
                    <span id="stepProgressPercent">14% complete</span>
                </div>
                <div class="step-progress-track">
                    <div class="step-progress-bar" id="progressBar"></div>
                </div>
            </div>

            <!-- Step Pills Navigation -->
            <div class="step-pills-container" id="stepPills">
                <div class="step-pill active" onclick="jumpToStep(1)">
                    <span class="step-pill-num">1</span> Personal Details
                </div>
                <div class="step-pill" onclick="jumpToStep(2)">
                    <span class="step-pill-num">2</span> Location & Contact
                </div>
                <div class="step-pill" onclick="jumpToStep(3)">
                    <span class="step-pill-num">3</span> Education & Profession
                </div>
                <div class="step-pill" onclick="jumpToStep(4)">
                    <span class="step-pill-num">4</span> Family Details
                </div>
                <div class="step-pill" onclick="jumpToStep(5)">
                    <span class="step-pill-num">5</span> Partner Preferences
                </div>
                <div class="step-pill" onclick="jumpToStep(6)">
                    <span class="step-pill-num">6</span> Photos & Info
                </div>
                <div class="step-pill" onclick="jumpToStep(7)">
                    <span class="step-pill-num">7</span> Review
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="multistep-card">
                <form id="biodataForm" action="register.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- STEP 1: PERSONAL DETAILS -->
                    <div class="step-pane active" id="step1">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 1</span>
                            <h2 class="step-header-title">ਨਾਮ & ਨਿੱਜੀ ਵੇਰਵੇ</h2>
                            <p class="step-header-desc">ਹੇਠਾਂ ਉਮੀਦਵਾਰ ਦੇ ਵੇਰਵੇ ਭਰੋ। (*) ਵਾਲੇ ਖੇਤਰ ਲਾਜ਼ਮੀ ਹਨ।</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-group-custom">
                                <label>ਨਾਮ <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" id="field_name" required placeholder="ਉਮੀਦਵਾਰ ਦਾ ਨਾਮ" class="input-custom">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਲਿੰਗ <span class="required">*</span></label>
                                    <select name="gender" id="field_gender" class="input-custom-noicon">
                                        <option value="ਲੜਕਾ">ਲੜਕਾ</option>
                                        <option value="ਲੜਕੀ">ਲੜਕੀ</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਜਨਮ ਮਿਤੀ <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-calendar-alt"></i>
                                        <input type="date" name="dob" id="field_dob" class="input-custom" onchange="calculateAgeFromDOB(this.value)" oninput="calculateAgeFromDOB(this.value)">
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-3">
                                <div class="form-group-custom">
                                    <label>ਉਮਰ <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-birthday-cake"></i>
                                        <input type="number" name="age" id="field_age" min="18" max="75" required placeholder="ਜਨਮ ਮਿਤੀ ਤੋਂ ਆਟੋ-ਕੈਲਕੂਲੇਟ" class="input-custom">
                                    </div>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਜਨਮ ਸਮਾਂ</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-clock"></i>
                                        <input type="text" name="time_of_birth" id="field_time_of_birth" placeholder="ਉਦਾਹਰਣ: 10:30 AM" class="input-custom">
                                    </div>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਜਨਮ ਸਥਾਨ</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-map-marker-alt"></i>
                                        <input type="text" name="place_of_birth" id="field_place_of_birth" placeholder="ਉਦਾਹਰਣ: ਅੰਮ੍ਰਿਤਸਰ" class="input-custom">
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਕੱਦ (ਹਾਈਟ) <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-ruler-vertical"></i>
                                        <input type="text" name="height" id="field_height" placeholder="ਉਦਾਹਰਣ: 5'7&quot; ਜਾਂ 170 ਸਮ" class="input-custom">
                                    </div>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਮਾਰਸ਼ਲ ਸਟੇਟਸ <span class="required">*</span></label>
                                    <select name="marital_status" id="field_marital_status" class="input-custom-noicon">
                                        <option value="Never Married">ਅਣ-ਵਿਆਹਿਆ/ਹੀ</option>
                                        <option value="Divorced">ਤਲਾਕਸ਼ੁਦਾ</option>
                                        <option value="Widowed">ਵਿਧਵਾ/ਵਿਧੁਰ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਕਾਸਟ <span class="required">*</span></label>
                                    <select name="caste" id="field_caste" class="input-custom-noicon">
                                        <option value="ਨਾਈ">ਨਾਈ (Nai)</option>
                                        <option value="ਅਦਰ">ਅਦਰ (Others)</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਧਰਮ <span class="required">*</span></label>
                                    <select name="religion" id="field_religion" class="input-custom-noicon">
                                        <option value="ਹਿੰਦੂ">ਹਿੰਦੂ</option>
                                        <option value="ਸਿੱਖ">ਸਿੱਖ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਦਾਦਕੇ ਗੋਤ (Dadke Gotra)</label>
                                    <input type="text" name="gotra" id="field_gotra" placeholder="ਉਦਾਹਰਣ: ਗਿੱਲ, ਧਾਲੀਵਾਲ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਨਾਨਕੇ ਗੋਤ (Nanke Gotra)</label>
                                    <input type="text" name="mother_gotra" id="field_mother_gotra" placeholder="ਉਦਾਹਰਣ: ਸੰਧੂ, ਢਿੱਲੋਂ" class="input-custom-noicon">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: LOCATION & CONTACT -->
                    <div class="step-pane" id="step2">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 2</span>
                            <h2 class="step-header-title">ਸਥਾਨ & ਸੰਪਰਕ</h2>
                            <p class="step-header-desc">ਆਪਣੀ ਸਹੀ ਸੰਪਰਕ ਜਾਣਕਾਰੀ ਦਰਜ ਕਰੋ।</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਮੋਬਾਇਲ ਨੰਬਰ <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-phone"></i>
                                        <input type="tel" name="phone" id="field_phone" required placeholder="10 ਅੰਕਾਂ ਦਾ ਮੋਬਾਇਲ ਨੰਬਰ" class="input-custom">
                                    </div>
                                </div>
                                <div class="form-group-custom">
                                    <label>Email Address</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-envelope"></i>
                                        <input type="email" name="email" id="field_email" placeholder="candidate@example.com" class="input-custom">
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-3">
                                <div class="form-group-custom">
                                    <label>ਜ਼ਿਲ੍ਹਾ <span class="required">*</span></label>
                                    <input type="text" name="district" id="field_district" required placeholder="ਉਦਾਹਰਣ: ਅੰਮ੍ਰਿਤਸਰ, ਲੁਧਿਆਣਾ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਪੋਸਟ ਆਫਿਸ ਤੇ ਤਹਿਸੀਲ</label>
                                    <input type="text" name="tehsil_post" id="field_tehsil_post" placeholder="ਉਦਾਹਰਣ: ਤਹਿਸੀਲ ਅਜਨਾਲਾ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਸਟੇਟ</label>
                                    <input type="text" name="state" id="field_state" value="Punjab" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>ਪੂਰਾ ਪਤਾ</label>
                                <textarea name="address" id="field_address" rows="2" placeholder="ਮਕਾਨ ਨੰਬਰ, ਗਲੀ, ਪਿੰਡ/ਕਲੋਨੀ..." class="textarea-custom"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: EDUCATION & PROFESSION -->
                    <div class="step-pane" id="step3">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 3</span>
                            <h2 class="step-header-title">ਪੜ੍ਹਾਈ & ਕੰਮ ਕਾਰ</h2>
                            <p class="step-header-desc">ਉਮੀਦਵਾਰ ਦੀ ਪੜ੍ਹਾਈ ਅਤੇ ਨੌਕਰੀ/ਬਿਜ਼ਨਸ ਦੀ ਜਾਣਕਾਰੀ ਦਿਓ।</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਪੜ੍ਹਾਈ/ਯੋਗਤਾ <span class="required">*</span></label>
                                    <select name="education" id="field_education" class="input-custom-noicon">
                                        <option value="Graduate">ਗ੍ਰੈਜੂਏਟ (Graduate)</option>
                                        <option value="Post Graduate">ਪੋਸਟ ਗ੍ਰੈਜੂਏਟ (Post Graduate)</option>
                                        <option value="Doctorate / PhD">ਡਾਕਟਰੇਟ / PhD</option>
                                        <option value="Medical / MBBS">ਮੈਡੀਕਲ / MBBS / BDS</option>
                                        <option value="CA / CS / Finance">CA / CS / Finance</option>
                                        <option value="Diploma / ITI">ਡਿਪਲੋਮਾ / ITI</option>
                                        <option value="High School">ਹਾਇਰ ਸੈਕੰਡਰੀ / 12ਵੀਂ</option>
                                        <option value="Others">ਹੋਰ (Others)</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਡਿਗਰੀ/ਕੋਰਸ</label>
                                    <input type="text" name="education_detail" id="field_education_detail" placeholder="ਉਦਾਹਰਣ: B.Tech, MBA" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਕੰਮ ਕਾਰ/ਨੌਕਰੀ/ਬਿਜ਼ਨਸ <span class="required">*</span></label>
                                    <select name="occupation" id="field_occupation" class="input-custom-noicon">
                                        <option value="ਸਰਕਾਰੀ">ਸਰਕਾਰੀ</option>
                                        <option value="ਪ੍ਰਾਈਵੇਟ">ਪ੍ਰਾਈਵੇਟ</option>
                                        <option value="ਅਦਰ">ਅਦਰ</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਕੰਪਨੀ</label>
                                    <input type="text" name="organization" id="field_organization" placeholder="ਕੰਪਨੀ / ਵਿਭਾਗ ਦਾ ਨਾਮ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>ਸਾਲਾਨਾ ਆਮਦਨ</label>
                                <input type="text" name="income" id="field_income" placeholder="ਉਦਾਹਰਣ: 5-7 ਲੱਖ ਸਾਲਾਨਾ" class="input-custom-noicon">
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: FAMILY DETAILS -->
                    <div class="step-pane" id="step4">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 4</span>
                            <h2 class="step-header-title">ਪਰਿਵਾਰਕ ਵੇਰਵੇ</h2>
                            <p class="step-header-desc">ਮਾਤਾ-ਪਿਤਾ, ਭੈਣ-ਭਰਾ ਅਤੇ ਪਰਿਵਾਰਕ ਪਿਛੋਕੜ ਬਾਰੇ ਦੱਸੋ।</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਪਿਤਾ ਦਾ ਨਾਮ</label>
                                    <input type="text" name="father_name" id="field_father_name" placeholder="ਪਿਤਾ ਦਾ ਪੂਰਾ ਨਾਮ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਪਿਤਾ ਦਾ ਕੰਮ</label>
                                    <input type="text" name="father_occ" id="field_father_occ" placeholder="ਉਦਾਹਰਣ: ਬਿਜ਼ਨਸਮੈਨ, ਸਰਕਾਰੀ ਨੌਕਰੀ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਮਾਤਾ ਦਾ ਨਾਮ</label>
                                    <input type="text" name="mother_name" id="field_mother_name" placeholder="ਮਾਤਾ ਦਾ ਪੂਰਾ ਨਾਮ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਮਾਤਾ ਦਾ ਕੰਮ</label>
                                    <input type="text" name="mother_occ" id="field_mother_occ" placeholder="ਉਦਾਹਰਣ: ਘਰੇਲੂ, ਅਧਿਆਪਕ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਦਾਦਕੇ ਗੋਤ (Dadke Gotra)</label>
                                    <input type="text" name="family_gotra" id="field_family_gotra" placeholder="ਪਰਿਵਾਰ ਦਾ ਗੋਤ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਨਾਨਕੇ ਗੋਤ (Nanke Gotra)</label>
                                    <input type="text" name="mother_gotra_step4" id="field_mother_gotra_step4" placeholder="ਮਾਤਾ ਦਾ ਨਾਨਕੇ ਗੋਤ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਭੈਣ ਭਰਾ</label>
                                    <input type="text" name="siblings" id="field_siblings" placeholder="ਉਦਾਹਰਣ: 1 ਭਰਾ, 1 ਭੈਣ" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਪਰਿਵਾਰ ਦੀ ਕਿਸਮ</label>
                                    <select name="family_type" id="field_family_type" class="input-custom-noicon">
                                        <option value="Nuclear">ਇਕੱਲਾ ਪਰਿਵਾਰ (Nuclear)</option>
                                        <option value="Joint">ਸਾਂਝਾ ਪਰਿਵਾਰ (Joint)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 5: PARTNER PREFERENCES -->
                    <div class="step-pane" id="step5">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 5</span>
                            <h2 class="step-header-title">ਜੀਵਨ ਸਾਥੀ ਦੀ ਪਸੰਦ</h2>
                            <p class="step-header-desc">ਤੁਸੀਂ ਆਪਣੇ ਹੋਣ ਵਾਲੇ ਜੀਵਨ ਸਾਥੀ ਵਿੱਚ ਕੀ ਪਸੰਦ ਕਰਦੇ ਹੋ।</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਮੰਗਲੀਕ ਰਿਸ਼ਤਾ ਚਾਹੀਦਾ</label>
                                    <select name="manglik_required" id="field_manglik_required" class="input-custom-noicon">
                                        <option value="ਹਾਂ">ਹਾਂ</option>
                                        <option value="ਨਹੀਂ">ਨਹੀਂ</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਪਸੰਦੀਦਾ ਉਮਰ</label>
                                    <input type="text" name="partner_age" id="field_partner_age" placeholder="ਉਦਾਹਰਣ: 22 - 27 ਸਾਲ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਪਸੰਦੀਦਾ ਕੱਦ</label>
                                    <input type="text" name="partner_height" id="field_partner_height" placeholder="ਉਦਾਹਰਣ: 5'2&quot; ਤੋਂ 5'8&quot;" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>ਪਸੰਦੀਦਾ ਕਾਸਟ</label>
                                    <input type="text" name="partner_caste" id="field_partner_caste" value="ਸੈਣੀ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>ਪਸੰਦੀਦਾ ਯੋਗਤਾ & ਨੌਕਰੀ</label>
                                <input type="text" name="partner_education" id="field_partner_education" placeholder="ਉਦਾਹਰਣ: ਗ੍ਰੈਜੂਏਟ / ਸਰਕਾਰੀ ਨੌਕਰੀ" class="input-custom-noicon">
                            </div>

                            <div class="form-group-custom">
                                <label>ਹੋਰ ਇੱਛਾਵਾਂ</label>
                                <textarea name="partner_notes" id="field_partner_notes" rows="2" placeholder="ਹੋਰ ਕੋਈ ਖਾਸ ਇੱਛਾ ਜਾਂ ਮੰਗ..." class="textarea-custom"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 6: PHOTOS & ADDITIONAL INFO -->
                    <div class="step-pane" id="step6">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 6</span>
                            <h2 class="step-header-title">ਫੋਟੋ ਅਤੇ ਹੋਰ ਵੇਰਵੇ</h2>
                            <p class="step-header-desc">ਉਮੀਦਵਾਰ ਦੀ ਫੋਟੋ ਅਪਲੋਡ ਕਰੋ ਅਤੇ ਹੋਰ ਵੇਰਵੇ ਭਰੋ।</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-group-custom">
                                <label>ਉਮੀਦਵਾਰ ਦੀ ਪ੍ਰੋਫਾਈਲ ਫੋਟੋ <span class="required">*</span></label>
                                <input type="file" name="photo" id="photoInput" accept="image/*" class="input-custom-noicon" style="padding: 9px;" required onchange="handlePhotoSelect(this)">
                                <div class="photo-upload-preview" id="photoPreviewWrapper" style="display: none;">
                                    <img id="photoPreviewImg" src="" alt="Photo Preview" class="photo-preview-img">
                                    <div>
                                        <strong style="color: #0f172a; font-size: 13.5px; display: block;">ਫੋਟੋ ਚੁਣੀ ਗਈ</strong>
                                        <span style="color: #64748b; font-size: 12px;">ਇਹ ਫੋਟੋ ਤੁਹਾਡੀ ਵੈਰੀਫਾਈਡ ਪ੍ਰੋਫਾਈਲ 'ਤੇ ਦਿਖਾਈ ਜਾਵੇਗੀ।</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>ਮੰਗਲੀਕ <span class="required">*</span></label>
                                    <select name="manglik" id="field_manglik" class="input-custom-noicon">
                                        <option value="ਨਹੀਂ">ਨਹੀਂ</option>
                                        <option value="ਹਾਂ">ਹਾਂ</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>ਰਾਸ਼ੀ</label>
                                    <input type="text" name="rashi" id="field_rashi" placeholder="ਉਦਾਹਰਣ: ਸਿੰਘ / ਮੇਖ" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>ਨੋਟ</label>
                                <textarea name="note" id="field_note" rows="3" placeholder="ਕੋਈ ਖਾਸ ਨੋਟ ਜਾਂ ਹਦਾਇਤ ਲਿਖੋ..." class="textarea-custom"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 7: REVIEW & PREVIEW -->
                    <div class="step-pane" id="step7">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 7</span>
                            <h2 class="step-header-title">Review & Submit Biodata</h2>
                            <p class="step-header-desc">Review your filled details carefully before final submission.</p>
                        </div>

                        <!-- Formatted Live Review Card -->
                        <div class="review-card-container">
                            
                            <!-- Personal Info Box -->
                            <div class="review-section-box">
                                <div class="review-section-header">
                                    <span class="review-section-title"><i class="fa fa-user"></i> Personal Details</span>
                                    <button type="button" class="review-btn-edit" onclick="jumpToStep(1)"><i class="fa fa-pencil"></i> Edit</button>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item"><label>Full Name</label><span id="rev_name">-</span></div>
                                    <div class="review-item"><label>Gender</label><span id="rev_gender">-</span></div>
                                    <div class="review-item"><label>Age / DOB</label><span id="rev_age_dob">-</span></div>
                                    <div class="review-item"><label>Height</label><span id="rev_height">-</span></div>
                                    <div class="review-item"><label>Marital Status</label><span id="rev_marital">-</span></div>
                                    <div class="review-item"><label>Caste</label><span id="rev_caste">-</span></div>
                                    <div class="review-item"><label>Dadke Gotra</label><span id="rev_dadke_gotra">-</span></div>
                                    <div class="review-item"><label>Nanke Gotra</label><span id="rev_nanke_gotra">-</span></div>
                                </div>
                            </div>

                            <!-- Contact & Location Box -->
                            <div class="review-section-box">
                                <div class="review-section-header">
                                    <span class="review-section-title"><i class="fa fa-map-marker-alt"></i> Contact & Location</span>
                                    <button type="button" class="review-btn-edit" onclick="jumpToStep(2)"><i class="fa fa-pencil"></i> Edit</button>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item"><label>Mobile / Phone</label><span id="rev_phone">-</span></div>
                                    <div class="review-item"><label>Email</label><span id="rev_email">-</span></div>
                                    <div class="review-item"><label>Location</label><span id="rev_location">-</span></div>
                                </div>
                            </div>

                            <!-- Education & Career Box -->
                            <div class="review-section-box">
                                <div class="review-section-header">
                                    <span class="review-section-title"><i class="fa fa-graduation-cap"></i> Education & Profession</span>
                                    <button type="button" class="review-btn-edit" onclick="jumpToStep(3)"><i class="fa fa-pencil"></i> Edit</button>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item"><label>Education</label><span id="rev_education">-</span></div>
                                    <div class="review-item"><label>Occupation</label><span id="rev_occupation">-</span></div>
                                    <div class="review-item"><label>Annual Income</label><span id="rev_income">-</span></div>
                                </div>
                            </div>

                            <!-- Family Details Box -->
                            <div class="review-section-box">
                                <div class="review-section-header">
                                    <span class="review-section-title"><i class="fa fa-users"></i> Family Background</span>
                                    <button type="button" class="review-btn-edit" onclick="jumpToStep(4)"><i class="fa fa-pencil"></i> Edit</button>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item"><label>Father</label><span id="rev_father">-</span></div>
                                    <div class="review-item"><label>Mother</label><span id="rev_mother">-</span></div>
                                    <div class="review-item"><label>Siblings</label><span id="rev_siblings">-</span></div>
                                </div>
                            </div>

                            <!-- Partner Preferences Box -->
                            <div class="review-section-box">
                                <div class="review-section-header">
                                    <span class="review-section-title"><i class="fa fa-heart"></i> Partner Expectations</span>
                                    <button type="button" class="review-btn-edit" onclick="jumpToStep(5)"><i class="fa fa-pencil"></i> Edit</button>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item"><label>Pref. Age & Height</label><span id="rev_pref_age_ht">-</span></div>
                                    <div class="review-item"><label>Pref. Caste & Edu</label><span id="rev_pref_caste_edu">-</span></div>
                                </div>
                            </div>

                        </div>

                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 15px; border-radius: 10px; font-size: 13.5px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                            <i class="fa fa-shield-alt" style="font-size: 20px; color: #22c55e;"></i>
                            <div>
                                <strong>100% Privacy Protected:</strong> Your mobile number and details are kept safe and shared only with verified members.
                            </div>
                        </div>
                    </div>

                    <!-- Step Navigation Actions -->
                    <div class="step-actions">
                        <button type="button" class="btn-step-back" id="btnBack" onclick="prevStep()" disabled>
                            <i class="fa fa-arrow-left"></i> Back
                        </button>
                        
                        <button type="button" class="btn-step-next" id="btnNext" onclick="nextStep()">
                            Next Step <i class="fa fa-arrow-right"></i>
                        </button>

                        <button type="submit" class="btn-step-next" id="btnSubmit" style="display: none; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); box-shadow: 0 4px 15px rgba(22, 163, 74, 0.35);">
                            <i class="fa fa-check-circle"></i> Submit Biodata Form
                        </button>
                    </div>

                    <div class="step-footer-note">Your progress is saved as you move between steps.</div>
                </form>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- Dynamic Step Logic JS -->
<script>
let currentStep = 1;
const totalSteps = 7;

function updateProgress() {
    // Calculate percentage
    const percent = Math.round((currentStep / totalSteps) * 100);
    document.getElementById('stepProgressText').innerText = `Step ${currentStep} of ${totalSteps}`;
    document.getElementById('stepProgressPercent').innerText = `${percent}% complete`;
    document.getElementById('progressBar').style.width = `${percent}%`;

    // Update Pills
    const pills = document.querySelectorAll('.step-pill');
    pills.forEach((pill, idx) => {
        const stepNum = idx + 1;
        pill.classList.remove('active', 'completed');
        if (stepNum === currentStep) {
            pill.classList.add('active');
        } else if (stepNum < currentStep) {
            pill.classList.add('completed');
        }
    });

    // Toggle Panes
    for (let i = 1; i <= totalSteps; i++) {
        const pane = document.getElementById(`step${i}`);
        if (pane) {
            if (i === currentStep) {
                pane.classList.add('active');
            } else {
                pane.classList.remove('active');
            }
        }
    }

    // Toggle Buttons
    const btnBack = document.getElementById('btnBack');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');

    btnBack.disabled = (currentStep === 1);

    if (currentStep === totalSteps) {
        btnNext.style.display = 'none';
        btnSubmit.style.display = 'inline-flex';
        compileReviewData();
    } else {
        btnNext.style.display = 'inline-flex';
        btnSubmit.style.display = 'none';
    }

    // Scroll smoothly to top of card
    document.querySelector('.biodata-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function validateCurrentStep() {
    const pane = document.getElementById(`step${currentStep}`);
    if (!pane) return true;

    const requiredInputs = pane.querySelectorAll('[required]');
    let isValid = true;

    requiredInputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = '#dc2626';
            input.focus();
        } else {
            input.style.borderColor = '#cbd5e1';
        }
    });

    if (!isValid) {
        alert('Please complete all mandatory fields marked with (*) before proceeding.');
    }

    return isValid;
}

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            currentStep++;
            updateProgress();
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateProgress();
    }
}

function jumpToStep(stepNum) {
    if (stepNum < currentStep || validateCurrentStep()) {
        currentStep = stepNum;
        updateProgress();
    }
}

function handlePhotoSelect(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreviewImg').src = e.target.result;
            document.getElementById('photoPreviewWrapper').style.display = 'flex';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function calculateAgeFromDOB(dobVal) {
    if (!dobVal) return;
    const parts = dobVal.split('-');
    if (parts.length < 3) return;
    const year = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10) - 1;
    const day = parseInt(parts[2], 10);

    if (isNaN(year) || isNaN(month) || isNaN(day)) return;

    const today = new Date();
    let age = today.getFullYear() - year;
    const monthDiff = today.getMonth() - month;
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < day)) {
        age--;
    }

    const ageInput = document.getElementById('field_age');
    if (ageInput && !isNaN(age) && age > 0) {
        ageInput.value = age;
        ageInput.style.borderColor = '#cbd5e1';
    }
}

function compileReviewData() {
    const getVal = (id, fallback = 'Not specified') => {
        const el = document.getElementById(id);
        return (el && el.value.trim()) ? el.value.trim() : fallback;
    };

    document.getElementById('rev_name').innerText = getVal('field_name');
    document.getElementById('rev_gender').innerText = getVal('field_gender');
    document.getElementById('rev_age_dob').innerText = `${getVal('field_age')} Yrs` + (getVal('field_dob', '') ? ` (${getVal('field_dob')})` : '');
    document.getElementById('rev_height').innerText = getVal('field_height');
    document.getElementById('rev_marital').innerText = getVal('field_marital_status');
    document.getElementById('rev_caste').innerText = getVal('field_caste');
    document.getElementById('rev_dadke_gotra').innerText = getVal('field_gotra') || getVal('field_family_gotra') || '-';
    document.getElementById('rev_nanke_gotra').innerText = getVal('field_mother_gotra') || getVal('field_mother_gotra_step4') || '-';

    document.getElementById('rev_phone').innerText = getVal('field_phone');
    document.getElementById('rev_email').innerText = getVal('field_email');
    document.getElementById('rev_location').innerText = `${getVal('field_district', getVal('field_city'))}, ${getVal('field_state', 'Punjab')}`;

    document.getElementById('rev_education').innerText = `${getVal('field_education')}` + (getVal('field_education_detail', '') ? ` - ${getVal('field_education_detail')}` : '');
    document.getElementById('rev_occupation').innerText = `${getVal('field_occupation')}` + (getVal('field_organization', '') ? ` (${getVal('field_organization')})` : '');
    document.getElementById('rev_income').innerText = getVal('field_income');

    document.getElementById('rev_father').innerText = getVal('field_father_name') + (getVal('field_father_occ', '') ? ` (${getVal('field_father_occ')})` : '');
    document.getElementById('rev_mother').innerText = getVal('field_mother_name') + (getVal('field_mother_occ', '') ? ` (${getVal('field_mother_occ')})` : '');
    document.getElementById('rev_siblings').innerText = `Bros: ${getVal('field_brothers', '0')}, Sis: ${getVal('field_sisters', '0')}`;

    document.getElementById('rev_pref_age_ht').innerText = `Age: ${getVal('field_partner_age')}, Height: ${getVal('field_partner_height')}`;
    document.getElementById('rev_pref_caste_edu').innerText = `Caste: ${getVal('field_partner_caste')}, Edu: ${getVal('field_partner_education')}`;
}

document.addEventListener('DOMContentLoaded', () => {
    updateProgress();
    const dobInput = document.getElementById('field_dob');
    if (dobInput) {
        ['change', 'input', 'blur'].forEach(evt => {
            dobInput.addEventListener(evt, () => calculateAgeFromDOB(dobInput.value));
        });
        if (dobInput.value) {
            calculateAgeFromDOB(dobInput.value);
        }
    }
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>

