<?php
$page_title = "Edit Profile";
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
    $age = (int)($_POST['age'] ?? 25);
    $religion = trim($_POST['religion'] ?? 'Hindu');
    $caste = trim($_POST['caste'] ?? '');
    $state = trim($_POST['state'] ?? 'New Delhi');
    $city = trim($_POST['city'] ?? 'New Delhi');
    $education = trim($_POST['education'] ?? 'Graduate');
    $occupation = trim($_POST['occupation'] ?? 'Professional');
    $is_premium = isset($_POST['is_premium']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';

    $photo = $profile['photo'];

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
            $up = $pdo->prepare("UPDATE profiles SET profile_id = ?, name = ?, gender = ?, age = ?, religion = ?, caste = ?, state = ?, city = ?, education = ?, occupation = ?, photo = ?, is_premium = ?, status = ? WHERE id = ?");
            $up->execute([$profile_id, $name, $gender, $age, $religion, $caste, $state, $city, $education, $occupation, $photo, $is_premium, $status, $id]);
            $msg = "Profile updated successfully!";

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

<div style="background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    
    <?php if ($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fa fa-check-circle"></i> <?php echo $msg; ?>
            <a href="profiles.php" style="margin-left: 15px; color: #155724; font-weight: 700;">Back to Profiles List &rarr;</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="edit-profile.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" style="display: grid; gap: 20px;">
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Profile ID *</label>
                <input type="text" name="profile_id" value="<?php echo htmlspecialchars($profile['profile_id']); ?>" required class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Candidate Full Name *</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" required class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Gender *</label>
                <select name="gender" style="background: #fff; color: #333; border: 1px solid #ccc;">
                    <option value="Female" <?php echo ($profile['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Male" <?php echo ($profile['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                </select>
            </div>
            <div class="form-group">
                <label style="color: #333;">Age *</label>
                <input type="number" name="age" value="<?php echo htmlspecialchars($profile['age']); ?>" min="18" max="70" required class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Religion</label>
                <input type="text" name="religion" value="<?php echo htmlspecialchars($profile['religion']); ?>" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Caste *</label>
                <input type="text" name="caste" value="<?php echo htmlspecialchars($profile['caste']); ?>" required class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">State</label>
                <input type="text" name="state" value="<?php echo htmlspecialchars($profile['state']); ?>" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">City</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($profile['city']); ?>" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #333;">Education</label>
                <input type="text" name="education" value="<?php echo htmlspecialchars($profile['education']); ?>" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
                <label style="color: #333;">Occupation</label>
                <input type="text" name="occupation" value="<?php echo htmlspecialchars($profile['occupation']); ?>" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; align-items: center;">
            <div class="form-group">
                <label style="color: #333;">Change Photo (Current: <?php echo htmlspecialchars($profile['photo']); ?>)</label>
                <input type="file" name="photo" accept="image/*" class="form-control" style="background: #fff; color: #333; border: 1px solid #ccc;">
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
