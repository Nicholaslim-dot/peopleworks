document.addEventListener('DOMContentLoaded', function() {
    const leaveForm = document.getElementById('leaveForm');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const totalDaysInput = document.getElementById('totalDays');
    const dayTypeSelect = document.getElementById('dayType');

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    startDateInput.min = today;
    endDateInput.min = today;

    // Auto-fill today's date for start date
    startDateInput.value = today;

    // Calculate total days when dates change
    startDateInput.addEventListener('change', calculateDays);
    endDateInput.addEventListener('change', calculateDays);
    dayTypeSelect.addEventListener('change', calculateDays);

    function calculateDays() {
        if (startDateInput.value && endDateInput.value) {
            const start = new Date(startDateInput.value);
            const end = new Date(endDateInput.value);

            const diffTime = Math.abs(end - start);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            // Adjust for half day selection
            if (dayTypeSelect.value === 'half_am' || dayTypeSelect.value === 'half_pm') {
                diffDays = 0.5;
            }

            totalDaysInput.value = diffDays;
        }
    }

    // Draft button functionality
    const draftBtn = document.getElementById('draftBtn');
    if (draftBtn) {
        draftBtn.addEventListener('click', function() {
            alert('Your leave application has been saved as a draft (not submitted).');
        });
    }

    // Form submission — let Laravel handle it
    leaveForm.addEventListener('submit', function() {
        // Hide any previous messages (optional, Laravel will flash success/error)
        if (successMessage) successMessage.style.display = 'none';
        if (errorMessage) errorMessage.style.display = 'none';

        // Do not call e.preventDefault() here — allow normal POST
        // Browser will send the form to /leave/submit and Laravel will save it
    });
});
