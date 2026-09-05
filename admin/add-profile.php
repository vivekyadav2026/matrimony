<?php
$page_title = "Add New Candidate Profile";
require_once __DIR__ . '/header.php';

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
    $occupation = trim($_POST['occupation'] ?? 'Software Engineer');

    // Personal Details
    $marital_status = trim($_POST['marital_status'] ?? 'Never Married');
    $height = trim($_POST['height'] ?? '5\'8" - 173 Cm');
    $weight = trim($_POST['weight'] ?? '70 kg');
    $complexion = trim($_POST['complexion'] ?? 'Wheatish');
    $diet = trim($_POST['diet'] ?? 'Veg / Non-Veg');
    $manglik = trim($_POST['manglik'] ?? 'Non-Manglik');
    $mother_tongue = trim($_POST['mother_tongue'] ?? 'Punjabi');

    // Career Details
    $education_detail = trim($_POST['education_detail'] ?? '');
    $organization = trim($_POST['organization'] ?? '');
    $income = trim($_POST['income'] ?? '15-22 LPA');
    $work_location = trim($_POST['work_location'] ?? '');

    // Family Details
    $sub_caste = trim($_POST['sub_caste'] ?? '');
    $gotra = trim($_POST['gotra'] ?? '');
    $father_occ = trim($_POST['father_occ'] ?? '');
    $mother_occ = trim($_POST['mother_occ'] ?? '');
    $siblings = trim($_POST['siblings'] ?? '');
    $family_type = trim($_POST['family_type'] ?? 'Nuclear Family');
    $family_values = trim($_POST['family_values'] ?? 'Moderate & Traditional');

    // Partner Preferences
    $partner_age = trim($_POST['partner_age'] ?? '24 - 30');
    $partner_height = trim($_POST['partner_height'] ?? '');
    $partner_caste = trim($_POST['partner_caste'] ?? 'Sain / Nai');
    $partner_education = trim($_POST['partner_education'] ?? 'Graduate / Masters');
    $partner_location = trim($_POST['partner_location'] ?? 'Punjab / Delhi NCR');
    $partner_notes = trim($_POST['partner_notes'] ?? '');

    $is_premium = isset($_POST['is_premium']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';

    // Handle Photo Upload
    $photo = 'shlini.jpg';
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
            $stmt = $pdo->prepare("INSERT INTO profiles 
                (profile_id, name, gender, mobile, age, religion, caste, state, city, education, occupation, photo, is_premium, status,
                 marital_status, height, weight, complexion, diet, manglik, mother_tongue, education_detail, organization, income, work_location,
                 sub_caste, gotra, father_occ, mother_occ, siblings, family_type, family_values, partner_age, partner_height, partner_caste, partner_education, partner_location, partner_notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $profile_id, $name, $gender, $mobile, $age, $religion, $caste, $state, $city, $education, $occupation, $photo, $is_premium, $status,
                $marital_status, $height, $weight, $complexion, $diet, $manglik, $mother_tongue, $education_detail, $organization, $income, $work_location,
                $sub_caste, $gotra, $father_occ, $mother_occ, $siblings, $family_type, $family_values, $partner_age, $partner_height, $partner_caste, $partner_education, $partner_location, $partner_notes
            ]);
            $msg = "New Candidate Profile added successfully!";
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in Profile ID, Name, and Caste.";
    }
}

// Generate Auto Profile ID suggestion
$next_id = 'M' . (rand(100, 999));
?>

<div style="background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; border: 1px solid #e2e8f0;">
    
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

    <form action="add-profile.php" method="POST" enctype="multipart/form-data" style="display: grid; gap: 25px;">
        
        <!-- SECTION 1: BASIC INFORMATION -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-id-card"></i> Basic Profile Details
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Profile ID *</label>
                    <input type="text" name="profile_id" value="<?php echo $next_id; ?>" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Candidate Full Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Gurpreet Singh" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Gender *</label>
                    <select name="gender" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Male">Male (Groom)</option>
                        <option value="Female">Female (Bride)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Mobile Number (Admin Only)</label>
                    <input type="text" name="mobile" placeholder="e.g. 9876543210" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Age (Years) *</label>
                    <input type="number" name="age" value="25" min="18" max="75" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Religion</label>
                    <input type="text" name="religion" value="Hindu / Sikh" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Caste / Community *</label>
                    <select name="caste" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Sain / Nai">Sain / Nai (Sain Samaj)</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">City</label>
                    <input type="text" name="city" value="Amritsar" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">State</label>
                    <input type="text" name="state" value="Punjab" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
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
                        <option value="Never Married">Never Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Height</label>
                    <input type="text" name="height" value="5'10&quot; - 178 Cm" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Weight</label>
                    <input type="text" name="weight" value="72 kg" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Complexion</label>
                    <input type="text" name="complexion" value="Wheatish" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Diet</label>
                    <input type="text" name="diet" value="Veg / Non-Veg" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Manglik Status</label>
                    <select name="manglik" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Non-Manglik">Non-Manglik</option>
                        <option value="Manglik">Manglik</option>
                        <option value="Anshik Manglik">Anshik Manglik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Mother Tongue</label>
                    <input type="text" name="mother_tongue" value="Punjabi" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
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
                    <input type="text" name="education" value="Graduate" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Education Details</label>
                    <input type="text" name="education_detail" placeholder="e.g. B.Tech — Computer Science" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Occupation / Role</label>
                    <input type="text" name="occupation" value="Software Engineer" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Organization / Company</label>
                    <input type="text" name="organization" placeholder="e.g. IT Services company" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Annual Income</label>
                    <input type="text" name="income" value="15-22 LPA" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
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
                    <input type="text" name="sub_caste" value="Sandhu" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Gotra</label>
                    <input type="text" name="gotra" value="Gill" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Family Type</label>
                    <input type="text" name="family_type" value="Nuclear Family" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Father's Occupation</label>
                    <input type="text" name="father_occ" value="Retired Government Officer" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Mother's Occupation</label>
                    <input type="text" name="mother_occ" value="Homemaker" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Siblings</label>
                    <input type="text" name="siblings" value="1 Sister (Married)" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 5: PARTNER PREFERENCES -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-heart"></i> Partner Preferences
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Age</label>
                    <input type="text" name="partner_age" value="24 - 30" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Education</label>
                    <input type="text" name="partner_education" value="Graduate / Masters" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Location</label>
                    <input type="text" name="partner_location" value="Punjab / Delhi NCR" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div class="form-group">
                <label style="color: #334155; font-size: 13px;">Looking For / Notes</label>
                <textarea name="partner_notes" rows="2" placeholder="Educated, caring, family-oriented partner..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;"></textarea>
            </div>
        </div>

        <!-- SECTION 6: PHOTO & CONTROL -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; align-items: center;">
            <div class="form-group">
                <label style="color: #334155; font-weight: 600; font-size: 13px;">Profile Image (Photo)</label>
                <input type="file" name="photo" id="adminPhotoInput" accept="image/*" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
            </div>
            <div class="form-group">
                <label style="color: #334155; font-weight: 600; font-size: 13px;">Status</label>
                <select name="status" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div style="padding-top: 5px;">
            <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; color: #334155;">
                <input type="checkbox" name="is_premium" value="1" checked style="width: 18px; height: 18px;"> Set as Premium Profile (Displays on Homepage)
            </label>
        </div>

        <div style="margin-top: 15px; display: flex; gap: 15px;">
            <button type="submit" class="btn-red" style="padding: 12px 28px; font-size: 15px;"><i class="fa fa-save"></i> Save Profile Details</button>
            <a href="profiles.php" class="btn-outline" style="color: #475569 !important; border-color: #cbd5e1; padding: 12px 22px;">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

