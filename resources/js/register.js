document.addEventListener('DOMContentLoaded', () => {
    // Confirm before deleting
    document.querySelectorAll('.btn-danger').forEach(button => {
      button.addEventListener('click', (e) => {
        if (!confirm('Are you sure you want to delete this user?')) {
          e.preventDefault();
        }
      });
    });
  });
