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
    $dob = trim($_POST['dob'] ?? '');
    $time_of_birth = trim($_POST['time_of_birth'] ?? '');
    $place_of_birth = trim($_POST['place_of_birth'] ?? '');
    $religion = trim($_POST['religion'] ?? 'Hindu');
    $caste = trim($_POST['caste'] ?? 'Sain / Nai');
    $state = trim($_POST['state'] ?? 'Punjab');
    $city = trim($_POST['city'] ?? 'Amritsar');
    $district = trim($_POST['district'] ?? '');
    $tehsil_post = trim($_POST['tehsil_post'] ?? '');
    $address = trim($_POST['address'] ?? '');
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
    $father_name = trim($_POST['father_name'] ?? '');
    $father_occ = trim($_POST['father_occ'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $mother_occ = trim($_POST['mother_occ'] ?? '');
    $family_gotra = trim($_POST['family_gotra'] ?? '');
    $mother_gotra = trim($_POST['mother_gotra'] ?? '');
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
    $manglik_required = trim($_POST['manglik_required'] ?? '');
    $note = trim($_POST['note'] ?? '');

    $is_premium = isset($_POST['is_premium']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';

    // Handle Photo Upload
    $photo = 'default.jpg';
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
                (profile_id, name, gender, mobile, age, dob, time_of_birth, place_of_birth, religion, caste, state, city, district, tehsil_post, address, education, occupation, photo, is_premium, status,
                 marital_status, height, weight, complexion, diet, manglik, mother_tongue, education_detail, organization, income, work_location,
                 sub_caste, gotra, father_name, father_occ, mother_name, mother_occ, family_gotra, mother_gotra, siblings, family_type, family_values, partner_age, partner_height, partner_caste, partner_education, partner_location, partner_notes, manglik_required, note) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $profile_id, $name, $gender, $mobile, $age, $dob, $time_of_birth, $place_of_birth, $religion, $caste, $state, $city, $district, $tehsil_post, $address, $education, $occupation, $photo, $is_premium, $status,
                $marital_status, $height, $weight, $complexion, $diet, $manglik, $mother_tongue, $education_detail, $organization, $income, $work_location,
                $sub_caste, $gotra, $father_name, $father_occ, $mother_name, $mother_occ, $family_gotra, $mother_gotra, $siblings, $family_type, $family_values, $partner_age, $partner_height, $partner_caste, $partner_education, $partner_location, $partner_notes, $manglik_required, $note
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
$next_id = 'SAIN' . (rand(10000, 99999));
?>

<div style="background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; border: 1px solid #e2e8f0;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
        <h3 style="margin: 0; color: #0f172a; font-size: 20px;"><i class="fa fa-user-plus" style="color: var(--primary-red);"></i> Add New Candidate Profile</h3>
        <a href="profiles.php" class="btn-outline btn-sm" style="color: #64748b !important; border-color: #cbd5e1;"><i class="fa fa-arrow-left"></i> Back to Profiles List</a>
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

    <form action="add-profile.php" method="POST" enctype="multipart/form-data" style="display: grid; gap: 25px;">
        
        <!-- SECTION 1: BASIC INFORMATION -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-id-card"></i> Basic Profile Details
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Profile ID *</label>
                    <input type="text" name="profile_id" value="<?php echo htmlspecialchars($next_id); ?>" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Candidate Full Name *</label>
                    <input type="text" name="name" required placeholder="Full Name" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Gender *</label>
                    <select name="gender" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Female">Female (Bride)</option>
                        <option value="Male">Male (Groom)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Mobile Number</label>
                    <input type="text" name="mobile" placeholder="e.g. 9876543210" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Date of Birth</label>
                    <input type="date" name="dob" id="add_field_dob" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;" onchange="calculateAgeFromDOB(this.value)">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Age (Years) *</label>
                    <input type="number" name="age" id="add_field_age" value="25" min="18" max="75" required class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Time of Birth</label>
                    <input type="text" name="time_of_birth" placeholder="e.g. 10:30 AM" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Place of Birth</label>
                    <input type="text" name="place_of_birth" placeholder="e.g. Amritsar" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Religion</label>
                    <input type="text" name="religion" value="Hindu" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Caste / Community *</label>
                    <select name="caste" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="Nai">Nai</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">District</label>
                    <input type="text" name="district" placeholder="e.g. Amritsar" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Tehsil / Post</label>
                    <input type="text" name="tehsil_post" placeholder="e.g. Tehsil Ajnala" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">City</label>
                    <input type="text" name="city" placeholder="e.g. Amritsar" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">State</label>
                    <input type="text" name="state" value="Punjab" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label style="color: #334155; font-weight: 600; font-size: 13px;">Full Address</label>
                <textarea name="address" rows="2" placeholder="House No, Street, Village/Locality..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;"></textarea>
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
                    <input type="text" name="height" placeholder="e.g. 5'8&quot; - 173 Cm" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Weight</label>
                    <input type="text" name="weight" placeholder="e.g. 70 kg" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Complexion</label>
                    <input type="text" name="complexion" placeholder="Fair / Wheatish" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Diet</label>
                    <input type="text" name="diet" placeholder="Veg / Non-Veg" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
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
                    <input type="text" name="mother_tongue" placeholder="Punjabi / Hindi" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
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
                    <input type="text" name="education" placeholder="e.g. B.Tech / MBA" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Education Details</label>
                    <input type="text" name="education_detail" placeholder="e.g. B.Tech — Computer Science" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Occupation / Role</label>
                    <input type="text" name="occupation" placeholder="e.g. Software Engineer" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Organization / Company</label>
                    <input type="text" name="organization" placeholder="e.g. IT Services company" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Annual Income</label>
                    <input type="text" name="income" placeholder="e.g. 12-15 LPA" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Work Location</label>
                    <input type="text" name="work_location" placeholder="e.g. Mohali / Chandigarh" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>
        </div>

        <!-- SECTION 4: FAMILY DETAILS -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-users"></i> Family Background
            </h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Father's Name</label>
                    <input type="text" name="father_name" placeholder="Father Name" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Father's Occupation</label>
                    <input type="text" name="father_occ" placeholder="Father Occupation" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Mother's Name</label>
                    <input type="text" name="mother_name" placeholder="Mother Name" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Mother's Occupation</label>
                    <input type="text" name="mother_occ" placeholder="Mother Occupation" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Dadke Gotra (Father's Gotra)</label>
                    <input type="text" name="gotra" placeholder="e.g. Gill" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Nanke Gotra (Mother's Gotra)</label>
                    <input type="text" name="mother_gotra" placeholder="e.g. Dhillon" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Family Gotra</label>
                    <input type="text" name="family_gotra" placeholder="e.g. Sandhu" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Siblings</label>
                    <input type="text" name="siblings" placeholder="e.g. 1 Brother, 1 Sister" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
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
                    <input type="text" name="partner_age" placeholder="e.g. 24 - 30" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Height</label>
                    <input type="text" name="partner_height" placeholder="e.g. 5'2&quot; - 5'8&quot;" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Manglik Match Needed</label>
                    <select name="manglik_required" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="ਹਾਂ">Yes (ਹਾਂ)</option>
                        <option value="ਨਹੀਂ">No (ਨਹੀਂ)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Education</label>
                    <input type="text" name="partner_education" placeholder="e.g. Graduate / Masters" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Preferred Location</label>
                    <input type="text" name="partner_location" placeholder="e.g. Punjab / Delhi NCR" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-size: 13px;">Looking For / Notes</label>
                    <input type="text" name="partner_notes" placeholder="Educated, caring, family-oriented partner..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label style="color: #334155; font-weight: 600; font-size: 13px;">Admin Special Note</label>
                <textarea name="note" rows="2" placeholder="Write any specific admin notes..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;"></textarea>
            </div>
        </div>

        <!-- SECTION 6: PHOTO & CONTROL -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h4 style="margin: 0 0 15px; color: var(--primary-red); font-size: 16px; font-weight: 700; border-bottom: 2px solid var(--primary-red); padding-bottom: 6px; display: inline-block;">
                <i class="fa fa-cog"></i> Profile Photo & Visibility Settings
            </h4>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; align-items: center;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Profile Image (Photo)</label>
                    <input type="file" name="photo" id="adminPhotoInput" accept="image/*" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                </div>
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px;">Status</label>
                    <select name="status" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1;">
                        <option value="active">Active (Published)</option>
                        <option value="inactive">Inactive (Pending / Hidden)</option>
                    </select>
                </div>
            </div>
        </div>

        <div style="margin-top: 10px; display: flex; gap: 15px;">
            <button type="submit" class="btn-red" style="padding: 12px 28px; font-size: 15px;"><i class="fa fa-save"></i> Save Profile Details</button>
            <a href="profiles.php" class="btn-outline" style="color: #475569 !important; border-color: #cbd5e1; padding: 12px 22px;">Cancel</a>
        </div>
    </form>
</div>

<script>
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
    const ageInput = document.getElementById('add_field_age');
    if (ageInput && !isNaN(age) && age > 0) {
        ageInput.value = age;
    }
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
