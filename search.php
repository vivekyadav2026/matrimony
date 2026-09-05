<?php
$page_title = "Search Candidate Profiles";
require_once __DIR__ . '/header.php';

// Get Search Parameters
$gender = $_GET['gender'] ?? '';
$age_min = isset($_GET['age_min']) ? (int)$_GET['age_min'] : 18;
$age_max = isset($_GET['age_max']) ? (int)$_GET['age_max'] : 50;
$religion = $_GET['religion'] ?? '';
$caste = trim($_GET['caste'] ?? '');
$state = trim($_GET['state'] ?? '');
$profile_id = trim($_GET['profile_id'] ?? '');
$sort = $_GET['sort'] ?? 'default';

// Pagination Parameters
$items_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$sql_where = " WHERE status = 'active'";
$params = [];

if ($gender != '') {
    $sql_where .= " AND gender = ?";
    $params[] = $gender;
}

if ($age_min > 0) {
    $sql_where .= " AND age >= ?";
    $params[] = $age_min;
}

if ($age_max > 0) {
    $sql_where .= " AND age <= ?";
    $params[] = $age_max;
}

if ($religion != '') {
    $sql_where .= " AND religion = ?";
    $params[] = $religion;
}

if ($caste != '') {
    $caste_clean = strtolower(trim($caste));
    if (in_array($caste_clean, ['sain', 'nai', 'sain/nai', 'sain / nai'])) {
        $sql_where .= " AND (caste LIKE '%Sain%' OR caste LIKE '%Nai%')";
    } else {
        $sql_where .= " AND caste LIKE ?";
        $params[] = "%$caste%";
    }
}

if ($state != '') {
    $sql_where .= " AND (state LIKE ? OR city LIKE ?)";
    $params[] = "%$state%";
    $params[] = "%$state%";
}

if ($profile_id != '') {
    $sql_where .= " AND profile_id LIKE ?";
    $params[] = "%$profile_id%";
}

// Count Total Items
$count_sql = "SELECT COUNT(*) FROM profiles" . $sql_where;
$countStmt = $pdo->prepare($count_sql);
$countStmt->execute($params);
$total_items = (int)$countStmt->fetchColumn();

$total_pages = ceil($total_items / $items_per_page);
if ($total_pages < 1) $total_pages = 1;
if ($page > $total_pages) $page = $total_pages;

$offset = ($page - 1) * $items_per_page;

// Sorting
$sql_order = " ORDER BY is_premium DESC, id DESC";
if ($sort === 'age_asc') {
    $sql_order = " ORDER BY age ASC, id DESC";
} elseif ($sort === 'age_desc') {
    $sql_order = " ORDER BY age DESC, id DESC";
}

$sql = "SELECT * FROM profiles" . $sql_where . $sql_order . " LIMIT $items_per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$profiles = $stmt->fetchAll();

// Build Query String for Pagination Links
$query_params = $_GET;
unset($query_params['page']);
$base_query = http_build_query($query_params);
$page_url_prefix = 'search.php?' . ($base_query ? $base_query . '&' : '') . 'page=';
?>

<!-- Search Page Header Banner -->
<div style="background: linear-gradient(180deg, var(--dark-navy) 0%, #0d121a 100%); color: #fff; padding: 35px 20px 30px; text-align: center;">
    <div class="container">
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 34px; font-weight: 800; margin-bottom: 6px;">Search Profiles</h1>
        <p style="color: #cbd5e1; font-size: 14px;">Find your ideal life partner from 100% verified candidate profiles</p>
    </div>
</div>

<div class="section" style="background-color: #f8fafc; padding-top: 30px;">
    <div class="container">
        
        <!-- Filter Form Box -->
        <div style="background: #ffffff; padding: 22px 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 25px;">
            <form action="search.php" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)) 130px; gap: 14px; align-items: end;">
                
                <div class="form-group">
                    <label style="color: #334155; font-size: 12.5px;">Looking For</label>
                    <select name="gender" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                        <option value="">All Genders</option>
                        <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female (Bride)</option>
                        <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male (Groom)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="color: #334155; font-size: 12.5px;">Age Range</label>
                    <div style="display: flex; gap: 6px; align-items: center;">
                        <input type="number" name="age_min" value="<?php echo $age_min; ?>" min="18" max="70" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px; text-align: center;">
                        <span style="font-size: 12px; color: #64748b;">to</span>
                        <input type="number" name="age_max" value="<?php echo $age_max; ?>" min="18" max="70" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px; text-align: center;">
                    </div>
                </div>

                <div class="form-group">
                    <label style="color: #334155; font-size: 12.5px;">Religion</label>
                    <select name="religion" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                        <option value="">Any Religion</option>
                        <option value="Hindu" <?php echo ($religion == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                        <option value="Sikh" <?php echo ($religion == 'Sikh') ? 'selected' : ''; ?>>Sikh</option>
                        <option value="Jain" <?php echo ($religion == 'Jain') ? 'selected' : ''; ?>>Jain</option>
                        <option value="Others" <?php echo ($religion == 'Others') ? 'selected' : ''; ?>>Others</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="color: #334155; font-size: 12.5px;">Caste</label>
                    <select name="caste" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                        <option value="">All / Doesn't Matter</option>
                        <option value="Nai" <?php echo (in_array(strtolower($caste), ['sain', 'nai', 'sain/nai', 'sain / nai', 'ਨਾਈ'])) ? 'selected' : ''; ?>>Nai</option>
                        <option value="Others" <?php echo (in_array($caste, ['Others', 'Other Community', 'ਅਦਰ'])) ? 'selected' : ''; ?>>Others</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="color: #334155; font-size: 12.5px;">City / State</label>
                    <input type="text" name="state" value="<?php echo htmlspecialchars($state); ?>" placeholder="e.g. Delhi, Punjab" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                </div>

                <div class="form-group">
                    <label style="color: #334155; font-size: 12.5px;">Profile ID</label>
                    <input type="text" name="profile_id" value="<?php echo htmlspecialchars($profile_id); ?>" placeholder="e.g. M101" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 38px;">
                </div>

                <div>
                    <button type="submit" class="btn-red" style="width: 100%; height: 38px; padding: 0 10px; border-radius: 5px; font-size: 13.5px;"><i class="fa fa-filter"></i> Apply Filter</button>
                </div>
            </form>
        </div>

        <!-- Active Filter Pills & Results Control Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h3 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0;">
                    Found <span style="color: var(--primary-red);"><?php echo $total_items; ?></span> Matching Profiles
                    <span style="font-size: 13px; color: #64748b; font-weight: 400; margin-left: 8px;">(Page <?php echo $page; ?> of <?php echo $total_pages; ?>)</span>
                </h3>
            </div>

            <!-- Sort By Selector -->
            <form action="search.php" method="GET" style="display: flex; align-items: center; gap: 10px;">
                <input type="hidden" name="gender" value="<?php echo htmlspecialchars($gender); ?>">
                <input type="hidden" name="age_min" value="<?php echo $age_min; ?>">
                <input type="hidden" name="age_max" value="<?php echo $age_max; ?>">
                <input type="hidden" name="caste" value="<?php echo htmlspecialchars($caste); ?>">
                <input type="hidden" name="state" value="<?php echo htmlspecialchars($state); ?>">
                <input type="hidden" name="profile_id" value="<?php echo htmlspecialchars($profile_id); ?>">

                <label style="font-size: 13px; color: #64748b; font-weight: 500;">Sort By:</label>
                <select name="sort" onchange="this.form.submit()" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 34px; padding: 4px 10px; font-size: 13px; border-radius: 4px;">
                    <option value="default" <?php echo ($sort == 'default') ? 'selected' : ''; ?>>Featured First</option>
                    <option value="age_asc" <?php echo ($sort == 'age_asc') ? 'selected' : ''; ?>>Age: Youngest First</option>
                    <option value="age_desc" <?php echo ($sort == 'age_desc') ? 'selected' : ''; ?>>Age: Oldest First</option>
                </select>

                <?php if ($gender || $caste || $state || $profile_id || $religion): ?>
                    <a href="search.php" class="btn-outline btn-sm" style="color: #64748b !important; border-color: #cbd5e1; height: 34px; line-height: 22px; padding: 4px 12px; font-size: 12.5px;"><i class="fa fa-times"></i> Reset Filters</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Profiles Cards Grid -->
        <?php if (count($profiles) > 0): ?>
            <div class="profiles-grid">
                <?php foreach ($profiles as $prof): ?>
                    <div class="profile-card">
                        <div class="profile-img-wrap">
                            <img src="images/<?php echo htmlspecialchars($prof['photo']); ?>" alt="<?php echo htmlspecialchars($prof['name']); ?>">
                            <span class="verified-tag"><i class="fa fa-check-circle"></i> Verified</span>
                        </div>
                        <div class="profile-card-body">
                            <div class="profile-card-header">
                                <h3 class="profile-card-title"><?php echo htmlspecialchars($prof['name']); ?></h3>
                                <span class="profile-id-pill"><?php echo htmlspecialchars($prof['profile_id']); ?></span>
                            </div>
                            <ul class="profile-meta-list">
                                <li><i class="fa fa-user"></i> <?php echo htmlspecialchars($prof['age']); ?> Yrs • <?php echo htmlspecialchars($prof['caste']); ?></li>
                                <li><i class="fa fa-briefcase"></i> <?php echo htmlspecialchars($prof['occupation']); ?></li>
                                <li><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($prof['city']); ?>, <?php echo htmlspecialchars($prof['state']); ?></li>
                            </ul>
                            <a href="profile.php?id=<?php echo $prof['id']; ?>" class="btn-card-action">View Full Profile &rarr;</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Bar -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination-wrap">
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

        <?php else: ?>
            <div style="background: #ffffff; padding: 50px 20px; text-align: center; border-radius: 12px; border: 1px solid #e2e8f0; max-width: 600px; margin: 30px auto;">
                <div style="width: 70px; height: 70px; background: #fef2f2; color: var(--primary-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 15px;">
                    <i class="fa fa-user-slash"></i>
                </div>
                <h3 style="font-size: 20px; color: #0f172a; margin-bottom: 8px;">No Profiles Match Your Filter</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Try broadening your age range or clearing specific caste and location filters.</p>
                <a href="search.php" class="btn-red" style="padding: 10px 25px; border-radius: 20px;"><i class="fa fa-redo"></i> Reset All Filters</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
