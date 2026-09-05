<?php
$page_title = "Edit Candidate Profile";
require_once __DIR__ . '/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = ?");
$stmt->execute([$id]);
$profile = $stmt->fetch();

if (!$profile) {
    header("Location: profiles.php");
    exit;
}

$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id = trim($_POST['profile_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $gender = $_POST['gender'] ?? 'Female';
    $mobile = trim($_POST['mobile'] ?? '');
    $age = (int)($_POST['age'] ?? 25);
    $religion = trim($_POST['religion'] ?? 'Hindu');
    $caste = trim($_POST['caste'] ?? 'Sain / Nai');
    $state = trim($_POST['state'] ?? 'Punjab');
    $city = trim($_POST['city'] ?? 'Amritsar');
    $education = trim($_POST['education'] ?? 'Graduate');
    $occupation = trim($_POST['occupation'] ?? 'Professional');

    // Personal Details
    $marital_status = trim($_POST['marital_status'] ?? 'Never Married');
    $height = trim($_POST['height'] ?? '');
    $weight = trim($_POST['weight'] ?? '');
    $complexion = trim($_POST['complexion'] ?? '');
    $diet = trim($_POST['diet'] ?? '');
    $manglik = trim($_POST['manglik'] ?? 'Non-Manglik');
    $mother_tongue = trim($_POST['mother_tongue'] ?? '');

    // Career Details
    $education_detail = trim($_POST['education_detail'] ?? '');
    $organization = trim($_POST['organization'] ?? '');
    $income = trim($_POST['income'] ?? '');
    $work_location = trim($_POST['work_location'] ?? '');

    // Family Details
    $sub_caste = trim($_POST['sub_caste'] ?? '');
    $gotra = trim($_POST['gotra'] ?? '');
    $father_occ = trim($_POST['father_occ'] ?? '');
    $mother_occ = trim($_POST['mother_occ'] ?? '');
    $siblings = trim($_POST['siblings'] ?? '');
    $family_type = trim($_POST['family_type'] ?? '');
    $family_values = trim($_POST['family_values'] ?? '');

    // Partner Preferences
    $partner_age = trim($_POST['partner_age'] ?? '');
    $partner_height = trim($_POST['partner_height'] ?? '');
    $partner_caste = trim($_POST['partner_caste'] ?? 'Sain / Nai');
    $partner_education = trim($_POST['partner_education'] ?? '');
    $partner_location = trim($_POST['partner_location'] ?? '');
    $partner_notes = trim($_POST['partner_notes'] ?? '');

    $is_premium = isset($_POST['is_premium']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';

    $photo = $profile['photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'candidate_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../images/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $photo = $newFileName;
            }
        }
    }

    if ($name && $profile_id && $caste) {
        try {
            $up = $pdo->prepare("UPDATE profiles SET 
                profile_id = ?, name = ?, gender = ?, mobile = ?, age = ?, religion = ?, caste = ?, state = ?, city = ?, 
                education = ?, occupation = ?, photo = ?, is_premium = ?, status = ?,
                marital_status = ?, height = ?, weight = ?, complexion = ?, diet = ?, manglik = ?, mother_tongue = ?,
                education_detail = ?, organization = ?, income = ?, work_location = ?,
                sub_caste = ?, gotra = ?, father_occ = ?, mother_occ = ?, siblings = ?, family_type = ?, family_values = ?,
                partner_age = ?, partner_height = ?, partner_caste = ?, partner_education = ?, partner_location = ?, partner_notes = ?
                WHERE id = ?");
            $up->execute([
                $profile_id, $name, $gender, $mobile, $age, $religion, $caste, $state, $city, 
                $education, $occupation, $photo, $is_premium, $status,
                $marital_status, $height, $weight, $complexion, $diet, $manglik, $mother_tongue,
                $education_detail, $organization, $income, $work_location,
                $sub_caste, $gotra, $father_occ, $mother_occ, $siblings, $family_type, $family_values,
                $partner_age, $partner_height, $partner_caste, $partner_education, $partner_location, $partner_notes,
                $id
            ]);
            $msg = "Candidate Profile updated successfully!";

            // Refresh Profile
            $stmt->execute([$id]);
            $profile = $stmt->fetch();
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in Profile ID, Name, and Caste.";
    }
}
?>

<div style="background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; border: 1px solid #e2e8f0;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
        <div>
            <h3 style="margin: 0; color: #0f172a; font-size: 20px;"><i class="fa fa-user-edit" style="color: var(--primary-red);"></i> Edit Candidate: <?php echo htmlspecialchars($profile['name']); ?></h3>
            <span style="font-size: 13px; color: #64748b;">Profile ID: <strong><?php echo htmlspecialchars($profile['profile_id']); ?></strong></span>
        </div>
        <div>
            <a href="../profile.php?id=<?php echo $profile['id']; ?>" target="_blank" class="btn-outline btn-sm" style="color: #0284c7 !important; border-color: #38bdf8; padding: 6px 14px;"><i class="fa fa-eye"></i> View Live Profile</a>
            <a href="profiles.php" class="btn-outline btn-sm" style="color: #64748b !important; border-color: #cbd5e1; padding: 6px 14px; margin-left: 8px;"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>

    <?php if ($msg): ?>
        <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0; display: flex; align-items: center; justify-content: space-between;">
            <div><i class="fa fa-check-circle" style="color: #22c55e;"></i> <?php echo $msg; ?></div>
            <a href="profiles.php" style="color: #15803d; font-weight: 700; text-decoration: none;">View Profiles List &rarr;</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background: #fef2f2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
            <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="edit-profile.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" style="display: grid; gap: 25px;">
        
        <!-- SECTION 1: BASIC INFORMATION -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-id-card"></i> Basic Profile Details
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Profile ID *</label>
                    <input type="text" name="profile_id" value="<?php echo htmlspecialchars($profile['profile_id']); ?>" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Candidate Full Name *</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Gender *</label>
                    <select name="gender" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Female" <?php echo ($profile['gender'] == 'Female') ? 'selected' : ''; ?>>Female (Bride)</option>
                        <option value="Male" <?php echo ($profile['gender'] == 'Male') ? 'selected' : ''; ?>>Male (Groom)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Mobile Number (Admin Only)</label>
                    <input type="text" name="mobile" value="<?php echo htmlspecialchars($profile['mobile'] ?? ''); ?>" placeholder="e.g. 9876543210" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Age (Years) *</label>
                    <input type="number" name="age" value="<?php echo htmlspecialchars($profile['age']); ?>" min="18" max="75" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Religion</label>
                    <input type="text" name="religion" value="<?php echo htmlspecialchars($profile['religion']); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Caste / Community *</label>
                    <select name="caste" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Sain / Nai" <?php echo (in_array(strtolower($profile['caste']), ['sain', 'nai', 'sain/nai', 'sain / nai'])) ? 'selected' : ''; ?>>Sain / Nai (Sain Samaj)</option>
                        <option value="Others" <?php echo ($profile['caste'] == 'Others' || $profile['caste'] == 'Other Community') ? 'selected' : ''; ?>>Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">City</label>
                    <input type="text" name="city" value="<?php echo htmlspecialchars($profile['city']); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">State</label>
                    <input type="text" name="state" value="<?php echo htmlspecialchars($profile['state']); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 2: PERSONAL DETAILS -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-user"></i> Personal Attributes
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Marital Status</label>
                    <select name="marital_status" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Never Married" <?php echo (($profile['marital_status'] ?? '') == 'Never Married') ? 'selected' : ''; ?>>Never Married</option>
                        <option value="Divorced" <?php echo (($profile['marital_status'] ?? '') == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                        <option value="Widowed" <?php echo (($profile['marital_status'] ?? '') == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Height</label>
                    <input type="text" name="height" value="<?php echo htmlspecialchars($profile['height'] ?? ''); ?>" placeholder="e.g. 5'8&quot; - 173 Cm" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Weight</label>
                    <input type="text" name="weight" value="<?php echo htmlspecialchars($profile['weight'] ?? ''); ?>" placeholder="e.g. 70 kg" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Complexion</label>
                    <input type="text" name="complexion" value="<?php echo htmlspecialchars($profile['complexion'] ?? ''); ?>" placeholder="Fair / Wheatish" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Diet</label>
                    <input type="text" name="diet" value="<?php echo htmlspecialchars($profile['diet'] ?? ''); ?>" placeholder="Veg / Non-Veg" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Manglik Status</label>
                    <select name="manglik" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Non-Manglik" <?php echo (($profile['manglik'] ?? '') == 'Non-Manglik') ? 'selected' : ''; ?>>Non-Manglik</option>
                        <option value="Manglik" <?php echo (($profile['manglik'] ?? '') == 'Manglik') ? 'selected' : ''; ?>>Manglik</option>
                        <option value="Anshik Manglik" <?php echo (($profile['manglik'] ?? '') == 'Anshik Manglik') ? 'selected' : ''; ?>>Anshik Manglik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Mother Tongue</label>
                    <input type="text" name="mother_tongue" value="<?php echo htmlspecialchars($profile['mother_tongue'] ?? ''); ?>" placeholder="Punjabi / Hindi" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 3: CAREER & EDUCATION -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-briefcase"></i> Career & Education
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Education Degree</label>
                    <input type="text" name="education" value="<?php echo htmlspecialchars($profile['education']); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Education Details</label>
                    <input type="text" name="education_detail" value="<?php echo htmlspecialchars($profile['education_detail'] ?? ''); ?>" placeholder="e.g. B.Tech — Computer Science" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Occupation / Role</label>
                    <input type="text" name="occupation" value="<?php echo htmlspecialchars($profile['occupation']); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Organization / Company</label>
                    <input type="text" name="organization" value="<?php echo htmlspecialchars($profile['organization'] ?? ''); ?>" placeholder="e.g. IT Services company" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Annual Income</label>
                    <input type="text" name="income" value="<?php echo htmlspecialchars($profile['income'] ?? ''); ?>" placeholder="e.g. 12-15 LPA" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Work Location</label>
                    <input type="text" name="work_location" value="<?php echo htmlspecialchars($profile['work_location'] ?? ''); ?>" placeholder="e.g. Mohali / Chandigarh" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 4: FAMILY DETAILS -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-users"></i> Family Background
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Sub Community / Clan</label>
                    <input type="text" name="sub_caste" value="<?php echo htmlspecialchars($profile['sub_caste'] ?? ''); ?>" placeholder="e.g. Sandhu" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Gotra</label>
                    <input type="text" name="gotra" value="<?php echo htmlspecialchars($profile['gotra'] ?? ''); ?>" placeholder="e.g. Gill" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Family Type</label>
                    <input type="text" name="family_type" value="<?php echo htmlspecialchars($profile['family_type'] ?? ''); ?>" placeholder="e.g. Nuclear Family" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Father's Occupation</label>
                    <input type="text" name="father_occ" value="<?php echo htmlspecialchars($profile['father_occ'] ?? ''); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Mother's Occupation</label>
                    <input type="text" name="mother_occ" value="<?php echo htmlspecialchars($profile['mother_occ'] ?? ''); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Siblings</label>
                    <input type="text" name="siblings" value="<?php echo htmlspecialchars($profile['siblings'] ?? ''); ?>" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Family Values</label>
                    <input type="text" name="family_values" value="<?php echo htmlspecialchars($profile['family_values'] ?? ''); ?>" placeholder="e.g. Moderate & Traditional" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 5: PARTNER PREFERENCES -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-heart"></i> Partner Preferences
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Age</label>
                    <input type="text" name="partner_age" value="<?php echo htmlspecialchars($profile['partner_age'] ?? ''); ?>" placeholder="e.g. 24 - 30" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Height</label>
                    <input type="text" name="partner_height" value="<?php echo htmlspecialchars($profile['partner_height'] ?? ''); ?>" placeholder="e.g. 5'2&quot; - 5'8&quot;" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Caste</label>
                    <select name="partner_caste" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Sain / Nai" <?php echo (($profile['partner_caste'] ?? '') == 'Sain / Nai' || (in_array(strtolower($profile['partner_caste'] ?? ''), ['sain', 'nai']))) ? 'selected' : ''; ?>>Sain / Nai (Sain Samaj)</option>
                        <option value="Others" <?php echo (($profile['partner_caste'] ?? '') == 'Others') ? 'selected' : ''; ?>>Others / Any</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Education</label>
                    <input type="text" name="partner_education" value="<?php echo htmlspecialchars($profile['partner_education'] ?? ''); ?>" placeholder="e.g. Graduate / Masters" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Location</label>
                    <input type="text" name="partner_location" value="<?php echo htmlspecialchars($profile['partner_location'] ?? ''); ?>" placeholder="e.g. Punjab / Delhi NCR" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Looking For / Notes</label>
                    <input type="text" name="partner_notes" value="<?php echo htmlspecialchars($profile['partner_notes'] ?? ''); ?>" placeholder="Educated, caring, family-oriented partner..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 6: PHOTO & CONTROL -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-cog"></i> Profile Photo & Visibility Settings
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr 1fr; gap: 15px; align-items: center;">
                <div style="text-align: center;">
                    <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">Current Photo</label>
                    <img src="../images/<?php echo htmlspecialchars($profile['photo']); ?>" alt="" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-red);">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Change Profile Photo</label>
                    <input type="file" name="photo" id="adminPhotoInput" accept="image/*" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                    <small style="color: #64748b;">Leave blank to keep existing photo.</small>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Status</label>
                    <select name="status" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="active" <?php echo ($profile['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($profile['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div style="padding-top: 15px; border-top: 1px solid #e2e8f0; margin-top: 15px;">
                <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; color: #334155;">
                    <input type="checkbox" name="is_premium" value="1" <?php echo $profile['is_premium'] ? 'checked' : ''; ?> style="width: 18px; height: 18px;"> Set as Premium Profile (Displays on Homepage Slider)
                </label>
            </div>
        </div>

        <div style="margin-top: 10px; display: flex; gap: 15px;">
            <button type="submit" class="btn-red" style="padding: 12px 28px; font-size: 15px;"><i class="fa fa-save"></i> Save Profile Changes</button>
            <a href="profiles.php" class="btn-outline" style="color: #475569 !important; border-color: #cbd5e1; padding: 12px 22px;">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

            <div class="form-group">
                <label style="color: #333;">Change Photo (Current: <?php echo htmlspecialchars($profile['photo']); ?>)</label>
                <input type="file" name="photo" id="adminPhotoInput" accept="image/*" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
                <div id="adminImagePreviewBox" style="margin-top: 10px; display: flex; align-items: center; gap: 10px; background: #f8fafc; padding: 8px; border-radius: 6px; border: 1px dashed #cbd5e1;">
                    <img id="adminImagePreview" src="../images/<?php echo htmlspecialchars($profile['photo']); ?>" alt="Preview" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 2px solid #0284c7;">
                    <span style="font-size: 12px; color: #333; font-weight: 600;"><i class="fa fa-image"></i> Current / Selected Photo Preview</span>
                </div>
            </div>
            <div class="form-group">
                <label style="color: #333;">Status</label>
                <select name="status" style="background: #fff; color: #333; border: 1px solid #ccc;">
                    <option value="active" <?php echo ($profile['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($profile['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div style="padding-top: 10px;">
            <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; color: #333;">
                <input type="checkbox" name="is_premium" value="1" <?php echo ($profile['is_premium']) ? 'checked' : ''; ?> style="width: 18px; height: 18px;"> Set as Premium Profile
            </label>
        </div>

        <div style="margin-top: 15px; display: flex; gap: 15px;">
            <button type="submit" class="btn-red" style="padding: 12px 25px; font-size: 16px;"><i class="fa fa-save"></i> Update Profile</button>
            <a href="profiles.php" class="btn-outline" style="color: #333 !important; border-color: #ccc; padding: 12px 20px;">Back</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
