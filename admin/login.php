<?php
require_once __DIR__ . '/../config.php';

$error = '';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid admin username or password.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <link rel="icon" type="image/png" href="../images/favicon.png?v=<?php echo filemtime(__DIR__ . '/../images/favicon.png'); ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime(__DIR__ . '/../css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #0b0e14 0%, #151c28 100%); display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px;">

    <div style="background: #ffffff; width: 100%; max-width: 420px; padding: 40px 35px; border-radius: 12px; box-shadow: 0 20px 45px rgba(0,0,0,0.45); border: 1px solid rgba(255,255,255,0.1);">
        <div style="text-align: center; margin-bottom: 28px;">
            <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 28px; font-weight: 800; color: #151c28; margin-bottom: 4px;">
                Sain<span style="color: var(--primary-red);">matrimony.in</span>
            </div>
            <p style="color: var(--text-muted); font-size: 13.5px; font-weight: 500;">Admin Control Panel Access</p>
        </div>

        <?php if ($error): ?>
            <div style="background-color: #fef2f2; color: #991b1b; padding: 12px 15px; border-radius: 8px; font-size: 13.5px; margin-bottom: 22px; border: 1px solid #fecaca; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-exclamation-circle" style="font-size: 16px;"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" style="display: grid; gap: 18px;">
            <div class="form-group">
                <label style="color: #334155; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Admin Username</label>
                <div style="position: relative;">
                    <i class="fa fa-user" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                    <input type="text" name="username" required placeholder="Enter admin username" class="form-control" style="padding-left: 36px; height: 42px; background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>
            </div>

            <div class="form-group">
                <label style="color: #334155; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Password</label>
                <div style="position: relative;">
                    <i class="fa fa-lock" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                    <input type="password" name="password" required placeholder="Enter password" class="form-control" style="padding-left: 36px; height: 42px; background: #ffffff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>
            </div>

            <button type="submit" class="btn-red" style="padding: 12px; font-size: 15px; border-radius: 6px; margin-top: 5px; font-weight: 600;"><i class="fa fa-sign-in-alt"></i> Login to Admin Panel</button>
        </form>

        <div style="margin-top: 25px; text-align: center; font-size: 13px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
            <a href="../index.php" style="color: #64748b; font-weight: 500; transition: color 0.2s;"><i class="fa fa-arrow-left"></i> Return to Main Website</a>
        </div>
    </div>

</body>
</html>
