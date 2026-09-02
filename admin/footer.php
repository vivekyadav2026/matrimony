    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var layout = document.querySelector('.admin-layout');
    var toggleBtn = document.getElementById('sidebarToggle');
    
    // Auto-collapse logic
    if (window.innerWidth > 768 && localStorage.getItem('admin_sidebar_collapsed') === 'true') {
        layout.classList.add('sidebar-collapsed');
    }

    // Add mobile overlay
    var overlay = document.createElement('div');
    overlay.className = 'admin-sidebar-overlay';
    document.body.appendChild(overlay);

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth > 768) {
                layout.classList.toggle('sidebar-collapsed');
                var isCollapsed = layout.classList.contains('sidebar-collapsed');
                localStorage.setItem('admin_sidebar_collapsed', isCollapsed);
            } else {
                layout.classList.toggle('sidebar-mobile-open');
            }
        });
    }

    // Close sidebar on mobile when clicking overlay
    overlay.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            layout.classList.remove('sidebar-mobile-open');
        }
    });

    // Close sidebar on mobile when clicking a menu link
    var sidebarLinks = document.querySelectorAll('.sidebar-menu a');
    sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                layout.classList.remove('sidebar-mobile-open');
            }
        });
    });

    // Automatic Image Input Live Preview Handler
    var adminFileInput = document.getElementById('adminPhotoInput');
    var adminPreviewImg = document.getElementById('adminImagePreview');
    var adminPreviewBox = document.getElementById('adminImagePreviewBox');

    if (adminFileInput && adminPreviewImg) {
        adminFileInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(evt) {
                    adminPreviewImg.src = evt.target.result;
                    if (adminPreviewBox) adminPreviewBox.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>

</body>
</html>
