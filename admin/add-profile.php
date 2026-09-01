<?php
$page_title = "Add New Profile";
require_once __DIR__ . '/header.php';

$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id = trim($_POST['profile_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $gender = $_POST['gender'] ?? 'Female';
    $age = (int)($_POST['age'] ?? 25);
    $religion = trim($_POST['religion'] ?? 'Hindu');
    $caste = trim($_POST['caste'] ?? '');
    $state = trim($_POST['state'] ?? 'New Delhi');
    $city = trim($_POST['city'] ?? 'New Delhi');
    $education = trim($_POST['education'] ?? 'Graduate');
    $occupation = trim($_POST['occupation'] ?? 'Professional');
    $is_premium = isset($_POST['is_premium']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';

    // Handle Photo Upload
    $photo = 'shlini.jpg'; // default fallback
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = time() . '_' . md5($fileName) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../images/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $photo = $newFileName;
            }
        }
    }

    if ($name && $profile_id && $caste) {
        try {
            $stmt = $pdo->prepare("INSERT INTO profiles (profile_id, name, gender, age, religion, caste, state, city, education, occupation, photo, is_premium, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$profile_id, $name, $gender, $age, $religion, $caste, $state, $city, $education, $occupation, $photo, $is_premium, $status]);
            $msg = "New Profile added successfully!";
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

<div style="background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    
    <?php if ($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fa fa-check-circle"></i> <?php echo $msg; ?>
            <a href="profiles.php" style="margin-left: 15px; color: #155724; font-weight: 700;">View Profiles List &rarr;</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="add-profile.php" method="POST" enctype="multipart/form-data" style="display: grid; gap: 20px;">
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Profile ID *</label>
                <input type="text" name="profile_id" value="<?php echo $next_id; ?>" required class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Candidate Full Name *</label>
                <input type="text" name="name" required placeholder="e.g. Shlini Singh" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Gender *</label>
                <select name="gender" style="background: #fff; color: #333; border: 1px solid #ccc;">
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
            <div class="form-group">
                <label style="color: #333;">Age *</label>
                <input type="number" name="age" value="25" min="18" max="70" required class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Religion</label>
                <input type="text" name="religion" value="Hindu" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Caste *</label>
                <input type="text" name="caste" required placeholder="e.g. Rajput, Brahmin" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">State</label>
                <input type="text" name="state" value="New Delhi" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">City</label>
                <input type="text" name="city" value="New Delhi" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Education Qualification</label>
                <input type="text" name="education" placeholder="e.g. B.Tech / MBA" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Occupation / Profession</label>
                <input type="text" name="occupation" placeholder="e.g. Software Engineer" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; align-items: center;">
            <div class="form-group">
                <label style="color: #333;">Profile Image (Photo)</label>
                <input type="file" name="photo" accept="image/*" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Status</label>
                <select name="status" style="background: #fff; color: #333; border: 1px solid #ccc;">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div style="padding-top: 10px;">
            <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; color: #333;">
                <input type="checkbox" name="is_premium" value="1" checked style="width: 18px; height: 18px;"> Set as Premium Profile (Displays on Homepage)
            </label>
        </div>

        <div style="margin-top: 15px; display: flex; gap: 15px;">
            <button type="submit" class="btn-red" style="padding: 12px 25px; font-size: 16px;"><i class="fa fa-save"></i> Save Profile</button>
            <a href="profiles.php" class="btn-outline" style="color: #333 !important; border-color: #ccc; padding: 12px 20px;">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
