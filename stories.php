<?php
$page_title = "Success Stories - Happy Couples | Sain & Nai Matrimony";
require_once __DIR__ . '/header.php';

// Fetch All Active Success Stories
$stmtStories = $pdo->prepare("SELECT * FROM success_stories WHERE status = 'active' ORDER BY id DESC");
$stmtStories->execute();
$all_stories = $stmtStories->fetchAll();
?>

<!-- Page Hero Banner -->
<section style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); color: #fff; padding: 60px 20px 50px; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; left: 50%; top: -50%; transform: translateX(-50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(204,30,43,0.15) 0%, rgba(15,23,42,0) 70%); pointer-events: none;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(204, 30, 43, 0.2); color: #fca5a5; border: 1px solid rgba(204, 30, 43, 0.4); font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; margin-bottom: 16px; letter-spacing: 1px; text-transform: uppercase;">
            <i class="fa fa-heart"></i> Celebrating Love & Togetherness
        </span>
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(28px, 4.5vw, 46px); font-weight: 800; margin-bottom: 12px; line-height: 1.2;">
            Real Couples, <span style="color: var(--secondary-gold);">Genuine Marriage Stories</span>
        </h1>
        <p style="color: #cbd5e1; font-size: 15px; font-weight: 500; max-width: 650px; margin: 0 auto; line-height: 1.6;">
            Inspiring matrimonial journeys of verified grooms and brides from Sain & Nai community who found their soulmates on Sainmatrimony.in
        </p>
    </div>
</section>

<!-- Stats Ribbon -->
<section style="background: #0b0f19; padding: 30px 20px; color: #fff; border-bottom: 1px solid #1e293b;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; text-align: center;">
            <div>
                <div style="font-size: 26px; font-weight: 800; color: var(--secondary-gold);"><i class="fa fa-heart" style="color: var(--primary-red); font-size: 20px; margin-right: 4px;"></i> 25,000+</div>
                <div style="font-size: 12px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-top: 2px;">Happy Matches</div>
            </div>
            <div>
                <div style="font-size: 26px; font-weight: 800; color: #ffffff;"><i class="fa fa-user-check" style="color: #10b981; font-size: 20px; margin-right: 4px;"></i> 100%</div>
                <div style="font-size: 12px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-top: 2px;">Verified Profiles</div>
            </div>
            <div>
                <div style="font-size: 26px; font-weight: 800; color: #f59e0b;"><i class="fa fa-star" style="font-size: 20px; margin-right: 4px;"></i> 4.9 / 5</div>
                <div style="font-size: 12px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-top: 2px;">Family Rating</div>
            </div>
        </div>
    </div>
</section>

<!-- Stories Cards Grid -->
<section style="background-color: #f8fafc; padding: 60px 20px;">
    <div class="container" style="max-width: 1100px;">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px;">
            <?php foreach ($all_stories as $story): ?>
                <div style="background: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; display: flex; flex-direction: column; transition: transform 0.3s ease;">
                    <div style="height: 220px; position: relative; overflow: hidden; background: #0f172a;">
                        <img src="images/<?php echo htmlspecialchars($story['photo']); ?>" alt="<?php echo htmlspecialchars($story['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; object-position: center 20%;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,0.7) 100%);"></div>
                        <span style="position: absolute; bottom: 12px; right: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #f43f5e; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px; border: 1px solid rgba(244,63,94,0.3);">
                            <i class="fa fa-heart"></i> Married Couple
                        </span>
                    </div>
                    <div style="padding: 22px 20px; display: flex; flex-direction: column; flex: 1;">
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--primary-red); margin-bottom: 8px; font-family: 'Playfair Display', serif;">
                            <?php echo htmlspecialchars($story['title']); ?>
                        </h3>
                        <p style="font-size: 13.5px; color: #475569; line-height: 1.65; margin-bottom: 16px; flex: 1; font-style: italic;">
                            "<?php echo htmlspecialchars($story['story']); ?>"
                        </p>
                        <div style="font-size: 12px; color: #94a3b8; font-weight: 600; display: flex; align-items: center; gap: 6px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                            <i class="fa fa-calendar-alt" style="color: var(--primary-red);"></i> Married on <?php echo htmlspecialchars($story['story_date']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Share Your Story Box -->
        <div style="background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border: 1px solid #fef08a; border-left: 4px solid var(--secondary-gold); padding: 30px; border-radius: 16px; margin-top: 50px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; box-shadow: 0 4px 15px rgba(245, 184, 0, 0.08);">
            <div>
                <h3 style="font-size: 20px; font-weight: 800; color: #92400e; margin-bottom: 6px;">Did You Meet Your Life Partner On Sainmatrimony.in?</h3>
                <p style="font-size: 14px; color: #b45309; margin: 0;">We would love to publish your wedding story and inspire thousands of community families.</p>
            </div>
            <a href="contact.php" class="btn-outline" style="color: #92400e !important; border-color: #fde047; background: #ffffff; padding: 10px 24px; font-weight: 700; border-radius: 20px; font-size: 13.5px; white-space: nowrap;"><i class="fa fa-paper-plane"></i> Share Your Wedding Story</a>
        </div>

    </div>
</section>

<!-- Call to Action Banner -->
<section style="background: linear-gradient(180deg, #0b0f19 0%, #0f172a 100%); padding: 60px 20px; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; left: 50%; top: -30%; transform: translateX(-50%); width: 500px; height: 500px; background: radial-gradient(circle, rgba(234,179,8,0.14) 0%, rgba(11,15,25,0) 70%); pointer-events: none;"></div>
    <div class="container" style="max-width: 800px; position: relative; z-index: 1;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(234, 179, 8, 0.12); color: var(--secondary-gold); border: 2px solid rgba(234,179,8,0.3); display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 20px; box-shadow: 0 0 25px rgba(234,179,8,0.25);">
            <i class="fa fa-ring"></i>
        </div>
        <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(26px, 4vw, 38px); font-weight: 800; margin-bottom: 14px; color: #ffffff; line-height: 1.25;">
            Ready to Begin Your Own <span style="color: var(--secondary-gold);">Success Story?</span>
        </h2>
        <p style="font-size: 15px; color: #cbd5e1; margin-bottom: 30px; line-height: 1.65; max-width: 620px; margin-left: auto; margin-right: auto;">
            Join thousands of verified Sain & Nai community families. Register your candidate profile today and find your soulmate!
        </p>
        <div style="display: flex; justify-content: center; align-items: center; gap: 14px; flex-wrap: wrap;">
            <a href="register.php" class="btn-red" style="background: linear-gradient(135deg, var(--primary-red) 0%, #a11320 100%) !important; padding: 14px 32px; font-size: 13.5px; border-radius: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 6px 20px rgba(204,30,43,0.4); border: 1px solid rgba(255,255,255,0.15); display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-user-plus"></i> Register Free Candidate Profile
            </a>
            <a href="search.php" class="btn-outline" style="background: rgba(255, 255, 255, 0.08); color: #ffffff !important; padding: 14px 30px; font-size: 13.5px; border-radius: 8px; font-weight: 700; border: 1px solid rgba(255, 255, 255, 0.25); backdrop-filter: blur(5px); text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-search"></i> Search Profiles
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>

