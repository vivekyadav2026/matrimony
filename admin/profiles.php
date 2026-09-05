<?php
$page_title = "Manage Profiles";
require_once __DIR__ . '/header.php';

// Handle Actions (Delete, Approve, Reject, Toggle Status, Toggle Premium)
$msg = '';
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action_id = (int)$_GET['id'];
    $act = $_GET['action'];

    // Fetch profile details for message
    $p_info = $pdo->prepare("SELECT profile_id, name FROM profiles WHERE id = ?");
    $p_info->execute([$action_id]);
    $target_p = $p_info->fetch();
    $target_label = $target_p ? htmlspecialchars($target_p['name']) . " (" . htmlspecialchars($target_p['profile_id']) . ")" : "Profile #$action_id";

    if ($act === 'delete') {
        $del = $pdo->prepare("DELETE FROM profiles WHERE id = ?");
        $del->execute([$action_id]);
        $msg = "$target_label deleted successfully.";
    } elseif ($act === 'approve') {
        $pdo->prepare("UPDATE profiles SET status = 'active' WHERE id = ?")->execute([$action_id]);
        $msg = "Profile $target_label has been APPROVED and published live on website!";
        if (isset($_GET['redirect']) && $_GET['redirect'] === 'profile') {
            header("Location: ../profile.php?id=" . $action_id . "&approved=1");
            exit;
        }
    } elseif ($act === 'reject' || $act === 'deactivate') {
        $pdo->prepare("UPDATE profiles SET status = 'inactive' WHERE id = ?")->execute([$action_id]);
        $msg = "Profile $target_label status set to Pending / Inactive.";
    } elseif ($act === 'toggle_status') {
        $pdo->prepare("UPDATE profiles SET status = IF(status='active', 'inactive', 'active') WHERE id = ?")->execute([$action_id]);
        $msg = "Status updated for $target_label.";
    } elseif ($act === 'toggle_premium') {
        $pdo->prepare("UPDATE profiles SET is_premium = IF(is_premium=1, 0, 1) WHERE id = ?")->execute([$action_id]);
        $msg = "Premium status updated for $target_label.";
    }
}

// Search & Filter
$search = trim($_GET['search'] ?? '');
$filter_gender = $_GET['gender'] ?? '';
$filter_status = $_GET['status'] ?? '';

// Pagination
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$sql_where = " WHERE 1=1";
$params = [];

if ($search) {
    $sql_where .= " AND (name LIKE ? OR profile_id LIKE ? OR caste LIKE ? OR city LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%", "%$search%"];
}

if ($filter_gender) {
    $sql_where .= " AND gender = ?";
    $params[] = $filter_gender;
}

if ($filter_status) {
    $sql_where .= " AND status = ?";
    $params[] = $filter_status;
}

// Count Total Profiles
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM profiles" . $sql_where);
$countStmt->execute($params);
$total_items = (int)$countStmt->fetchColumn();

$total_pages = ceil($total_items / $items_per_page);
if ($total_pages < 1) $total_pages = 1;
if ($page > $total_pages) $page = $total_pages;

$offset = ($page - 1) * $items_per_page;

$sql = "SELECT * FROM profiles" . $sql_where . " ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$profiles = $stmt->fetchAll();

// Build Pagination URL
$query_params = $_GET;
unset($query_params['page']);
unset($query_params['action']);
unset($query_params['id']);
$base_query = http_build_query($query_params);
$page_url_prefix = 'profiles.php?' . ($base_query ? $base_query . '&' : '') . 'page=';
?>

<div style="background: #ffffff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
    
    <?php if ($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-check-circle" style="font-size: 16px;"></i> <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <!-- Filter & Action Header Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 22px; flex-wrap: wrap;">
        <form action="profiles.php" method="GET" style="display: flex; gap: 10px; flex: 1; align-items: center; flex-wrap: wrap;">
            <div style="position: relative;">
                <i class="fa fa-search" style="position: absolute; left: 12px; top: 12px; color: #94a3b8;"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search Name, ID, Caste, City..." class="form-control" style="padding-left: 36px; background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px; width: 240px;">
            </div>
            <select name="gender" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px; width: 130px;">
                <option value="">All Genders</option>
                <option value="Female" <?php echo ($filter_gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Male" <?php echo ($filter_gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            </select>
            <select name="status" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px; width: 160px;">
                <option value="">All Statuses</option>
                <option value="active" <?php echo ($filter_status == 'active') ? 'selected' : ''; ?>>Active (Published)</option>
                <option value="inactive" <?php echo ($filter_status == 'inactive') ? 'selected' : ''; ?>>Pending Approval</option>
            </select>
            <button type="submit" class="btn-red btn-sm" style="height: 38px; padding: 0 16px; border-radius: 5px;"><i class="fa fa-filter"></i> Filter</button>
            <?php if ($search || $filter_gender || $filter_status): ?>
                <a href="profiles.php" class="btn-outline btn-sm" style="color: #64748b !important; border-color: #cbd5e1; height: 38px; line-height: 26px; padding: 4px 14px;">Reset</a>
            <?php endif; ?>
        </form>

        <a href="add-profile.php" class="btn-red" style="padding: 9px 20px; font-size: 13.5px; border-radius: 6px;"><i class="fa fa-user-plus"></i> Add New Candidate Profile</a>
    </div>

    <!-- Summary Text -->
    <div style="margin-bottom: 15px; font-size: 13.5px; color: #64748b;">
        Showing <strong><?php echo count($profiles); ?></strong> of <strong><?php echo $total_items; ?></strong> total candidate profiles (Page <?php echo $page; ?> of <?php echo $total_pages; ?>)
    </div>

    <!-- Profiles Data Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">Photo</th>
                    <th style="width: 90px;">Profile ID</th>
                    <th>Candidate Name</th>
                    <th>Gender / Age</th>
                    <th>Caste</th>
                    <th>City / State</th>
                    <th>Education</th>
                    <th style="width: 130px; text-align: center;">Status</th>
                    <th style="width: 170px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($profiles) > 0): ?>
                    <?php foreach ($profiles as $p): ?>
                        <tr>
                            <td>
                                <img src="<?php echo get_profile_photo_url($p['photo'], true); ?>" alt="" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;">
                            </td>
                            <td><strong style="color: var(--primary-red);"><?php echo htmlspecialchars($p['profile_id']); ?></strong></td>
                            <td><strong style="color: #0f172a;"><?php echo htmlspecialchars($p['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['gender']); ?>, <?php echo htmlspecialchars($p['age']); ?> Yrs</td>
                            <td><?php echo htmlspecialchars($p['caste']); ?></td>
                            <td><?php echo htmlspecialchars($p['city']); ?>, <?php echo htmlspecialchars($p['state']); ?></td>
                            <td><span style="font-size: 12.5px; color: #475569;"><?php echo htmlspecialchars($p['education']); ?></span></td>
                            <td style="text-align: center;">
                                <a href="profiles.php?action=toggle_status&id=<?php echo $p['id']; ?>&page=<?php echo $page; ?>" style="text-decoration: none;" title="Click to toggle Active/Inactive status">
                                    <?php if ($p['status'] == 'active'): ?>
                                        <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning" style="background: #f59e0b; color: #fff;"><i class="fa fa-clock"></i> Pending</span>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <?php if ($p['status'] != 'active'): ?>
                                        <a href="profiles.php?action=approve&id=<?php echo $p['id']; ?>&page=<?php echo $page; ?>" class="btn-sm" style="background: #10b981; color: #fff; text-decoration: none; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;" title="Approve Profile and publish on site"><i class="fa fa-check"></i> Approve</a>
                                    <?php endif; ?>
                                    <a href="../profile.php?id=<?php echo $p['id']; ?>" target="_blank" class="btn-outline btn-sm" style="color: #0284c7 !important; border-color: #38bdf8;" title="View Candidate Profile Details"><i class="fa fa-eye"></i> View</a>
                                    <a href="edit-profile.php?id=<?php echo $p['id']; ?>" class="btn-outline btn-sm" style="color: #334155 !important; border-color: #cbd5e1;" title="Edit Profile Details"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="profiles.php?action=delete&id=<?php echo $p['id']; ?>&page=<?php echo $page; ?>" onclick="return confirm('Are you sure you want to delete profile <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['profile_id']); ?>)?');" class="btn-red btn-sm" style="background: #ef4444;" title="Delete Profile"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" style="text-align: center; color: #94a3b8; padding: 40px;">
                            <i class="fa fa-users-slash" style="font-size: 35px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                            No candidate profiles found matching your search.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Admin Pagination Bar -->
    <?php if ($total_pages > 1): ?>
        <div class="pagination-wrap" style="margin-top: 25px;">
            <?php if ($page > 1): ?>
                <a href="<?php echo $page_url_prefix . ($page - 1); ?>" class="page-link">&laquo; Prev</a>
            <?php else: ?>
                <span class="page-link disabled">&laquo; Prev</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="<?php echo $page_url_prefix . $i; ?>" class="page-link <?php echo ($i === $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?php echo $page_url_prefix . ($page + 1); ?>" class="page-link">Next &raquo;</a>
            <?php else: ?>
                <span class="page-link disabled">Next &raquo;</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
