<?php
$page_title = "Complete Matrimonial Biodata Form";
require_once __DIR__ . '/header.php';

$message_sent = false;
$error = '';
$uploaded_photo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Personal Details
    $name = trim($_POST['name'] ?? '');
    $gender = trim($_POST['gender'] ?? 'Female');
    $age = (int)($_POST['age'] ?? 25);
    $dob = trim($_POST['dob'] ?? '');
    $height = trim($_POST['height'] ?? '');
    $marital_status = trim($_POST['marital_status'] ?? 'Never Married');
    $raw_caste = trim($_POST['caste'] ?? 'Sain / Nai');
    $sub_caste = trim($_POST['sub_caste'] ?? '');
    $gotra = trim($_POST['gotra'] ?? '');

    // Normalize Sain & Nai as same community
    if (in_array(strtolower($raw_caste), ['sain', 'nai', 'sain/nai', 'sain / nai'])) {
        $caste = 'Sain / Nai';
    } else {
        $caste = $raw_caste;
    }

    // Step 2: Location & Contact
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $country = trim($_POST['country'] ?? 'India');
    $state = trim($_POST['state'] ?? '');
    $city = trim($_POST['city'] ?? '');
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
    $family_type = trim($_POST['family_type'] ?? 'Nuclear');
    $family_values = trim($_POST['family_values'] ?? 'Moderate');
    $brothers = trim($_POST['brothers'] ?? '0');
    $sisters = trim($_POST['sisters'] ?? '0');

    // Step 5: Partner Preferences
    $partner_age = trim($_POST['partner_age'] ?? '');
    $partner_height = trim($_POST['partner_height'] ?? '');
    $partner_caste = trim($_POST['partner_caste'] ?? '');
    $partner_education = trim($_POST['partner_education'] ?? '');
    $partner_location = trim($_POST['partner_location'] ?? '');
    $partner_notes = trim($_POST['partner_notes'] ?? '');

    // Step 6: Photos & Additional Info
    $manglik = trim($_POST['manglik'] ?? 'Non-Manglik');
    $rashi = trim($_POST['rashi'] ?? '');
    $complexion = trim($_POST['complexion'] ?? '');
    $diet = trim($_POST['diet'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    // Handle Photo Upload safely
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'candidate_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $uploaded_photo = $newFileName;
            }
        }
    }

    if ($name && $phone && $caste) {
        try {
            // Save to inquiries table
            $ins_inq = $pdo->prepare("INSERT INTO inquiries (name, email, phone, gender, message) VALUES (?, ?, ?, ?, ?)");
            $compiled_message = "FULL BIODATA SUBMISSION:\n"
                . "DOB: $dob, Age: $age, Height: $height, Marital: $marital_status\n"
                . "Caste: $caste, Sub-Caste: $sub_caste, Gotra: $gotra\n"
                . "Location: $city, $state, $country. Address: $address\n"
                . "Edu: $education ($education_detail), Occ: $occupation ($organization), Income: $income\n"
                . "Father: $father_name ($father_occ), Mother: $mother_name ($mother_occ)\n"
                . "Family: $family_type, Values: $family_values, Bros: $brothers, Sis: $sisters\n"
                . "Manglik: $manglik, Rashi: $rashi, Diet: $diet\n"
                . "Partner Prefs: Age: $partner_age, Height: $partner_height, Caste: $partner_caste, Edu: $partner_education, Loc: $partner_location. Notes: $partner_notes\n"
                . "Bio: $bio";
            $ins_inq->execute([$name, $email, $phone, $gender, $compiled_message]);

            // Save to profiles table
            $new_prof_id = 'SAIN' . rand(10000, 99999);
            $photo_to_save = $uploaded_photo ? $uploaded_photo : 'default.jpg';
            
            $ins_prof = $pdo->prepare("INSERT INTO profiles (profile_id, name, gender, mobile, age, caste, city, state, education, occupation, photo, status, is_premium) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', 0)");
            $ins_prof->execute([
                $new_prof_id, 
                $name, 
                $gender, 
                $phone, 
                $age, 
                $caste, 
                $city ? $city : 'Not Specified', 
                $state ? $state : 'Not Specified', 
                $education ? $education : 'Graduate', 
                $occupation ? $occupation : 'Professional', 
                $photo_to_save
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
            <p class="biodata-subtitle">Complete your biodata step by step — personal details, education, family background, and partner preferences. Takes about 5 minutes. After the final review, submit via WhatsApp to share photos.</p>
        </div>

        <?php if ($message_sent): ?>
            <!-- Success Confirmation Screen -->
            <div class="multistep-card" style="text-align: center; padding: 45px 30px;">
                <div style="width: 70px; height: 70px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 34px; margin: 0 auto 20px;">
                    <i class="fa fa-check"></i>
                </div>
                <h2 style="font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 10px;">Biodata Submitted Successfully!</h2>
                <p style="color: #475569; font-size: 15px; max-width: 580px; margin: 0 auto 25px; line-height: 1.6;">
                    Thank you <strong><?php echo htmlspecialchars($name); ?></strong>! Your matrimony profile (ID: <strong><?php echo htmlspecialchars($new_prof_id); ?></strong>) has been registered and saved in our database. Our desk team will verify and connect you with matching profiles.
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
                            <h2 class="step-header-title">Personal Details</h2>
                            <p class="step-header-desc">Fill in the candidate details below. Fields marked with * are required.</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-group-custom">
                                <label>Full Name <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" id="field_name" required placeholder="As per official documents" class="input-custom">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Gender <span class="required">*</span></label>
                                    <select name="gender" id="field_gender" class="input-custom-noicon">
                                        <option value="Female">Female (Bride / Vadhu)</option>
                                        <option value="Male">Male (Groom / Var)</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>Age (Years) <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-birthday-cake"></i>
                                        <input type="number" name="age" id="field_age" value="25" min="18" max="75" required placeholder="e.g. 25" class="input-custom">
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Date of Birth</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-calendar-alt"></i>
                                        <input type="date" name="dob" id="field_dob" class="input-custom">
                                    </div>
                                </div>
                                <div class="form-group-custom">
                                    <label>Height</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-ruler-vertical"></i>
                                        <input type="text" name="height" id="field_height" placeholder="e.g. 5'5&quot; or 165 cm" class="input-custom">
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Marital Status <span class="required">*</span></label>
                                    <select name="marital_status" id="field_marital_status" class="input-custom-noicon">
                                        <option value="Never Married">Never Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Awaiting Divorce">Awaiting Divorce</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>Community / Caste <span class="required">*</span></label>
                                    <select name="caste" id="field_caste" class="input-custom-noicon">
                                        <option value="Sain / Nai">Sain / Nai (Sain Samaj)</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Sub Community / Clan</label>
                                    <input type="text" name="sub_caste" id="field_sub_caste" placeholder="e.g. Gill, Sandhu, Chopra" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Gotra (Optional)</label>
                                    <input type="text" name="gotra" id="field_gotra" placeholder="e.g. Gill, Dhillon" class="input-custom-noicon">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: LOCATION & CONTACT -->
                    <div class="step-pane" id="step2">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 2</span>
                            <h2 class="step-header-title">Location & Contact Information</h2>
                            <p class="step-header-desc">Provide valid contact details so interested matches can connect with you.</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Mobile / WhatsApp Number <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-phone"></i>
                                        <input type="tel" name="phone" id="field_phone" required placeholder="10-digit mobile number" class="input-custom">
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
                                    <label>Country</label>
                                    <input type="text" name="country" id="field_country" value="India" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>State</label>
                                    <input type="text" name="state" id="field_state" placeholder="e.g. Delhi, Punjab, Haryana" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>City / Location <span class="required">*</span></label>
                                    <input type="text" name="city" id="field_city" required placeholder="e.g. New Delhi, Ludhiana" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>Residential Address / Area</label>
                                <textarea name="address" id="field_address" rows="2" placeholder="House no, locality, colony..." class="textarea-custom"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: EDUCATION & PROFESSION -->
                    <div class="step-pane" id="step3">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 3</span>
                            <h2 class="step-header-title">Education & Profession</h2>
                            <p class="step-header-desc">Share candidate academic qualification and career details.</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Highest Qualification <span class="required">*</span></label>
                                    <select name="education" id="field_education" class="input-custom-noicon">
                                        <option value="Graduate">Graduate (B.Tech / B.A / B.Sc / B.Com)</option>
                                        <option value="Post Graduate">Post Graduate (M.Tech / M.A / M.Sc / MBA)</option>
                                        <option value="Doctorate / PhD">Doctorate / PhD</option>
                                        <option value="Medical / MBBS">Medical / MBBS / BDS</option>
                                        <option value="CA / CS / Finance">CA / CS / Finance</option>
                                        <option value="Diploma / ITI">Diploma / ITI</option>
                                        <option value="High School">High School / 12th</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>Education Details / Degree Name</label>
                                    <input type="text" name="education_detail" id="field_education_detail" placeholder="e.g. B.Tech Computer Science, MBA HR" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Occupation / Career <span class="required">*</span></label>
                                    <select name="occupation" id="field_occupation" class="input-custom-noicon">
                                        <option value="Private Job">Private Sector Job</option>
                                        <option value="Govt Job">Government / PSU Service</option>
                                        <option value="Business / Businessman">Business / Entrepreneur</option>
                                        <option value="Software Engineer / IT">Software Engineer / IT Professional</option>
                                        <option value="Doctor / Healthcare">Doctor / Healthcare Professional</option>
                                        <option value="Teacher / Academic">Teacher / Professor</option>
                                        <option value="Self Employed">Self Employed / Freelancer</option>
                                        <option value="Not Working">Not Working / Student</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>Company / Organization Name</label>
                                    <input type="text" name="organization" id="field_organization" placeholder="e.g. MNC Company, Govt Dept, Own Firm" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>Annual Income</label>
                                <select name="income" id="field_income" class="input-custom-noicon">
                                    <option value="Not Disclosed">Prefer not to disclose</option>
                                    <option value="3 to 5 Lakhs">INR 3 to 5 Lakhs PA</option>
                                    <option value="5 to 7 Lakhs">INR 5 to 7 Lakhs PA</option>
                                    <option value="7 to 10 Lakhs">INR 7 to 10 Lakhs PA</option>
                                    <option value="10 to 15 Lakhs">INR 10 to 15 Lakhs PA</option>
                                    <option value="15 to 25 Lakhs">INR 15 to 25 Lakhs PA</option>
                                    <option value="25+ Lakhs">INR 25+ Lakhs PA</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: FAMILY DETAILS -->
                    <div class="step-pane" id="step4">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 4</span>
                            <h2 class="step-header-title">Family Details</h2>
                            <p class="step-header-desc">Tell us about parents, siblings, and family background.</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Father's Name</label>
                                    <input type="text" name="father_name" id="field_father_name" placeholder="Father's full name" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Father's Occupation</label>
                                    <input type="text" name="father_occ" id="field_father_occ" placeholder="e.g. Businessman, Govt Officer, Retired" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Mother's Name</label>
                                    <input type="text" name="mother_name" id="field_mother_name" placeholder="Mother's full name" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Mother's Occupation</label>
                                    <input type="text" name="mother_occ" id="field_mother_occ" placeholder="e.g. Homemaker, Teacher, Govt Service" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Family Type</label>
                                    <select name="family_type" id="field_family_type" class="input-custom-noicon">
                                        <option value="Nuclear">Nuclear Family</option>
                                        <option value="Joint">Joint Family</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>Family Values</label>
                                    <select name="family_values" id="field_family_values" class="input-custom-noicon">
                                        <option value="Moderate">Moderate</option>
                                        <option value="Traditional">Traditional</option>
                                        <option value="Liberal">Liberal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Brothers (Count & Details)</label>
                                    <input type="text" name="brothers" id="field_brothers" placeholder="e.g. 1 Brother (Married)" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Sisters (Count & Details)</label>
                                    <input type="text" name="sisters" id="field_sisters" placeholder="e.g. 2 Sisters (1 Married, 1 Unmarried)" class="input-custom-noicon">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 5: PARTNER PREFERENCES -->
                    <div class="step-pane" id="step5">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 5</span>
                            <h2 class="step-header-title">Partner Preferences</h2>
                            <p class="step-header-desc">Specify what you are looking for in a prospective life partner.</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Preferred Age Range</label>
                                    <input type="text" name="partner_age" id="field_partner_age" placeholder="e.g. 22 - 27 years" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Preferred Height Range</label>
                                    <input type="text" name="partner_height" id="field_partner_height" placeholder="e.g. 5'2&quot; to 5'8&quot;" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group-custom">
                                    <label>Preferred Caste / Community</label>
                                    <input type="text" name="partner_caste" id="field_partner_caste" value="Sain / Nai / Open to All" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Preferred Education & Profession</label>
                                    <input type="text" name="partner_education" id="field_partner_education" placeholder="e.g. Graduate / IT Professional / Govt Job" class="input-custom-noicon">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>Preferred Location / City</label>
                                <input type="text" name="partner_location" id="field_partner_location" placeholder="e.g. Delhi NCR, Punjab, Willing to Relocate" class="input-custom-noicon">
                            </div>

                            <div class="form-group-custom">
                                <label>Special Expectations / Notes</label>
                                <textarea name="partner_notes" id="field_partner_notes" rows="2" placeholder="Any specific requirements regarding lifestyle, values, or family..." class="textarea-custom"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 6: PHOTOS & ADDITIONAL INFO -->
                    <div class="step-pane" id="step6">
                        <div class="step-header-box">
                            <span class="step-tag-pill">STEP 6</span>
                            <h2 class="step-header-title">Photos & Additional Information</h2>
                            <p class="step-header-desc">Upload candidate photo and fill horoscope / lifestyle preferences.</p>
                        </div>

                        <div style="display: grid; gap: 18px;">
                            <div class="form-group-custom">
                                <label>Profile Photo (Optional)</label>
                                <input type="file" name="photo" id="photoInput" accept="image/*" class="input-custom-noicon" style="padding: 9px;" onchange="handlePhotoSelect(this)">
                                <div class="photo-upload-preview" id="photoPreviewWrapper" style="display: none;">
                                    <img id="photoPreviewImg" src="" alt="Photo Preview" class="photo-preview-img">
                                    <div>
                                        <strong style="color: #0f172a; font-size: 13.5px; display: block;">Candidate Photo Selected</strong>
                                        <span style="color: #64748b; font-size: 12px;">This photo will be displayed on your verified profile.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid-3">
                                <div class="form-group-custom">
                                    <label>Manglik Status</label>
                                    <select name="manglik" id="field_manglik" class="input-custom-noicon">
                                        <option value="Non-Manglik">Non-Manglik</option>
                                        <option value="Manglik">Manglik</option>
                                        <option value="Anshik Manglik">Anshik Manglik</option>
                                        <option value="Don't Know">Don't Know</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label>Horoscope / Rashi</label>
                                    <input type="text" name="rashi" id="field_rashi" placeholder="e.g. Leo / Singh" class="input-custom-noicon">
                                </div>
                                <div class="form-group-custom">
                                    <label>Diet Preference</label>
                                    <select name="diet" id="field_diet" class="input-custom-noicon">
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Non-Vegetarian">Non-Vegetarian</option>
                                        <option value="Eggetarian">Eggetarian</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label>About Candidate (Short Bio)</label>
                                <textarea name="bio" id="field_bio" rows="3" placeholder="Write a brief introduction about nature, hobbies, family values..." class="textarea-custom"></textarea>
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
                                    <div class="review-item"><label>Caste / Gotra</label><span id="rev_caste_gotra">-</span></div>
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
    document.getElementById('rev_caste_gotra').innerText = getVal('field_caste') + (getVal('field_sub_caste', '') ? ` / ${getVal('field_sub_caste')}` : '');

    document.getElementById('rev_phone').innerText = getVal('field_phone');
    document.getElementById('rev_email').innerText = getVal('field_email');
    document.getElementById('rev_location').innerText = `${getVal('field_city')}, ${getVal('field_state', 'India')}`;

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
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>

