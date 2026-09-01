<?php
$page_title = "Add New Success Story";
require_once __DIR__ . '/header.php';

$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_story'])) {
    $title = trim($_POST['title'] ?? '');
    $story = trim($_POST['story'] ?? '');
    $story_date = trim($_POST['story_date'] ?? '');
    $photo = 'story1.jpg'; // default fallback

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $newPhoto = time() . '_story.' . $ext;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/../images/' . $newPhoto)) {
                $photo = $newPhoto;
            }
        }
    }

    if ($title && $story) {
        $ins = $pdo->prepare("INSERT INTO success_stories (title, story, photo, story_date) VALUES (?, ?, ?, ?)");
        $ins->execute([$title, $story, $photo, $story_date]);
        $msg = "Success story added successfully!";
    } else {
        $error = "Please fill in Couple Title and Testimonial Story.";
    }
}
?>

<div style="max-width: 700px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 25px;">
        <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">
            <i class="fa fa-heart" style="color: var(--primary-red); margin-right: 8px;"></i> Add New Success Story
        </h2>
        <a href="stories.php" class="btn-outline btn-sm" style="color: #475569 !important; border-color: #cbd5e1;"><i class="fa fa-arrow-left"></i> Back to Stories List</a>
    </div>

    <?php if ($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
            <i class="fa fa-check-circle" style="font-size: 20px; color: #28a745;"></i> <?php echo htmlspecialchars($msg); ?>
            <a href="stories.php" style="margin-left: auto; color: #155724; font-weight: 700;">View Stories List &rarr;</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fecaca; display: flex; align-items: center; gap: 10px;">
            <i class="fa fa-exclamation-circle" style="font-size: 20px; color: #dc2626;"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="add-story.php" method="POST" enctype="multipart/form-data" style="display: grid; gap: 18px;">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label style="color: #334155; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Couple Names (Title) *</label>
                <input type="text" name="title" required placeholder="e.g. ANIT & TRILOK" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
            </div>

            <div class="form-group">
                <label style="color: #334155; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Wedding Date</label>
                <input type="text" name="story_date" placeholder="e.g. 15 August 2024" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px;">
            </div>
        </div>

        <div class="form-group">
            <label style="color: #334155; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Couple Wedding Photo</label>
            <input type="file" name="photo" accept="image/*" class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; height: 42px; border-radius: 6px; padding: 6px 10px;">
        </div>

        <div class="form-group">
            <label style="color: #334155; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Testimonial Story / Quote *</label>
            <textarea name="story" rows="4" required placeholder="Write a short journey testimonial story..." class="form-control" style="background: #fff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px;"></textarea>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 5px;">
            <button type="submit" name="add_story" class="btn-red" style="padding: 12px 30px; font-size: 15px; border-radius: 6px; font-weight: 600;">
                <i class="fa fa-save"></i> Save Success Story
            </button>
            <a href="stories.php" class="btn-outline" style="padding: 11px 25px; font-size: 14px; border-radius: 6px; color: #475569 !important; border-color: #cbd5e1;">Cancel</a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
