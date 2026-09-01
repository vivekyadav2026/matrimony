<?php
$page_title = "Account Settings & Password";
require_once __DIR__ . '/header.php';

$msg = '';
$error = '';

$current_admin_username = $_SESSION['admin_username'];
$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->execute([$current_admin_username]);
$admin_account = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username'] ?? '');
    $current_password = trim($_POST['current_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if ($current_password) {
        // Verify current password
        if ($admin_account && password_verify($current_password, $admin_account['password'])) {
            
            // Check username update
            if ($new_username && $new_username !== $admin_account['username']) {
                // Check if username already exists
                $chk = $pdo->prepare("SELECT id FROM admin_users WHERE username = ? AND id != ?");
                $chk->execute([$new_username, $admin_account['id']]);
                if ($chk->fetch()) {
                    $error = "Username '$new_username' is already taken by another user.";
                } else {
                    $updUser = $pdo->prepare("UPDATE admin_users SET username = ? WHERE id = ?");
                    $updUser->execute([$new_username, $admin_account['id']]);
                    $_SESSION['admin_username'] = $new_username;
                    $current_admin_username = $new_username;
                    $msg = "Admin username updated successfully!";
                }
            }

            // Check password update
            if ($new_password) {
                if (strlen($new_password) < 6) {
                    $error = "New password must be at least 6 characters long.";
                } elseif ($new_password !== $confirm_password) {
                    $error = "New password and Confirm password do not match.";
                } else {
                    $hashed_pwd = password_hash($new_password, PASSWORD_DEFAULT);
                    $updPwd = $pdo->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
                    $updPwd->execute([$hashed_pwd, $admin_account['id']]);
                    $msg = ($msg ? $msg . " And password " : "Admin password ") . "changed successfully!";
                }
            }

            // Refresh account data
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
            $stmt->execute([$admin_account['id']]);
            $admin_account = $stmt->fetch();

        } else {
            $error = "Current password verification failed. Please enter your correct password.";
        }
    } else {
        $error = "Please enter your Current Password to save security settings.";
    }
}
?>

<div style="max-width: 650px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
    
    <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 25px;">
        <h2 style="font-size: 22px; font-weight: 800; color: var(--dark-navy); margin-bottom: 4px;">
            <i class="fa fa-user-shield" style="color: var(--primary-red); margin-right: 8px;"></i> Account Settings & Change Password
        </h2>
        <p style="color: #64748b; font-size: 13.5px; margin: 0;">Update your administrator username and login password securely.</p>
    </div>

    <?php if ($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
            <i class="fa fa-check-circle" style="font-size: 20px; color: #28a745;"></i> <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fecaca; display: flex; align-items: center; gap: 10px;">
            <i class="fa fa-exclamation-triangle" style="font-size: 20px; color: #dc2626;"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="settings.php" method="POST" style="display: grid; gap: 20px;">
        
        <div class="form-group">
            <label style="color: #334155; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Admin Username</label>
            <div style="position: relative;">
                <i class="fa fa-user" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                <input type="text" name="username" value="<?php echo htmlspecialchars($admin_account['username']); ?>" required class="form-control" style="padding-left: 36px; height: 42px; background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
            <small style="color: #94a3b8; font-size: 12px; margin-top: 4px; display: block;">This is your login username for the Sainmatrimony Admin Panel.</small>
        </div>

        <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; display: grid; gap: 16px;">
            <h4 style="margin: 0; font-size: 15px; color: #0f172a; font-weight: 700;">
                <i class="fa fa-key" style="color: var(--secondary-gold); margin-right: 6px;"></i> Password Security Update
            </h4>

            <div class="form-group">
                <label style="color: #334155; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Current Password *</label>
                <div style="position: relative;">
                    <i class="fa fa-lock" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                    <input type="password" name="current_password" required placeholder="Enter current password to authorize changes" class="form-control" style="padding-left: 36px; height: 42px; background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">New Password (Optional)</label>
                    <div style="position: relative;">
                        <i class="fa fa-key" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                        <input type="password" name="new_password" placeholder="Leave blank to keep same" class="form-control" style="padding-left: 36px; height: 42px; background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px;">
                    </div>
                </div>

                <div class="form-group">
                    <label style="color: #334155; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Confirm New Password</label>
                    <div style="position: relative;">
                        <i class="fa fa-key" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                        <input type="password" name="confirm_password" placeholder="Re-enter new password" class="form-control" style="padding-left: 36px; height: 42px; background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px;">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 5px;">
            <button type="submit" class="btn-red" style="padding: 12px 30px; font-size: 15px; border-radius: 6px; font-weight: 600;">
                <i class="fa fa-save"></i> Save Account Settings
            </button>
            <a href="index.php" class="btn-outline" style="padding: 11px 25px; font-size: 14px; border-radius: 6px; color: #475569 !important; border-color: #cbd5e1;">Cancel</a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
