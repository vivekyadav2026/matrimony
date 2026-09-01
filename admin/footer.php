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
    }
});
</script>

</body>
</html>
