    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var layout = document.querySelector('.admin-layout');
    var toggleBtn = document.getElementById('sidebarToggle');
    
    // Restore saved sidebar collapse state
    if (localStorage.getItem('admin_sidebar_collapsed') === 'true') {
        layout.classList.add('sidebar-collapsed');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            layout.classList.toggle('sidebar-collapsed');
            var isCollapsed = layout.classList.contains('sidebar-collapsed');
            localStorage.setItem('admin_sidebar_collapsed', isCollapsed);
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
