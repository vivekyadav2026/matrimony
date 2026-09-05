<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' | Search Profiles by Caste and Community'; ?></title>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>images/favicon.png?v=<?php echo filemtime(__DIR__ . '/images/favicon.png'); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css?v=<?php echo filemtime(__DIR__ . '/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Permanently Hide Google Translate Top Banner & Custom Language Switcher Script -->
    <style>
        .goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate,
        iframe.goog-te-banner-frame,
        iframe[id*=":1.container"],
        iframe[id*=":2.container"],
        iframe[id*=":0.container"],
        iframe[class*="goog-te-banner"],
        .VIpgJd-Z44fyf-l4e28-viewer,
        .VIpgJd-Z44fyf-SHaLGe-VJg90e,
        .VIpgJd-Z44fyf-a93Wvd,
        #goog-gt-tt,
        .goog-te-balloon-frame,
        .goog-tooltip,
        .goog-tooltip:hover {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            width: 0 !important;
            max-height: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }
        html, body {
            top: 0px !important;
            position: static !important;
            margin-top: 0px !important;
            padding-top: 0px !important;
        }
        .goog-te-gadget { color: transparent !important; font-size: 0 !important; }
        .goog-te-gadget .goog-te-combo { display: none !important; }
        #goog-gt-tt { display: none !important; }
        .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; }
    </style>

    <div id="google_translate_element" style="display:none;"></div>
    
    <script type="text/javascript">
        var langDict = {
            'Home': 'ਮੁੱਖ ਪੰਨਾ',
            'Profiles': 'ਪ੍ਰੋਫਾਈਲਾਂ',
            'Browse Profiles': 'ਪ੍ਰੋਫਾਈਲਾਂ ਵੇਖੋ',
            'About Us': 'ਸਾਡੇ ਬਾਰੇ',
            'About': 'ਸਾਡੇ ਬਾਰੇ',
            'Services': 'ਸੇਵਾਵਾਂ',
            'Success Stories': 'ਸਫਲਤਾ ਦੀਆਂ ਕਹਾਣੀਆਂ',
            'Stories': 'ਕਹਾਣੀਆਂ',
            'Contact': 'ਸੰਪਰਕ',
            'Contact Desk': 'ਸੰਪਰਕ ਡੈਸਕ',
            'Submit Biodata': 'ਬਾਇਓਡਾਟਾ ਜਮ੍ਹਾਂ ਕਰੋ',
            'Search Profiles': 'ਪ੍ਰੋਫਾਈਲ ਖੋਜੋ',
            'Send Interest': 'ਰਿਸ਼ਤੇ ਲਈ ਸੁਨੇਹਾ',
            'Request Contact': 'ਸੰਪਰਕ ਕਰੋ',
            'Chat on WhatsApp': 'WhatsApp \'ਤੇ ਗੱਲਬਾਤ ਕਰੋ',
            'WhatsApp': 'WhatsApp',
            'Call Us': 'ਕਾਲ ਕਰੋ',
            'Call': 'ਕਾਲ ਕਰੋ',
            'Email': 'ਈਮੇਲ',
            'Location': 'ਸਥਾਨ',
            'View Full Profile →': 'ਪੂਰੀ ਪ੍ਰੋਫਾਈਲ ਵੇਖੋ →',
            'View Profiles': 'ਪ੍ਰੋਫਾਈਲਾਂ ਵੇਖੋ',
            'Submit Your Biodata': 'ਆਪਣਾ ਬਾਇਓਡਾਟਾ ਜਮ੍ਹਾਂ ਕਰੋ',
            'Find Verified Matrimonial Matches': 'ਪੂਰੇ ਭਰੋਸੇ ਨਾਲ ਪ੍ਰਮਾਣਿਤ ਮੈਚ ਲੱਭੋ',
            'Looking For': 'ਦੀ ਤਲਾਸ਼',
            'Age': 'ਉਮਰ',
            'Religion': 'ਧਰਮ',
            'Caste': 'ਜਾਤ',
            'Search': 'ਖੋਜੋ',
            'Female': 'ਔਰਤ',
            'Male': 'ਮਰਦ',
            'Quick Links': 'ਤੁਰੰਤ ਲਿੰਕ',
            'Our Services': 'ਸਾਡੀਆਂ ਸੇਵਾਵਾਂ',
            'All Rights Reserved.': 'ਸਾਰੇ ਹੱਕ ਰਾਖਵੇਂ ਹਨ।'
        };

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,pa',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function setSiteLanguage(langCode) {
            localStorage.setItem('matrimony_lang', langCode);
            var domain = window.location.hostname;
            
            // Set cookie for path=/ and current domain
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + domain + ";";

            if (langCode !== 'en') {
                document.cookie = "googtrans=/en/" + langCode + "; path=/;";
                document.cookie = "googtrans=/en/" + langCode + "; path=/; domain=" + domain + ";";
            } else {
                document.cookie = "googtrans=/en/en; path=/;";
                document.cookie = "googtrans=/en/en; path=/; domain=" + domain + ";";
            }

            var select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = langCode;
                select.dispatchEvent(new Event('change'));
            }

            applyDOMTranslation(langCode);
        }

        function applyDOMTranslation(lang) {
            if (lang === 'pa') {
                var walker = document.createTreeWalker(document.body || document.documentElement, NodeFilter.SHOW_TEXT, null, false);
                var node;
                while (node = walker.nextNode()) {
                    if (node.parentElement && (node.parentElement.classList.contains('notranslate') || node.parentElement.closest('.notranslate') || node.parentElement.getAttribute('translate') === 'no')) {
                        continue;
                    }
                    var text = node.nodeValue.trim();
                    if (text && langDict[text]) {
                        node.nodeValue = node.nodeValue.replace(text, langDict[text]);
                    }
                }
                localStorage.setItem('switched_to_pa', 'true');
            } else if (lang === 'en' && localStorage.getItem('switched_to_pa')) {
                localStorage.removeItem('switched_to_pa');
                location.reload();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var currentLang = localStorage.getItem('matrimony_lang') || 'en';
            
            // Sync all language dropdown selects on page load
            var selects = document.querySelectorAll('.site-lang-select');
            selects.forEach(function(s) {
                s.value = currentLang;
            });

            if (currentLang === 'pa') {
                applyDOMTranslation('pa');
            }

            // Auto-remove Google Translate top banner if injected on mobile/desktop
            setInterval(function() {
                var banners = document.querySelectorAll('iframe.goog-te-banner-frame, .goog-te-banner-frame, .VIpgJd-Z44fyf-l4e28-viewer, iframe[id*="container"], .VIpgJd-Z44fyf-a93Wvd');
                for (var i = 0; i < banners.length; i++) {
                    banners[i].style.display = 'none';
                    banners[i].style.visibility = 'hidden';
                    banners[i].style.height = '0px';
                    if (banners[i].parentNode) {
                        banners[i].parentNode.removeChild(banners[i]);
                    }
                }
                if (document.body && document.body.style.top !== '0px') {
                    document.body.style.top = '0px';
                }
                if (document.documentElement && document.documentElement.style.top !== '0px') {
                    document.documentElement.style.top = '0px';
                }
            }, 150);
        });
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <ul>
                <li><a href="<?php echo BASE_URL; ?>register.php"><i class="fa fa-paper-plane"></i> Submit Biodata</a></li>
                <li><a href="<?php echo BASE_URL; ?>search.php"><i class="fa fa-search"></i> Search Profiles</a></li>
            </ul>

            <!-- Desktop Language Select Dropdown Option (Protected from Translation) -->
            <div class="notranslate" translate="no" style="display: flex; align-items: center; gap: 8px;">
                <span class="notranslate" translate="no" style="color: #cbd5e1; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa fa-language" style="color: var(--secondary-gold, #f59e0b);"></i> Language:
                </span>
                <select class="site-lang-select notranslate" translate="no" onchange="setSiteLanguage(this.value)" style="background: #0f172a; color: #f8fafc; border: 1px solid #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; outline: none;">
                    <option value="en" class="notranslate" translate="no">English</option>
                    <option value="pa" class="notranslate" translate="no">ਪੰਜਾਬੀ</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Main Header Navigation -->
    <header class="main-header">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>" class="logo notranslate" translate="no" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="<?php echo BASE_URL; ?>images/favicon.png" alt="Sain Matrimony Logo" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #fee2e2; background: #fff;">
                <div class="logo-text notranslate" translate="no">Sain<span>matrimony.in</span></div>
            </a>
            
            <button type="button" id="mobileNavToggle" class="mobile-nav-toggle" aria-label="Toggle Navigation Menu">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="nav-links" id="mainNavLinks">
                <li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>search.php"><i class="fa fa-search"></i> Profiles</a></li>
                <li><a href="<?php echo BASE_URL; ?>about.php"><i class="fa fa-info-circle"></i> About Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>services.php"><i class="fa fa-cogs"></i> Services</a></li>
                <li><a href="<?php echo BASE_URL; ?>stories.php"><i class="fa fa-heart"></i> Stories</a></li>
                <li><a href="<?php echo BASE_URL; ?>contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
                <li><a href="<?php echo BASE_URL; ?>register.php" class="btn-red"><i class="fa fa-paper-plane"></i> Submit Biodata</a></li>
            </ul>
        </div>
    </header>

    <!-- Rishta Sangam Style Mobile Navigation Drawer & Overlay -->
    <div class="mobile-drawer-overlay" id="mobileDrawerOverlay"></div>
    <div class="mobile-drawer" id="mobileDrawer">
        <!-- Drawer Header -->
        <div class="mobile-drawer-header">
            <div class="mobile-drawer-brand notranslate" translate="no">
                <div class="brand-heart-icon"><i class="fa fa-heart"></i></div>
                <div>
                    <div class="brand-name notranslate" translate="no">SAIN MATRIMONY</div>
                    <div class="brand-sub notranslate" translate="no">COMMUNITY MATRIMONY</div>
                </div>
            </div>
            <button type="button" class="drawer-close-btn" id="closeMobileDrawer" aria-label="Close Menu">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <!-- Drawer Body -->
        <div class="mobile-drawer-body">
            <div class="drawer-section-label notranslate" translate="no">🌐 LANGUAGE / ਭਾਸ਼ਾ</div>
            <div class="notranslate" translate="no" style="margin-bottom: 15px;">
                <select class="site-lang-select notranslate" translate="no" onchange="setSiteLanguage(this.value)" style="width: 100%; background: #ffffff; color: #0f172a; border: 1.5px solid #cbd5e1; padding: 10px 12px; border-radius: 8px; font-size: 13.5px; font-weight: 700; cursor: pointer; outline: none; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <option value="en" class="notranslate" translate="no">English</option>
                    <option value="pa" class="notranslate" translate="no">ਪੰਜਾਬੀ</option>
                </select>
            </div>

            <div class="drawer-section-label">MENU</div>
            
            <div class="drawer-menu-list">
                <a href="<?php echo BASE_URL; ?>" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-home"></i></div>
                    <span class="drawer-card-text">Home</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>
                
                <a href="<?php echo BASE_URL; ?>search.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-users"></i></div>
                    <span class="drawer-card-text">Browse Profiles</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>about.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-info-circle"></i></div>
                    <span class="drawer-card-text">About</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>services.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-hand-holding-heart"></i></div>
                    <span class="drawer-card-text">Services</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>stories.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-heart"></i></div>
                    <span class="drawer-card-text">Success Stories</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>contact.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-envelope"></i></div>
                    <span class="drawer-card-text">Contact Desk</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>
            </div>
        </div>

        <!-- Drawer Footer Buttons -->
        <div class="mobile-drawer-footer">
            <a href="<?php echo BASE_URL; ?>register.php" class="drawer-btn-primary">
                Submit Biodata
            </a>
            <div class="drawer-dual-btns">
                <a href="tel:8528600100" class="drawer-btn-call">
                    <i class="fa fa-phone-alt"></i> Call
                </a>
                <a href="https://wa.me/918528600100?text=Hello%20Sainmatrimony,%20I%20want%20to%20inquire%20about%20matrimonial%20profiles" target="_blank" class="drawer-btn-whatsapp">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
