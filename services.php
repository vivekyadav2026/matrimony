<?php
$page_title = "Our Services - Sain & Nai Matrimony";
require_once __DIR__ . '/header.php';
?>

<!-- Page Hero Banner -->
<section style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); color: #fff; padding: 60px 20px 50px; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; left: 50%; top: -50%; transform: translateX(-50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(234,179,8,0.12) 0%, rgba(15,23,42,0) 70%); pointer-events: none;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(234, 179, 8, 0.15); color: var(--secondary-gold); border: 1px solid rgba(234, 179, 8, 0.3); font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; margin-bottom: 16px; letter-spacing: 1px; text-transform: uppercase;">
            <i class="fa fa-hand-holding-heart"></i> Comprehensive Care
        </span>
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(28px, 4.5vw, 46px); font-weight: 800; margin-bottom: 12px; line-height: 1.2;">
            Specialized Services for <span style="color: var(--secondary-gold);">Sain & Nai Families</span>
        </h1>
        <p style="color: #cbd5e1; font-size: 15px; font-weight: 500; max-width: 650px; margin: 0 auto; line-height: 1.6;">
            From verified candidate search to privacy protection and VIP assisted proposals, we provide complete support for your family.
        </p>
    </div>
</section>

<!-- 6 Services Grid Section -->
<section style="background-color: #f8fafc; padding: 60px 20px; border-bottom: 1px solid #e2e8f0;">
    <div class="container" style="max-width: 1100px;">
        <h2 class="section-title">What We Offer</h2>
        <p class="section-subtitle">END-TO-END MATRIMONIAL ASSISTANCE</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-top: 35px;">
            
            <!-- Service 1 -->
            <div style="background: #ffffff; padding: 30px 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: #fef2f2; color: var(--primary-red); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-ring"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Verified Matchmaking</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px; flex: 1;">
                    Specialized filtering and matching for verified candidates ensuring compatible proposals within Sain & Nai Samaj.
                </p>
                <a href="search.php" class="btn-outline" style="color: var(--primary-red) !important; border-color: var(--primary-red); font-size: 13px; text-align: center; border-radius: 20px; font-weight: 700;"><i class="fa fa-search"></i> Search Candidate Profiles</a>
            </div>

            <!-- Service 2 -->
            <div style="background: #ffffff; padding: 30px 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: #fffbeb; color: var(--secondary-gold-dark); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-user-check"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Verified Profile Search</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px; flex: 1;">
                    Every candidate profile is manually screened and verified by our admin team before being published to maintain complete authenticity.
                </p>
                <a href="search.php" class="btn-outline" style="color: var(--secondary-gold-dark) !important; border-color: var(--secondary-gold-dark); font-size: 13px; text-align: center; border-radius: 20px; font-weight: 700;"><i class="fa fa-search"></i> Search Profiles</a>
            </div>

            <!-- Service 3 -->
            <div style="background: #ffffff; padding: 30px 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: #f0fdf4; color: #16a34a; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-handshake"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Parent & Family Meeting Support</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px; flex: 1;">
                    Dedicated support desk facilitating initial family introductions, phone number exchanges, and confidential marriage discussions.
                </p>
                <a href="contact.php" class="btn-outline" style="color: #16a34a !important; border-color: #16a34a; font-size: 13px; text-align: center; border-radius: 20px; font-weight: 700;"><i class="fa fa-comments"></i> Contact Help Desk</a>
            </div>

            <!-- Service 4 -->
            <div style="background: #ffffff; padding: 30px 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: #f0f9ff; color: #0284c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-user-tie"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">VIP Assisted Matchmaking</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px; flex: 1;">
                    Dedicated relationship manager who personally handpicks profiles, contacts opposite families on your behalf, and arranges confidential meetings.
                </p>
                <a href="contact.php" class="btn-outline" style="color: #0284c7 !important; border-color: #0284c7; font-size: 13px; text-align: center; border-radius: 20px; font-weight: 700;"><i class="fa fa-crown"></i> Get VIP Callback</a>
            </div>

            <!-- Service 5 -->
            <div style="background: #ffffff; padding: 30px 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: #fdf2f8; color: #db2777; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-user-shield"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">100% Privacy & Contact Protection</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px; flex: 1;">
                    Your candidate's mobile number is strictly kept confidential from random public visitors. Only authorized admin desk manages contact exchanges.
                </p>
                <a href="register.php" class="btn-outline" style="color: #db2777 !important; border-color: #db2777; font-size: 13px; text-align: center; border-radius: 20px; font-weight: 700;"><i class="fa fa-shield-alt"></i> Register Securely</a>
            </div>

            <!-- Service 6 -->
            <div style="background: #ffffff; padding: 30px 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: #f5f3ff; color: #7c3aed; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-file-invoice"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Professional Biodata Assistance</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px; flex: 1;">
                    Our team assists parents in compiling and formatting clean candidate biodatas with photo uploading support for quick family sharing.
                </p>
                <a href="register.php" class="btn-outline" style="color: #7c3aed !important; border-color: #7c3aed; font-size: 13px; text-align: center; border-radius: 20px; font-weight: 700;"><i class="fa fa-user-plus"></i> Submit Biodata</a>
            </div>

        </div>

    </div>
</section>

<!-- How It Works Section -->
<section style="background-color: #ffffff; padding: 60px 20px;">
    <div class="container" style="max-width: 1000px;">
        <h2 class="section-title">How Our Matchmaking Works</h2>
        <p class="section-subtitle">4 SIMPLE STEPS TO FIND YOUR LIFE PARTNER</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 35px; text-align: center;">
            <div style="padding: 20px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--primary-red); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; margin: 0 auto 12px; font-size: 16px;">1</div>
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Free Registration</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.5;">Fill candidate details and upload a photo in 2 minutes.</p>
            </div>
            <div style="padding: 20px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; margin: 0 auto 12px; font-size: 16px;">2</div>
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Profile Verification</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.5;">Admin desk manually screens and approves every profile.</p>
            </div>
            <div style="padding: 20px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--secondary-gold-dark); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; margin: 0 auto 12px; font-size: 16px;">3</div>
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Express Interest</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.5;">Select compatible matches and express interest confidentially.</p>
            </div>
            <div style="padding: 20px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #16a34a; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; margin: 0 auto 12px; font-size: 16px;">4</div>
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Family Meeting</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.5;">Our desk facilitates contact exchange for marriage talks.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section style="background: linear-gradient(180deg, #0b0f19 0%, #0f172a 100%); padding: 60px 20px; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; left: 50%; top: -30%; transform: translateX(-50%); width: 500px; height: 500px; background: radial-gradient(circle, rgba(234,179,8,0.14) 0%, rgba(11,15,25,0) 70%); pointer-events: none;"></div>
    <div class="container" style="max-width: 800px; position: relative; z-index: 1;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(234, 179, 8, 0.12); color: var(--secondary-gold); border: 2px solid rgba(234,179,8,0.3); display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 20px; box-shadow: 0 0 25px rgba(234,179,8,0.25);">
            <i class="fa fa-headset"></i>
        </div>
        <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(26px, 4vw, 38px); font-weight: 800; margin-bottom: 14px; color: #ffffff; line-height: 1.25;">
            Need Personal Assistance with <span style="color: var(--secondary-gold);">Matchmaking?</span>
        </h2>
        <p style="font-size: 15px; color: #cbd5e1; margin-bottom: 30px; line-height: 1.65; max-width: 620px; margin-left: auto; margin-right: auto;">
            Contact our helpline desk or request a VIP relationship manager callback today for confidential candidate proposals.
        </p>
        <div style="display: flex; justify-content: center; align-items: center; gap: 14px; flex-wrap: wrap;">
            <a href="contact.php" class="btn-red" style="background: linear-gradient(135deg, var(--primary-red) 0%, #a11320 100%) !important; padding: 14px 32px; font-size: 13.5px; border-radius: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 6px 20px rgba(204,30,43,0.4); border: 1px solid rgba(255,255,255,0.15); display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-headset"></i> Contact Support Desk
            </a>
            <a href="register.php" class="btn-outline" style="background: rgba(255, 255, 255, 0.08); color: #ffffff !important; padding: 14px 30px; font-size: 13.5px; border-radius: 8px; font-weight: 700; border: 1px solid rgba(255, 255, 255, 0.25); backdrop-filter: blur(5px); text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-paper-plane"></i> Submit Biodata
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>

