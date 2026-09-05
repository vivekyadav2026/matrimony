<?php
$page_title = "User Registration & Contact Inquiries";
require_once __DIR__ . '/header.php';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM inquiries WHERE id = ?")->execute([$del_id]);
    $msg = "Inquiry deleted successfully.";
}

$inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC")->fetchAll();
?>

<div style="background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    
    <?php if (isset($msg)): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fa fa-check-circle"></i> <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <h3 style="margin-bottom: 20px; color: var(--dark-navy);">Received User Submissions (<?php echo count($inquiries); ?>)</h3>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Message / Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($inquiries) > 0): ?>
                    <?php foreach ($inquiries as $inq): ?>
                        <tr>
                            <td style="white-space: nowrap; font-size: 13px; color: #666;"><?php echo htmlspecialchars(date('d M Y, h:i A', strtotime($inq['created_at']))); ?></td>
                            <td><strong><?php echo htmlspecialchars($inq['name']); ?></strong></td>
                            <td><a href="tel:<?php echo htmlspecialchars($inq['phone']); ?>" style="color: var(--primary-red); font-weight: 600;"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($inq['phone']); ?></a></td>
                            <td><?php echo htmlspecialchars($inq['email']); ?></td>
                            <td style="max-width: 350px; font-size: 13px; color: #444;"><?php echo nl2br(htmlspecialchars($inq['message'])); ?></td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <?php 
                                    $clean_phone = preg_replace('/[^0-9]/', '', $inq['phone']);
                                    if ($clean_phone): 
                                    ?>
                                        <a href="https://wa.me/<?php echo (strlen($clean_phone) == 10 ? '91' . $clean_phone : $clean_phone); ?>?text=<?php echo urlencode('Hello ' . $inq['name'] . ', thank you for contacting SainMatrimony.com!'); ?>" target="_blank" class="btn-sm" style="background: #25D366; color: #fff; text-decoration: none; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;" title="Chat on WhatsApp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                                    <?php endif; ?>
                                    <a href="inquiries.php?action=delete&id=<?php echo $inq['id']; ?>" onclick="return confirm('Delete this inquiry?');" class="btn-red btn-sm" style="background: #dc3545;" title="Delete Inquiry"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #888; padding: 30px;">No inquiries received yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
