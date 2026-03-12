<!-- footer.php -->
</div> <!-- closes main-content -->
</div> <!-- closes d-flex -->

<footer class="bg-dark text-white text-center py-3">
    &copy; <?php echo date('Y'); ?> CMCS. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('hidden');
    // Save state
    const isHidden = sidebar.classList.contains('hidden');
    localStorage.setItem('sidebarHidden', isHidden);
}

// On page load, check state
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const isHidden = localStorage.getItem('sidebarHidden') === 'true';
    if (isHidden) {
        sidebar.classList.add('hidden');
    }
});
</script>
</body>
</html>