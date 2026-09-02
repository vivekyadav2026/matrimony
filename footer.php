    <!-- Footer -->
    <footer>
        <div class="container" style="padding-bottom: 30px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px;">
                <div>
                    <h3 style="color: #fff; margin-bottom: 15px; font-size: 18px;">Sainmatrimony.in</h3>
                    <p style="margin-bottom: 15px; line-height: 1.6;">Most Trusted Matrimonial Platform for Hindu, Punjabi, Marathi, Tamil & Bengali Marriages. 100% Verified Profiles.</p>
                </div>
                <div>
                    <h4 style="color: #fff; margin-bottom: 15px; font-size: 16px;">Quick Links</h4>
                    <ul style="list-style: none; line-height: 2;">
                        <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>search.php">Search Profiles</a></li>
                        <li><a href="<?php echo BASE_URL; ?>about.php">About Us</a></li>
                        <!-- <li><a href="<?php echo BASE_URL; ?>membership.php">Membership Plans</a></li> -->
                        <li><a href="<?php echo BASE_URL; ?>stories.php">Success Stories</a></li>
                        <li><a href="<?php echo BASE_URL; ?>contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #fff; margin-bottom: 15px; font-size: 16px;">Services</h4>
                    <ul style="list-style: none; line-height: 2;">
                        <li><a href="<?php echo BASE_URL; ?>services.php">Manglik Marriage</a></li>
                        <li><a href="<?php echo BASE_URL; ?>services.php">Kundli Match Making</a></li>
                        <li><a href="<?php echo BASE_URL; ?>services.php">Manglik Nivaran Havan</a></li>
                        <li><a href="<?php echo BASE_URL; ?>services.php">Manglik Shanti Services</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #fff; margin-bottom: 15px; font-size: 16px;">Contact & Support</h4>
                    <p style="margin-bottom: 10px;"><i class="fa fa-envelope" style="color: var(--secondary-yellow);"></i> support@sainmatrimony.in</p>
                    <p style="margin-bottom: 10px;"><i class="fa fa-phone" style="color: var(--secondary-yellow);"></i> +91 98765 43210</p>
                    <p><i class="fa fa-map-marker-alt" style="color: var(--secondary-yellow);"></i> New Delhi, India</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <strong>Sainmatrimony.in</strong>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Full Image Preview Lightbox Modal -->
    <div id="imagePreviewModal" style="display:none; position:fixed; z-index:9999; inset:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(5px); align-items:center; justify-content:center; flex-direction:column; padding:20px;">
        <span id="closePreviewModal" style="position:absolute; top:20px; right:25px; color:#fff; font-size:35px; cursor:pointer; font-weight:bold; line-height:1;">&times;</span>
        <img id="previewModalImage" src="" alt="Full Preview" style="max-width:90%; max-height:85vh; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,0.5); object-fit:contain; border:3px solid #fff;">
        <span id="previewModalCaption" style="color:#fff; margin-top:12px; font-size:15px; font-weight:600;"></span>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var mobileNavToggle = document.getElementById('mobileNavToggle');
        var mainNavLinks = document.getElementById('mainNavLinks');

        if (mobileNavToggle && mainNavLinks) {
            mobileNavToggle.addEventListener('click', function() {
                mainNavLinks.classList.toggle('nav-open');
                var icon = mobileNavToggle.querySelector('i');
                if (icon) {
                    if (mainNavLinks.classList.contains('nav-open')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });
        }

        // Live File Upload Image Preview Handler (e.g. register.php)
        var fileInput = document.getElementById('profilePhotoInput');
        var previewImg = document.getElementById('imagePreview');
        var previewBox = document.getElementById('imagePreviewBox');

        if (fileInput && previewImg) {
            fileInput.addEventListener('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(evt) {
                        previewImg.src = evt.target.result;
                        if (previewBox) previewBox.style.display = 'flex';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Click to Preview Image Lightbox Modal Handler
        var modal = document.getElementById('imagePreviewModal');
        var modalImg = document.getElementById('previewModalImage');
        var modalCaption = document.getElementById('previewModalCaption');
        var closeModal = document.getElementById('closePreviewModal');

        if (modal && modalImg) {
            document.body.addEventListener('click', function(e) {
                var target = e.target;
                if (target.tagName === 'IMG' && target.id !== 'previewModalImage' && (target.closest('.profile-img-wrap') || target.closest('.profile-card') || target.src.includes('/images/'))) {
                    modal.style.display = 'flex';
                    modalImg.src = target.src;
                    modalCaption.innerText = target.alt || 'Profile Image Preview';
                }
            });

            if (closeModal) {
                closeModal.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    });
    </script>

    <!-- AOS Animation Library JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Auto-inject AOS attributes to standard elements across all pages
            const animatedClasses = [
                '.section-title', '.section-subtitle', '.profile-card', 
                '.story-card-modern', '.service-card-yellow', 'details', 
                '.search-box', '.hero-title', '.hero-subtitle', 
                '.clients-wrapper', '.blessings-card', '.form-group'
            ];
            
            animatedClasses.forEach(selector => {
                const elements = document.querySelectorAll(selector);
                elements.forEach((el, index) => {
                    if (!el.hasAttribute('data-aos')) {
                        el.setAttribute('data-aos', 'fade-up');
                        el.setAttribute('data-aos-duration', '800');
                        // Stagger effect for multiple items like cards
                        if (index > 0 && index < 4 && (selector === '.profile-card' || selector === '.story-card-modern' || selector === '.service-card-yellow' || selector === 'details')) {
                            el.setAttribute('data-aos-delay', (index * 100).toString());
                        }
                    }
                });
            });

            // Initialize AOS
            AOS.init({
                once: true, // whether animation should happen only once - while scrolling down
                offset: 50, // offset (in px) from the original trigger point
            });
        });
    </script>
</body>
</html>
