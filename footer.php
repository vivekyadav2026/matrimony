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
                        <li><a href="<?php echo BASE_URL; ?>stories.php">Success Stories</a></li>
                        <li><a href="<?php echo BASE_URL; ?>register.php">Register Free</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #fff; margin-bottom: 15px; font-size: 16px;">Services</h4>
                    <ul style="list-style: none; line-height: 2;">
                        <li>Manglik Marriage</li>
                        <li>Kundli Match Making</li>
                        <li>Manglik Nivaran Havan</li>
                        <li>Manglik Shanti Services</li>
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
    });
    </script>
</body>
</html>
