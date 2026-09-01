<?php
$page_title = "Admin Dashboard";
require_once __DIR__ . '/header.php';

// Stats
$total_profiles = $pdo->query("SELECT COUNT(*) FROM profiles")->fetchColumn();
$premium_profiles = $pdo->query("SELECT COUNT(*) FROM profiles WHERE is_premium = 1")->fetchColumn();
$active_profiles = $pdo->query("SELECT COUNT(*) FROM profiles WHERE status = 'active'")->fetchColumn();
$total_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
$total_stories = $pdo->query("SELECT COUNT(*) FROM success_stories")->fetchColumn();

// Recent Profiles
$recent_profiles = $pdo->query("SELECT * FROM profiles ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!-- Stat Cards Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $total_profiles; ?></div>
        <div class="stat-label">Total Profiles</div>
    </div>
    <div class="stat-card" style="border-left-color: var(--secondary-yellow);">
        <div class="stat-number"><?php echo $premium_profiles; ?></div>
        <div class="stat-label">Premium Profiles</div>
    </div>
    <div class="stat-card" style="border-left-color: #28a745;">
        <div class="stat-number"><?php echo $active_profiles; ?></div>
        <div class="stat-label">Active Profiles</div>
    </div>
    <div class="stat-card" style="border-left-color: #17a2b8;">
        <div class="stat-number"><?php echo $total_inquiries; ?></div>
        <div class="stat-label">User Inquiries</div>
    </div>
    <div class="stat-card" style="border-left-color: #6f42c1;">
        <div class="stat-number"><?php echo $total_stories; ?></div>
        <div class="stat-label">Success Stories</div>
    </div>
</div>

<!-- Quick Action & Recent Profiles -->
<div style="background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0; font-size: 18px; color: var(--dark-navy);">Recently Added Profiles</h3>
        <a href="add-profile.php" class="btn-red btn-sm"><i class="fa fa-plus"></i> Add New Profile</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Profile ID</th>
                    <th>Name</th>
                    <th>Gender / Age</th>
                    <th>Caste</th>
                    <th>Location</th>
                    <th>Premium</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_profiles as $p): ?>
                    <tr>
                        <td>
                            <img src="../images/<?php echo htmlspecialchars($p['photo']); ?>" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td><strong><?php echo htmlspecialchars($p['profile_id']); ?></strong></td>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td><?php echo htmlspecialchars($p['gender']); ?>, <?php echo htmlspecialchars($p['age']); ?> Yrs</td>
                        <td><?php echo htmlspecialchars($p['caste']); ?></td>
                        <td><?php echo htmlspecialchars($p['city']); ?></td>
                        <td>
                            <?php if ($p['is_premium']): ?>
                                <span class="badge badge-warning">Premium</span>
                            <?php else: ?>
                                <span class="badge badge-info">Regular</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p['status'] == 'active'): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit-profile.php?id=<?php echo $p['id']; ?>" class="btn-outline btn-sm" style="color: var(--dark-navy) !important; border-color: #ccc;"><i class="fa fa-edit"></i> Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
