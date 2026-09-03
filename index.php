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
        <h1 class="hero-title" style="font-size: 38px; line-height: 1.2; margin-bottom: 12px; font-weight: 800;">Find Your Manglik's Soulmate<br><span style="color: var(--secondary-gold);">Within Our Community.</span></h1>
        <p class="hero-subtitle" style="font-size: 15px; color: #f1f5f9; font-style: normal; margin-bottom: 30px; text-shadow: 0 1px 4px rgba(0,0,0,0.8); line-height: 1.6; max-width: 600px; margin-left: auto; margin-right: auto;">
            Join thousands of families in our trusted matrimonial community. Submit your biodata, browse verified profiles, and connect with compatible matches.
        </p>

        <div style="display: flex; flex-direction: column; gap: 12px; max-width: 320px; margin: 0 auto 40px;">
            <a href="register.php" class="btn-outline" style="background: #ffffff; color: var(--primary-red) !important; border: none; padding: 14px; font-size: 15px; font-weight: 700; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Submit Your Biodata <i class="fa fa-arrow-right"></i></a>
            <a href="about.php" class="btn-outline" style="background: rgba(0,0,0,0.4); color: #ffffff !important; border: 1px solid rgba(255,255,255,0.2); padding: 14px; font-size: 14px; font-weight: 600; border-radius: 8px; backdrop-filter: blur(5px);">See How It Works</a>
        </div>

        <!-- Search Box Container -->
        <div class="search-box" style="margin-top: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 10px; font-weight: 800; color: var(--primary-red); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 2px;">Quick Search</div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Find Your Match</h3>
                </div>
                <div style="background: #fdf2f8; color: #db2777; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: flex; align-items: center; gap: 4px;">
                    <i class="fa fa-shield-check"></i> Verified
                </div>
            </div>
            
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
                        <option value="Sain">Sain</option>
                        <option value="Nai">Nai</option>
                        <option value="Sain/Nai">Sain/Nai</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn-red" style="width: 100%; height: 38px; padding: 0 15px; border-radius: 5px;"><i class="fa fa-search"></i> Search</button>
                </div>
            </form>
        </div>

        <div class="search-subtext">
            <p><i class="fa fa-shield-alt" style="color: var(--secondary-gold);"></i> Indian Matrimonial Site For Mangliks | <?php echo $total_profiles; ?>+ Active Verified Profiles across Sain & Nai Communities</p>
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
        <p class="section-subtitle">EXCLUSIVE MATCHES FROM THE SAIN & NAI COMMUNITY</p>

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
<section style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 60px 20px; position: relative; overflow: hidden; color: #fff;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('https://www.transparenttextures.com/patterns/cubes.png'); opacity: 0.05;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 34px; font-weight: 800; color: var(--secondary-gold); margin-bottom: 10px;">Our Premium Services</h2>
            <p style="color: #cbd5e1; font-size: 15px;">Dedicated Matchmaking & Astrological Support</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 45px;">
            <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); padding: 25px; border-radius: 16px; text-align: center; backdrop-filter: blur(10px); transition: transform 0.3s ease;">
                <div style="width: 60px; height: 60px; margin: 0 auto 15px; border-radius: 50%; background: rgba(234, 179, 8, 0.2); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 24px;"><i class="fa fa-ring"></i></div>
                <h4 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px;">Manglik Marriage</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin: 0;">Specialized profiles for Manglik brides and grooms.</p>
            </div>
            <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); padding: 25px; border-radius: 16px; text-align: center; backdrop-filter: blur(10px); transition: transform 0.3s ease;">
                <div style="width: 60px; height: 60px; margin: 0 auto 15px; border-radius: 50%; background: rgba(234, 179, 8, 0.2); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 24px;"><i class="fa fa-star"></i></div>
                <h4 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px;">Kundli Matching</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin: 0;">In-depth 36 Guna and astrological alignment checks.</p>
            </div>
            <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); padding: 25px; border-radius: 16px; text-align: center; backdrop-filter: blur(10px); transition: transform 0.3s ease;">
                <div style="width: 60px; height: 60px; margin: 0 auto 15px; border-radius: 50%; background: rgba(234, 179, 8, 0.2); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 24px;"><i class="fa fa-fire"></i></div>
                <h4 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px;">Manglik Havan</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin: 0;">Traditional Vedic rituals for peace and prosperity.</p>
            </div>
            <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); padding: 25px; border-radius: 16px; text-align: center; backdrop-filter: blur(10px); transition: transform 0.3s ease;">
                <div style="width: 60px; height: 60px; margin: 0 auto 15px; border-radius: 50%; background: rgba(234, 179, 8, 0.2); color: var(--secondary-gold); display: flex; align-items: center; justify-content: center; font-size: 24px;"><i class="fa fa-hands-praying"></i></div>
                <h4 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px;">Shanti Services</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin: 0;">Astrological guidance and remedies for a happy married life.</p>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 35px 25px; border-radius: 20px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.2); border: 1px solid rgba(234,179,8,0.25); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20%; top: -50%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(234,179,8,0.15) 0%, rgba(15,23,42,0) 70%); pointer-events: none;"></div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: clamp(22px, 3.5vw, 30px); font-weight: 800; color: #fff; margin-bottom: 8px;">Register Free and Upload Your Profile</h3>
            <p style="color: #cbd5e1; font-size: 14.5px; margin-bottom: 22px;">Join thousands of verified Sain & Nai community families. Your story is waiting to happen!</p>
            <a href="register.php" class="btn-red" style="background: linear-gradient(135deg, var(--primary-red) 0%, #a11320 100%) !important; padding: 13px 35px; font-size: 14px; border-radius: 30px; font-weight: 800; box-shadow: 0 6px 20px rgba(204,30,43,0.4); text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-user-plus"></i> Register Free Candidate Profile
            </a>
        </div>
    </div>
</section>

<!-- 25,000+ Happy Clients Section -->
<section style="background-color: #f8fafc; padding: 60px 20px; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; overflow: hidden;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 40px; align-items: center;">
            
            <!-- Video/Image Side -->
            <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.12); border: 6px solid #fff; background: #0f172a;">
                <img src="images/trusted_family_story.jpg" alt="Happy Married Couple" style="width: 100%; height: auto; max-height: 420px; display: block; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.4) 100%); display: flex; align-items: center; justify-content: center;">
                    <div style="width: 65px; height: 65px; background: rgba(255,255,255,0.92); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: var(--primary-red); cursor: pointer; box-shadow: 0 0 0 12px rgba(255,255,255,0.25); transition: transform 0.3s ease;">
                        <i class="fa fa-play" style="margin-left: 4px;"></i>
                    </div>
                </div>
                
                <!-- Floating Stats Badge -->
                <div style="position: absolute; bottom: 15px; left: 15px; right: 15px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 12px 18px; border-radius: 14px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 10px 25px rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.8);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: #fef2f2; border-radius: 50%; color: var(--primary-red); display: flex; align-items: center; justify-content: center; font-size: 18px;"><i class="fa fa-heart"></i></div>
                        <div>
                            <div style="font-size: 18px; font-weight: 800; color: #0f172a; line-height: 1;">25,000+</div>
                            <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">Happy Matches</div>
                        </div>
                    </div>
                    <span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px;"><i class="fa fa-check-circle"></i> Verified</span>
                </div>
            </div>

            <!-- Content Side -->
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                    <span style="display: inline-block; background: linear-gradient(135deg, var(--primary-red) 0%, #a11320 100%); color: #fff; font-size: 11px; font-weight: 800; padding: 6px 14px; border-radius: 20px; letter-spacing: 0.8px; text-transform: uppercase; box-shadow: 0 4px 10px rgba(204,30,43,0.25);"><i class="fa fa-shield-alt" style="margin-right: 4px;"></i> India's Most Trusted</span>
                    <span style="font-size: 12px; color: #64748b; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Since 2010</span>
                </div>
                
                <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(26px, 4vw, 38px); font-weight: 800; color: #0f172a; line-height: 1.2; margin-bottom: 20px;">
                    Uniting Families with <span style="color: var(--primary-red);">Tradition</span> & <span style="color: var(--secondary-gold-dark);">Trust.</span>
                </h2>
                
                <div style="display: inline-flex; align-items: center; gap: 10px; margin-bottom: 24px; background: #fff; padding: 8px 16px; border-radius: 50px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                    <div style="color: #eab308; font-size: 15px;"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <span style="font-size: 12.5px; color: #334155; font-weight: 700;">5.0 Rating <span style="color: #94a3b8; font-weight: 500;">(4,850+ Reviews)</span></span>
                </div>

                <?php if ($latest_testimonial): ?>
                    <div style="background: #fff; padding: 22px 24px; border-radius: 16px; box-shadow: 0 8px 25px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; margin-bottom: 25px; position: relative;">
                        <div style="position: absolute; top: -14px; left: 20px; width: 32px; height: 32px; background: var(--primary-red); color: #fff; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 13px; box-shadow: 0 4px 10px rgba(204,30,43,0.3);"><i class="fa fa-quote-left"></i></div>
                        <p style="font-size: 14.5px; color: #334155; font-style: italic; line-height: 1.65; margin-bottom: 12px; padding-top: 4px;">"<?php echo htmlspecialchars($latest_testimonial['story']); ?>"</p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 24px; height: 2px; background: var(--secondary-gold);"></div>
                            <h5 style="font-size: 13px; font-weight: 800; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;"><?php echo htmlspecialchars($latest_testimonial['title']); ?></h5>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px; flex: 1; min-width: 200px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fef2f2; color: var(--primary-red); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;"><i class="fa fa-user-check"></i></div>
                        <div>
                            <h5 style="font-size: 14.5px; font-weight: 700; color: #0f172a; margin-bottom: 3px;">100% Verified</h5>
                            <p style="font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.4;">Every profile is manually checked.</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 12px; flex: 1; min-width: 200px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fffbeb; color: var(--secondary-gold-dark); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;"><i class="fa fa-om"></i></div>
                        <div>
                            <h5 style="font-size: 14.5px; font-weight: 700; color: #0f172a; margin-bottom: 3px;">Traditional Values</h5>
                            <p style="font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.4;">Matching with cultural alignment.</p>
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

<!-- How It Works Section (4 Steps) -->
<section class="section" style="background-color: #ffffff; border-top: 1px solid #e2e8f0; padding: 50px 20px;">
    <div class="container">
        <h2 class="section-title">How Sainmatrimony Works</h2>
        <p class="section-subtitle">4 SIMPLE STEPS TO FIND YOUR PERFECT LIFE PARTNER</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; margin-top: 35px;">
            <div style="background: #f8fafc; padding: 28px 20px; border-radius: 14px; border: 1px solid #e2e8f0; text-align: center; position: relative;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-red); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; margin: 0 auto 15px; box-shadow: 0 4px 12px rgba(204,30,43,0.3);">1</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Create Free Profile</h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">Register in 2 minutes with basic candidate details and upload profile photo.</p>
            </div>

            <div style="background: #f8fafc; padding: 28px 20px; border-radius: 14px; border: 1px solid #e2e8f0; text-align: center; position: relative;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--dark-navy); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; margin: 0 auto 15px;">2</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Filter & Search</h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">Browse verified Sain & Nai profiles by age, education, occupation and city.</p>
            </div>

            <div style="background: #f8fafc; padding: 28px 20px; border-radius: 14px; border: 1px solid #e2e8f0; text-align: center; position: relative;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--secondary-gold-dark); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; margin: 0 auto 15px;">3</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Express Interest</h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">Send direct express interest messages to profiles you find suitable.</p>
            </div>

            <div style="background: #f8fafc; padding: 28px 20px; border-radius: 14px; border: 1px solid #e2e8f0; text-align: center; position: relative;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #16a34a; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; margin: 0 auto 15px;">4</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Connect Families</h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">Our admin desk connects verified families for marriage talks.</p>
            </div>
        </div>
    </div>
</section>

<!-- Assisted Matchmaking Section -->
<section style="background-color: #0b0f19; padding: 60px 20px; color: #fff; overflow: hidden; position: relative;">
    <div style="position: absolute; right: -10%; top: -20%; width: 50%; height: 140%; background: radial-gradient(circle, rgba(234,179,8,0.12) 0%, rgba(11,15,25,0) 70%); pointer-events: none;"></div>
    <div class="container">
        <div style="background: linear-gradient(135deg, #111827 0%, #1f2937 100%); border-radius: 24px; padding: 35px; border: 1px solid rgba(234,179,8,0.25); box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(234, 179, 8, 0.15); color: #f59e0b; border: 1px solid rgba(234, 179, 8, 0.3); font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; margin-bottom: 18px; letter-spacing: 1px; text-transform: uppercase;">
                        <i class="fa fa-crown"></i> Dedicated VIP Service
                    </div>
                    <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(24px, 4vw, 36px); font-weight: 800; color: #fff; line-height: 1.25; margin-bottom: 16px;">
                        Assisted Matchmaking for <span style="color: var(--secondary-gold);">Premium Families</span>
                    </h2>
                    <p style="font-size: 14.5px; color: #9ca3af; line-height: 1.65; margin-bottom: 24px;">
                        Don't have time to search? Let our expert relationship managers do the work for you. We handpick profiles matching your exact criteria, verify backgrounds, and arrange family meetings with 100% confidentiality.
                    </p>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 28px;">
                        <div style="display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.04); padding: 10px 14px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.06);">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(234,179,8,0.2); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;"><i class="fa fa-user-tie"></i></div>
                            <span style="font-size: 13.5px; color: #e5e7eb; font-weight: 600;">Dedicated Personal Relationship Manager</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.04); padding: 10px 14px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.06);">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(234,179,8,0.2); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;"><i class="fa fa-user-shield"></i></div>
                            <span style="font-size: 13.5px; color: #e5e7eb; font-weight: 600;">100% Confidentiality & Background Privacy</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.04); padding: 10px 14px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.06);">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(234,179,8,0.2); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;"><i class="fa fa-gem"></i></div>
                            <span style="font-size: 13.5px; color: #e5e7eb; font-weight: 600;">Handpicked Verified Premium Profiles</span>
                        </div>
                    </div>

                    <a href="contact.php" class="btn-red" style="background: linear-gradient(135deg, var(--primary-red) 0%, #a11320 100%) !important; padding: 13px 30px; font-size: 14.5px; border-radius: 25px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(204,30,43,0.4); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Request VIP Callback <i class="fa fa-arrow-right"></i></a>
                </div>
                <div style="position: relative;">
                    <img src="images/assisted_matchmaking.jpg" alt="Assisted Matchmaking" style="width: 100%; border-radius: 16px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); border: 2px solid rgba(255,255,255,0.15); object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="section" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 60px 20px;">
    <div class="container" style="max-width: 820px;">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle">QUICK ANSWERS ABOUT SAINMATRIMONY SERVICES</p>

        <div style="margin-top: 35px; display: flex; flex-direction: column; gap: 14px;">
            
            <details style="background: #ffffff; padding: 18px 22px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 4px solid var(--primary-red); cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                <summary style="font-size: 15.5px; font-weight: 700; color: #0f172a; outline: none; list-style: none; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa fa-question-circle" style="color: var(--primary-red); margin-right: 10px;"></i> How do I create a candidate profile?</span>
                    <i class="fa fa-chevron-down" style="font-size: 13px; color: #94a3b8;"></i>
                </summary>
                <p style="margin-top: 14px; font-size: 14px; color: #475569; line-height: 1.65; padding-left: 28px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                    Click on the <strong>Register Free</strong> button in the top menu, fill in candidate details (name, gender, age, caste, phone number) and upload a photo. Profiles are manually verified and approved by our team within 24 hours.
                </p>
            </details>

            <details style="background: #ffffff; padding: 18px 22px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 4px solid var(--primary-red); cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                <summary style="font-size: 15.5px; font-weight: 700; color: #0f172a; outline: none; list-style: none; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa fa-user-shield" style="color: var(--primary-red); margin-right: 10px;"></i> Are candidate contact numbers safe & private?</span>
                    <i class="fa fa-chevron-down" style="font-size: 13px; color: #94a3b8;"></i>
                </summary>
                <p style="margin-top: 14px; font-size: 14px; color: #475569; line-height: 1.65; padding-left: 28px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                    Yes, 100%! Phone numbers are strictly confidential. Public visitors cannot view your mobile number. Only our authorized admin desk handles contact details for verified matchmaking inquiries.
                </p>
            </details>

            <details style="background: #ffffff; padding: 18px 22px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 4px solid var(--primary-red); cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                <summary style="font-size: 15.5px; font-weight: 700; color: #0f172a; outline: none; list-style: none; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa fa-gift" style="color: var(--primary-red); margin-right: 10px;"></i> Is profile registration completely free?</span>
                    <i class="fa fa-chevron-down" style="font-size: 13px; color: #94a3b8;"></i>
                </summary>
                <p style="margin-top: 14px; font-size: 14px; color: #475569; line-height: 1.65; padding-left: 28px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                    Yes! Candidate registration and browsing profiles across Sain & Nai communities is 100% free of charge.
                </p>
            </details>

            <details style="background: #ffffff; padding: 18px 22px; border-radius: 14px; border: 1px solid #e2e8f0; border-left: 4px solid var(--primary-red); cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                <summary style="font-size: 15.5px; font-weight: 700; color: #0f172a; outline: none; list-style: none; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa fa-paper-plane" style="color: var(--primary-red); margin-right: 10px;"></i> How do I express interest in a candidate?</span>
                    <i class="fa fa-chevron-down" style="font-size: 13px; color: #94a3b8;"></i>
                </summary>
                <p style="margin-top: 14px; font-size: 14px; color: #475569; line-height: 1.65; padding-left: 28px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                    Open any candidate's profile page and submit the "Express Interest" form. Our team will review your interest and connect both families smoothly.
                </p>
            </details>

        </div>
    </div>
</section>

<!-- Mobile Experience Section -->
<section style="background-color: #fff;  overflow: hidden; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%); padding: 35px; border-radius: 20px; box-shadow: 0 10px 30px rgba(204,30,43,0.04); border: 1px solid #fee2e2;">
            <div style="position: relative; text-align: center;">
                <img src="images/matrimony_app_mockup.jpg" alt="Mobile Friendly Matrimony" style="width: 85%; max-width: 360px; border-radius: 18px; box-shadow: 0 15px 35px rgba(0,0,0,0.12); border: 6px solid #fff;">
            </div>
            <div>
                <span style="display: inline-flex; align-items: center; gap: 6px; background: #fff; border: 1px solid #fca5a5; color: var(--primary-red); font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; margin-bottom: 16px; letter-spacing: 0.8px; text-transform: uppercase;"><i class="fa fa-mobile-alt"></i> Mobile Optimized</span>
                
                <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(24px, 4vw, 36px); font-weight: 800; color: #0f172a; line-height: 1.25; margin-bottom: 16px;">
                    Find Your Perfect Match <span style="color: var(--primary-red);">On The Go!</span>
                </h2>
                
                <p style="font-size: 14.5px; color: #475569; line-height: 1.65; margin-bottom: 22px;">
                    Access verified candidate profiles directly from your smartphone's browser anytime, anywhere. Our website is 100% mobile-friendly, making your search fast and seamless.
                </p>
                
                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 26px;">
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; color: #334155; font-weight: 600;">
                        <i class="fa fa-check-circle" style="color: #16a3a4; font-size: 17px;"></i> No App Download Required
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; color: #334155; font-weight: 600;">
                        <i class="fa fa-check-circle" style="color: #16a3a4; font-size: 17px;"></i> Fast & Data-Friendly Mobile Browsing
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13.5px; color: #334155; font-weight: 600;">
                        <i class="fa fa-check-circle" style="color: #16a3a4; font-size: 17px;"></i> Secure & Private Contact Details
                    </div>
                </div>

                <a href="register.php" class="btn-red" style="padding: 12px 28px; font-size: 14.5px; border-radius: 25px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(204,30,43,0.3);">Create Free Profile <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
