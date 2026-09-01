<?php
$page_title = "Manage Success Stories";
require_once __DIR__ . '/header.php';

$msg = '';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM success_stories WHERE id = ?")->execute([$del_id]);
    $msg = "Success story deleted successfully.";
}

$stories = $pdo->query("SELECT * FROM success_stories ORDER BY id DESC")->fetchAll();
?>

<div style="background: #ffffff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
    
    <!-- Top Action Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 22px; flex-wrap: wrap;">
        <div>
            <h3 style="margin: 0; font-size: 19px; font-weight: 700; color: #0f172a;">
                <i class="fa fa-heart" style="color: var(--primary-red);"></i> Current Success Stories (<?php echo count($stories); ?>)
            </h3>
        </div>

        <a href="add-story.php" class="btn-red" style="padding: 9px 20px; font-size: 13.5px; border-radius: 6px;"><i class="fa fa-plus-circle"></i> Add New Success Story</a>
    </div>

    <?php if ($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-check-circle" style="font-size: 16px;"></i> <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <!-- Stories List Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 70px;">Photo</th>
                    <th style="width: 180px;">Couple Title</th>
                    <th style="width: 150px;">Wedding Date</th>
                    <th>Story Testimonial Quote</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($stories) > 0): ?>
                    <?php foreach ($stories as $st): ?>
                        <tr>
                            <td>
                                <img src="../images/<?php echo htmlspecialchars($st['photo']); ?>" alt="" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 2px solid #e2e8f0;">
                            </td>
                            <td><strong style="color: var(--primary-red); font-size: 14.5px;"><?php echo htmlspecialchars($st['title']); ?></strong></td>
                            <td style="white-space: nowrap; font-size: 13px; color: #64748b;"><i class="fa fa-calendar-alt" style="color: var(--primary-red); margin-right: 4px;"></i> <?php echo htmlspecialchars($st['story_date']); ?></td>
                            <td style="font-size: 13.5px; color: #334155; line-height: 1.5;">"<?php echo htmlspecialchars($st['story']); ?>"</td>
                            <td style="text-align: center;">
                                <a href="stories.php?action=delete&id=<?php echo $st['id']; ?>" onclick="return confirm('Are you sure you want to delete story <?php echo htmlspecialchars($st['title']); ?>?');" class="btn-red btn-sm" style="background: #ef4444;" title="Delete Story"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94a3b8; padding: 40px;">
                            <i class="fa fa-heart-broken" style="font-size: 35px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                            No success stories added yet. Click "+ Add New Success Story" above to add one.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
