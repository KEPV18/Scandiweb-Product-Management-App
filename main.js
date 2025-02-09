document.addEventListener('DOMContentLoaded', function () {
    // Handle mass delete button click
    document.querySelector('form[method="POST"]').addEventListener('submit', function (e) {
        const checkboxes = document.querySelectorAll('input[name="product_ids[]"]:checked');
        if (checkboxes.length === 0) {
            e.preventDefault(); // Prevent form submission
            // Display an error message instead of using alert()
            const errorMessage = document.createElement('div');
            errorMessage.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
            errorMessage.textContent = 'Please select at least one product to delete.';
            document.body.insertBefore(errorMessage, document.body.firstChild);
        }
    });

    // Toggle edit form visibility
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const card = this.closest('.bg-card'); // Find the parent card container
            const editForm = card.querySelector('.edit-form'); // Find the edit form inside the card
            if (editForm) {
                editForm.classList.toggle('hidden'); // Toggle visibility of the edit form
            }
        });
    });

    // Cancel button functionality
    document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function () {
            const editForm = this.closest('.edit-form'); // Find the closest edit form
            if (editForm) {
                editForm.classList.add('hidden'); // Hide the edit form
            }
        });
    });

    // Ensure cards view is visible on page load
    const cardsView = document.getElementById('cards-view');
    if (cardsView) {
        cardsView.classList.remove('hidden'); // Make sure the cards view is visible
    }
});