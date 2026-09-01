<?php
$page_title = "Success Stories - Happy Couples";
require_once __DIR__ . '/header.php';

// Fetch All Success Stories
$stmtStories = $pdo->prepare("SELECT * FROM success_stories WHERE status = 'active' ORDER BY id DESC");
$stmtStories->execute();
$all_stories = $stmtStories->fetchAll();
?>

<!-- Banner Header -->
<div style="background: linear-gradient(180deg, var(--dark-navy) 0%, #0d121a 100%); color: #fff; padding: 40px 20px 35px; text-align: center;">
    <div class="container">
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 38px; font-weight: 800; margin-bottom: 6px;">Success Stories</h1>
        <p style="color: #cbd5e1; font-size: 15px;">Inspiring journey of happy couples who found their life partners on Sainmatrimony.in</p>
    </div>
</div>

<div class="stories-section" style="background-color: #f8fafc; padding: 45px 20px;">
    <div class="container">
        
        <div style="text-align: center; margin-bottom: 35px;">
            <span style="background: #fef2f2; color: var(--primary-red); font-weight: 700; font-size: 12px; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fa fa-heart"></i> Verified Matchmaking Journey
            </span>
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 8px;">
                Real People, Genuine Love Stories
            </h2>
        </div>

        <div class="stories-grid">
            <?php foreach ($all_stories as $story): ?>
                <div class="story-card-modern">
                    <div class="story-img-wrap">
                        <img src="images/<?php echo htmlspecialchars($story['photo']); ?>" alt="<?php echo htmlspecialchars($story['title']); ?>">
                        <span class="married-tag"><i class="fa fa-heart"></i> Married</span>
                    </div>
                    <div class="story-body-modern">
                        <div class="story-couple-title"><?php echo htmlspecialchars($story['title']); ?></div>
                        <div class="story-quote-text">"<?php echo htmlspecialchars($story['story']); ?>"</div>
                        <div class="story-date-footer">
                            <i class="fa fa-calendar-alt" style="color: var(--primary-red);"></i> Married on <?php echo htmlspecialchars($story['story_date']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Call to Action Card -->
        <div style="background: linear-gradient(135deg, var(--dark-navy) 0%, #1a2332 100%); color: #fff; border-radius: 14px; padding: 40px 30px; text-align: center; margin-top: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <i class="fa fa-ring" style="font-size: 40px; color: var(--secondary-gold); margin-bottom: 15px;"></i>
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 28px; font-weight: 800; margin-bottom: 8px;">
                Are You Ready To Find Your Soulmate?
            </h3>
            <p style="color: #cbd5e1; max-width: 600px; margin: 0 auto 25px; font-size: 15px;">
                Join thousands of happy families who found their perfect match. Upload your profile for free today!
            </p>
            <a href="register.php" class="btn-red" style="padding: 12px 35px; font-size: 16px; border-radius: 25px;">Register Free Now <i class="fa fa-arrow-right" style="margin-left: 6px;"></i></a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
