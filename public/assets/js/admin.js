document.addEventListener('DOMContentLoaded', () => {
    // Admin Sidebar Toggle (for mobile if needed)
    const sidebar = document.querySelector('.sidebar');
    // ... logic for responsive sidebar ...

    // Confirmation for Delete Buttons
    const deleteBtns = document.querySelectorAll('.btn-danger-admin, a[onclick*="confirm"]');
    // Already handled by inline onclick in most cases, but could add global handler here.

    // Slug auto-generation for journals
    const journalNameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    if (journalNameInput && slugInput && !slugInput.value) {
        journalNameInput.addEventListener('input', () => {
            const slug = journalNameInput.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        });
    }

    // Modal or Alert auto-hide
    const badges = document.querySelectorAll('.badge-success');
    badges.forEach(badge => {
        setTimeout(() => {
            badge.style.opacity = '0';
            badge.style.transition = 'opacity 1s ease';
        }, 3000);
    });
});
