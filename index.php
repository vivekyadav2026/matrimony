<?php
$page_title = "Shaadi Site For Mangliks | Search Profiles by Caste and Community";
require_once __DIR__ . '/header.php';

// Dynamic Database Queries
$total_profiles = (int)$pdo->query("SELECT COUNT(*) FROM profiles WHERE status = 'active'")->fetchColumn();
$total_verified_couples = (int)$pdo->query("SELECT COUNT(*) FROM success_stories WHERE status = 'active'")->fetchColumn();
$distinct_castes = $pdo->query("SELECT DISTINCT caste FROM profiles WHERE status = 'active' AND caste != '' ORDER BY caste ASC")->fetchAll(PDO::FETCH_COLUMN);
$latest_testimonial = $pdo->query("SELECT * FROM success_stories WHERE status = 'active' ORDER BY id DESC LIMIT 1")->fetch();

// Fetch Dynamic Featured & Premium Profiles (10 Cards)
$stmtPrem = $pdo->prepare("SELECT * FROM profiles WHERE status = 'active' ORDER BY is_premium DESC, id DESC LIMIT 10");
$stmtPrem->execute();
$premium_profiles = $stmtPrem->fetchAll();

// Fetch Dynamic Success Stories
$stmtStories = $pdo->prepare("SELECT * FROM success_stories WHERE status = 'active' ORDER BY id DESC LIMIT 4");
$stmtStories->execute();
$success_stories = $stmtStories->fetchAll();
?>

<!-- Hero Banner Section -->
<section class="hero-banner">
    <div class="container">
        <h1 class="hero-title">Find Your Manglik's Soulmate</h1>
        <p class="hero-subtitle">With The Blessings of Shree Ram Ji</p>

        <!-- Search Box Container -->
        <div class="search-box">
            <form action="search.php" method="GET" class="search-form">
                <div class="form-group">
                    <label>Looking For</label>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="Female" checked> Female</label>
                        <label><input type="radio" name="gender" value="Male"> Male</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Age</label>
                    <div style="display: flex; gap: 6px; align-items: center;">
                        <input type="number" name="age_min" value="18" min="18" max="70" class="form-control" style="text-align: center;">
                        <span style="color: #ffffff; font-size: 13px; font-weight: 500;">to</span>
                        <input type="number" name="age_max" value="40" min="18" max="70" class="form-control" style="text-align: center;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Religion</label>
                    <select name="religion">
                        <option value="">Any Religion</option>
                        <option value="Hindu" selected>Hindu</option>
                        <option value="Sikh">Sikh</option>
                        <option value="Jain">Jain</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Caste</label>
                    <select name="caste">
                        <option value="">Doesn't Matter</option>
                        <?php foreach ($distinct_castes as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>"><?php echo htmlspecialchars($c); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn-red" style="width: 100%; height: 38px; padding: 0 15px; border-radius: 5px;"><i class="fa fa-search"></i> Search</button>
                </div>
            </form>
        </div>

        <div class="search-subtext">
            <p><i class="fa fa-shield-alt" style="color: var(--secondary-gold);"></i> Indian Matrimonial Site For Mangliks | <?php echo $total_profiles; ?>+ Active Verified Profiles across <?php echo count($distinct_castes); ?> Communities</p>
            <div class="social-icons-row">
                <a href="#" class="social-icon-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon-btn"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon-btn"><i class="fab fa-youtube"></i></a>
                <a href="#" class="social-icon-btn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-icon-btn"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Premium Profiles Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Premium Profiles</h2>
        <p class="section-subtitle">FIND YOUR SOULMATE MATRIMONIAL SERVICES FOR ALL INDIAN COMMUNITIES & CASTES</p>

        <div class="profiles-grid">
            <?php foreach ($premium_profiles as $prof): ?>
                <div class="profile-card">
                    <div class="profile-img-wrap">
                        <img src="images/<?php echo htmlspecialchars($prof['photo']); ?>" alt="<?php echo htmlspecialchars($prof['name']); ?>">
                        <span class="premium-tag"><i class="fa fa-crown"></i> PREMIUM</span>
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

        <div class="center-btn-wrap">
            <a href="search.php" class="btn-red" style="padding: 12px 35px; font-size: 15px; border-radius: 25px;">View All <?php echo $total_profiles; ?> Profiles &rarr;</a>
        </div>
    </div>
</section>

<!-- Yellow Feature Services Banner -->
<section class="yellow-banner">
    <div class="container">
        <div class="feature-services-grid">
            <div class="service-card-yellow"><i class="fa fa-ring"></i> Manglik Marriage</div>
            <div class="service-card-yellow"><i class="fa fa-star"></i> Kundli Match Making</div>
            <div class="service-card-yellow"><i class="fa fa-fire"></i> Manglik Nivaran Havan</div>
            <div class="service-card-yellow"><i class="fa fa-hands-praying"></i> Manglik Shanti Services</div>
        </div>

        <div class="yellow-callout">
            <h3>Register Free and Upload Your Profile</h3>
            <p>Your story is waiting to happen!</p>
            <a href="register.php" class="btn-red" style="padding: 12px 35px; font-size: 15px; border-radius: 25px;">Register Now!</a>
        </div>
    </div>
</section>

<!-- 25,000+ Happy Clients Section -->
<section class="happy-clients-section">
    <div class="container">
        <div class="clients-container-card">
            <div class="clients-wrapper">
                <div class="video-thumb-card">
                    <img src="images/testimonial-video.png" alt="Testimonial Video">
                    <div class="play-badge-overlay">
                        <div class="play-btn-circle"><i class="fa fa-play"></i></div>
                    </div>
                </div>
                <div class="client-content-side">
                    <span class="trust-badge"><i class="fa fa-shield-alt"></i> 25,000+ Verified Couples</span>
                    <h2>25,000+ Happy Clients & Blessed Matches</h2>
                    
                    <div class="stars-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <span>5.0 Rating (4,850+ Customer Reviews)</span>
                    </div>

                    <?php if ($latest_testimonial): ?>
                        <div class="quote-box-modern">
                            <i class="fa fa-quote-left"></i> "<?php echo htmlspecialchars($latest_testimonial['story']); ?>"
                            <br><strong style="color: var(--primary-red); display: block; margin-top: 10px;">— <?php echo htmlspecialchars($latest_testimonial['title']); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="blessings-card">
                        <img src="images/lord-ram-is-a-mangliks-did-you-know-that.jpg" alt="Lord Ram">
                        <div>
                            <div class="blessings-title"><i class="fa fa-om"></i> Divine Blessings & Traditional Values</div>
                            <div class="blessings-text">Find your life partner with complete peace of mind and cultural alignment.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories Section -->
<section class="stories-section" id="success-stories">
    <div class="container">
        <h2 class="section-title">Success Stories</h2>
        <p class="section-subtitle">REAL HAPPY COUPLES WHO MET ON SAINMATRIMONY.IN</p>

        <div class="stories-grid">
            <?php foreach ($success_stories as $story): ?>
                <div class="story-card-modern">
                    <div class="story-img-wrap">
                        <img src="images/<?php echo htmlspecialchars($story['photo']); ?>" alt="<?php echo htmlspecialchars($story['title']); ?>">
                        <span class="married-tag"><i class="fa fa-heart"></i> Married</span>
                    </div>
                    <div class="story-body-modern">
                        <div class="story-couple-title"><?php echo htmlspecialchars($story['title']); ?></div>
                        <div class="story-quote-text">"<?php echo htmlspecialchars($story['story']); ?>"</div>
                        <div class="story-date-footer"><i class="fa fa-calendar-alt" style="color: var(--primary-red);"></i> Married on <?php echo htmlspecialchars($story['story_date']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="center-btn-wrap">
            <a href="stories.php" class="btn-red" style="padding: 12px 35px; font-size: 15px; border-radius: 25px;">View All Success Stories &rarr;</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
