<?php
$page_title = "Services - Sain & Nai Matrimony";
require_once __DIR__ . '/header.php';
?>

<!-- Page Banner -->
<div style="background: linear-gradient(180deg, var(--dark-navy) 0%, #0d121a 100%); color: #fff; padding: 45px 20px 40px; text-align: center;">
    <div class="container">
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 38px; font-weight: 800; margin-bottom: 8px;">Our Specialized Services</h1>
        <p style="color: #cbd5e1; font-size: 15px;">Comprehensive Matrimonial & Astrological Assistance for Sain & Nai Families</p>
    </div>
</div>

<div class="section" style="background-color: #f8fafc; padding: 50px 0;">
    <div class="container">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            
            <div style="background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <div style="width: 55px; height: 55px; background: #fef2f2; color: var(--primary-red); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-ring"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Manglik Matchmaking</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 15px;">
                    Specialized filtering and matching for high, Anshik, or mild Manglik candidates ensuring compatible astrological horoscopes.
                </p>
                <a href="search.php" class="btn-outline" style="color: var(--primary-red) !important; border-color: var(--primary-red); font-size: 13px;">Find Matches &rarr;</a>
            </div>

            <div style="background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <div style="width: 55px; height: 55px; background: #fffbeb; color: var(--secondary-gold-dark); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-star"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Kundli & Guna Matching</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 15px;">
                    Detailed 36 Guna analysis, Nadi Dosha check, and planetary position verification before family interactions.
                </p>
                <a href="contact.php" class="btn-outline" style="color: var(--secondary-gold-dark) !important; border-color: var(--secondary-gold-dark); font-size: 13px;">Consult Astrologer &rarr;</a>
            </div>

            <div style="background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <div style="width: 55px; height: 55px; background: #f0fdf4; color: #16a34a; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-fire"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Manglik Nivaran Havan</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 15px;">
                    Guidance and arrangement for traditional Vedic Havans and Shanti Pujas for peace and matrimonial prosperity.
                </p>
                <a href="contact.php" class="btn-outline" style="color: #16a34a !important; border-color: #16a34a; font-size: 13px;">Book Puja &rarr;</a>
            </div>

            <div style="background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <div style="width: 55px; height: 55px; background: #f0f9ff; color: #0284c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px;">
                    <i class="fa fa-phone-alt"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Personal Assistant & Tele-Calling</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 15px;">
                    Our executive will call opposite candidate families on your behalf to present your proposal confidentially.
                </p>
                <a href="register.php" class="btn-outline" style="color: #0284c7 !important; border-color: #0284c7; font-size: 13px;">Get Assisted Service &rarr;</a>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
