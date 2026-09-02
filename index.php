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

<!-- Petal Animation Script for Hero Banner -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const heroBanner = document.querySelector('.hero-banner');
    if (heroBanner) {
        const petalCount = 30; // Number of petals falling
        for (let i = 0; i < petalCount; i++) {
            createPetal(heroBanner);
        }
    }

    function createPetal(container) {
        const petal = document.createElement('div');
        petal.classList.add('petal');
        
        // Randomize size, position, and animation duration for organic look
        const size = Math.random() * 15 + 10; // 10px to 25px
        const leftPos = Math.random() * 100; // 0% to 100% width
        const animDuration = Math.random() * 5 + 5; // 5s to 10s
        const animDelay = Math.random() * 5; // 0s to 5s delay

        // Apply styles
        petal.style.width = size + 'px';
        petal.style.height = size + 'px';
        petal.style.left = leftPos + '%';
        petal.style.animationDuration = animDuration + 's';
        petal.style.animationDelay = animDelay + 's';
        
        // Randomly tint some petals slightly orange/gold for Indian theme
        if (Math.random() > 0.7) {
            petal.style.backgroundColor = '#f59e0b'; // Marigold color
        }

        container.appendChild(petal);
    }
});
</script>

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

        <div style="background: linear-gradient(90deg, var(--secondary-gold) 0%, #d97706 100%); padding: 30px; border-radius: 16px; text-align: center; box-shadow: 0 10px 30px rgba(217, 119, 6, 0.3);">
            <h3 style="font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 6px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Register Free and Upload Your Profile</h3>
            <p style="color: #fff; font-size: 15px; margin-bottom: 20px; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Your story is waiting to happen!</p>
            <a href="register.php" class="btn-red" style="background: #fff !important; color: #d97706 !important; padding: 14px 40px; font-size: 16px; border-radius: 30px; font-weight: 800; box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-transform: uppercase;">Register Now!</a>
        </div>
    </div>
</section>

<!-- 25,000+ Happy Clients Section -->
<section style="background-color: #f8fafc; padding: 70px 20px; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 50px; align-items: center;">
            
            <!-- Video/Image Side -->
            <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.12); border: 8px solid #fff;">
                <img src="images/testimonial-video.png" alt="Testimonial Video" style="width: 100%; display: block; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center;">
                    <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; color: var(--primary-red); cursor: pointer; box-shadow: 0 0 0 15px rgba(255,255,255,0.2); transition: all 0.3s ease;">
                        <i class="fa fa-play" style="margin-left: 5px;"></i>
                    </div>
                </div>
                
                <!-- Floating Stats Badge -->
                <div style="position: absolute; bottom: 20px; left: 20px; background: #fff; padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; gap: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                    <div style="width: 45px; height: 45px; background: #fef2f2; border-radius: 50%; color: var(--primary-red); display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="fa fa-heart"></i></div>
                    <div>
                        <div style="font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1;">25K+</div>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">Happy Matches</div>
                    </div>
                </div>
            </div>

            <!-- Content Side -->
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <span style="display: inline-block; background: linear-gradient(135deg, var(--primary-red) 0%, #a11320 100%); color: #fff; font-size: 11px; font-weight: 800; padding: 6px 14px; border-radius: 20px; letter-spacing: 1px; text-transform: uppercase; box-shadow: 0 4px 10px rgba(204,30,43,0.3);"><i class="fa fa-shield-alt" style="margin-right: 4px;"></i> India's Most Trusted</span>
                    <span style="font-size: 13px; color: #64748b; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Since 2010</span>
                </div>
                
                <h2 style="font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 800; color: #0f172a; line-height: 1.15; margin-bottom: 25px;">
                    Uniting Families with <span style="color: var(--primary-red);">Tradition</span> & <span style="color: var(--secondary-gold-dark);">Trust.</span>
                </h2>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 30px; background: #fff; padding: 10px 15px; border-radius: 50px; display: inline-flex; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                    <div style="color: #eab308; font-size: 16px;"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <span style="font-size: 13px; color: #334155; font-weight: 700;">5.0 Rating <span style="color: #94a3b8; font-weight: 500;">(4,850+ Reviews)</span></span>
                </div>

                <?php if ($latest_testimonial): ?>
                    <div style="background: #fff; padding: 25px 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; margin-bottom: 35px; position: relative; z-index: 1;">
                        <div style="position: absolute; top: -15px; left: 25px; width: 35px; height: 35px; background: var(--primary-red); color: #fff; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 14px; box-shadow: 0 4px 10px rgba(204,30,43,0.3);"><i class="fa fa-quote-left"></i></div>
                        <p style="font-size: 15.5px; color: #334155; font-style: italic; line-height: 1.7; margin-bottom: 15px; padding-top: 5px;">"<?php echo htmlspecialchars($latest_testimonial['story']); ?>"</p>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 30px; height: 2px; background: var(--secondary-gold);"></div>
                            <h5 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;"><?php echo htmlspecialchars($latest_testimonial['title']); ?></h5>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fef2f2; color: var(--primary-red); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;"><i class="fa fa-user-check"></i></div>
                        <div>
                            <h5 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">100% Verified</h5>
                            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.4;">Every profile is manually checked.</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fffbeb; color: var(--secondary-gold-dark); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;"><i class="fa fa-om"></i></div>
                        <div>
                            <h5 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Traditional Values</h5>
                            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.4;">Matching with cultural alignment.</p>
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
<section style="background-color: #0f172a; padding: 70px 20px; color: #fff; overflow: hidden; position: relative;">
    <div style="position: absolute; right: -10%; top: -20%; width: 50%; height: 140%; background: radial-gradient(circle, rgba(234,179,8,0.15) 0%, rgba(15,23,42,0) 70%);"></div>
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div data-aos="fade-right">
                <span style="display: inline-block; background: rgba(234, 179, 8, 0.2); color: var(--secondary-gold); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 20px; margin-bottom: 15px; letter-spacing: 0.5px; text-transform: uppercase;"><i class="fa fa-gem"></i> VIP Service</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 20px;">
                    Assisted Matchmaking for Premium Families
                </h2>
                <p style="font-size: 15px; color: #94a3b8; line-height: 1.6; margin-bottom: 25px;">
                    Don't have time to search? Let our expert relationship managers do the work for you. We handpick profiles that match your exact criteria, verify their background, and arrange meetings between families with utmost confidentiality.
                </p>
                <ul style="list-style: none; padding: 0; margin-bottom: 30px; display: flex; flex-direction: column; gap: 12px;">
                    <li style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #cbd5e1;"><i class="fa fa-check-circle" style="color: var(--secondary-gold); font-size: 18px;"></i> Dedicated Relationship Manager</li>
                    <li style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #cbd5e1;"><i class="fa fa-check-circle" style="color: var(--secondary-gold); font-size: 18px;"></i> 100% Confidentiality & Privacy</li>
                    <li style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #cbd5e1;"><i class="fa fa-check-circle" style="color: var(--secondary-gold); font-size: 18px;"></i> Handpicked Premium Profiles</li>
                </ul>
                <a href="contact.php" class="btn-red" style="padding: 12px 35px; font-size: 15px; border-radius: 25px; display: inline-flex; align-items: center; gap: 8px;">Request VIP Callback <i class="fa fa-arrow-right"></i></a>
            </div>
            <div data-aos="fade-left" style="position: relative;">
                <img src="images/assisted_matchmaking.jpg" alt="Assisted Matchmaking" style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); border: 4px solid rgba(255,255,255,0.1);">
            </div>
        </div>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="section" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 50px 20px;">
    <div class="container" style="max-width: 850px;">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle">COMMON QUESTIONS ABOUT SAINMATRIMONY SERVICES</p>

        <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 15px;">
            
            <details style="background: #ffffff; padding: 18px 22px; border-radius: 12px; border: 1px solid #cbd5e1; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <summary style="font-size: 16px; font-weight: 700; color: #0f172a; outline: none;"><i class="fa fa-question-circle" style="color: var(--primary-red); margin-right: 8px;"></i> How do I create a candidate profile?</summary>
                <p style="margin-top: 12px; font-size: 14px; color: #475569; line-height: 1.6;">
                    Click on the <strong>Register Free</strong> button in the navigation menu, fill in candidate details (name, gender, age, caste, phone number) and submit. Profiles are verified and approved within 24 hours.
                </p>
            </details>

            <details style="background: #ffffff; padding: 18px 22px; border-radius: 12px; border: 1px solid #cbd5e1; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <summary style="font-size: 16px; font-weight: 700; color: #0f172a; outline: none;"><i class="fa fa-question-circle" style="color: var(--primary-red); margin-right: 8px;"></i> Are candidate contact numbers safe and private?</summary>
                <p style="margin-top: 12px; font-size: 14px; color: #475569; line-height: 1.6;">
                    Yes, 100%! Mobile numbers are strictly confidential and protected. No random user can view your phone number on public profiles. Only authorized admin desk can access numbers for verified matchmaking inquiries.
                </p>
            </details>

            <details style="background: #ffffff; padding: 18px 22px; border-radius: 12px; border: 1px solid #cbd5e1; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <summary style="font-size: 16px; font-weight: 700; color: #0f172a; outline: none;"><i class="fa fa-question-circle" style="color: var(--primary-red); margin-right: 8px;"></i> Is registration completely free?</summary>
                <p style="margin-top: 12px; font-size: 14px; color: #475569; line-height: 1.6;">
                    Yes, profile registration and searching candidates across Sain and Nai communities is 100% free of cost.
                </p>
            </details>

            <details style="background: #ffffff; padding: 18px 22px; border-radius: 12px; border: 1px solid #cbd5e1; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <summary style="font-size: 16px; font-weight: 700; color: #0f172a; outline: none;"><i class="fa fa-question-circle" style="color: var(--primary-red); margin-right: 8px;"></i> How do I express interest in a candidate?</summary>
                <p style="margin-top: 12px; font-size: 14px; color: #475569; line-height: 1.6;">
                    Open any candidate's profile page and fill out the "Express Interest" form at the right side. Our team will review your request and forward your introduction to candidate's family.
                </p>
            </details>

        </div>
    </div>
</section>

<!-- Mobile Experience Section -->
<section style="background-color: #fff; padding: 70px 20px; overflow: hidden; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; background: linear-gradient(135deg, #fef2f2 0%, #fff 100%); padding: 40px; border-radius: 24px; box-shadow: 0 10px 40px rgba(204,30,43,0.05); border: 1px solid #fee2e2;">
            <div data-aos="fade-right" style="position: relative; text-align: center;">
                <img src="images/matrimony_app_mockup.jpg" alt="Mobile Friendly Matrimony" style="width: 85%; max-width: 400px; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); border: 8px solid #fff;">
            </div>
            <div data-aos="fade-left">
                <span style="display: inline-block; background: #fff; border: 1px solid #e2e8f0; color: var(--primary-red); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 20px; margin-bottom: 15px; letter-spacing: 0.5px; text-transform: uppercase;"><i class="fa fa-mobile-alt"></i> Mobile Optimized</span>
                
                <h2 style="font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 800; color: #0f172a; line-height: 1.2; margin-bottom: 20px;">
                    Find Your Perfect Match <span style="color: var(--primary-red);">On The Go!</span>
                </h2>
                
                <p style="font-size: 15px; color: #475569; line-height: 1.6; margin-bottom: 25px;">
                    Stay connected and get instant access to verified profiles directly from your smartphone's browser. Our website is 100% mobile-friendly, making your soulmate search faster, smoother, and easier anywhere you go.
                </p>
                
                <ul style="list-style: none; padding: 0; margin-bottom: 30px; display: flex; flex-direction: column; gap: 12px;">
                    <li style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #334155;"><i class="fa fa-check-circle" style="color: var(--primary-red); font-size: 18px;"></i> No App Download Required</li>
                    <li style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #334155;"><i class="fa fa-check-circle" style="color: var(--primary-red); font-size: 18px;"></i> Fast & Data-Friendly Browsing</li>
                    <li style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #334155;"><i class="fa fa-check-circle" style="color: var(--primary-red); font-size: 18px;"></i> Secure & Private Access</li>
                </ul>
                <a href="register.php" class="btn-red" style="padding: 12px 30px; font-size: 15px; border-radius: 25px; display: inline-flex; align-items: center; gap: 8px;">Create Free Profile <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
