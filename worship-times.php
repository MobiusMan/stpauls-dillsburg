<?php
/**
 * Template Name: Worship Times
 * Description: Displays a button to show worship times in a popup
 */

?>

    <!-- Modal -->
    <div class="modal fade" id="worshipTimesModal" tabindex="-1" aria-labelledby="worshipTimesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="worshipTimesModalLabel">Worship Times</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Sunday Worship Service with Full Liturgy and Music</strong><br>Held each Sunday at 10:30AM</p>
                    <p>We livestream the Sunday service each week through <a href="https://www.facebook.com/StPaulsDillsburg/" target="_blank" rel="noopener noreferrer">our Facebook Page</a>.</p>
                    <p><strong>Saturday Worship Service of the Spoken Word</strong><br>Held on the 2nd &amp; 4th Saturdays of each month at 6:30PM</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('worshipTimesButton');
    const modalElement = document.getElementById('worshipTimesModal');

    if (button && modalElement) {
        // Remove Bootstrap data attributes to prevent automatic modal trigger
        button.removeAttribute('data-bs-toggle');
        button.removeAttribute('data-bs-target');

        // Manually handle modal open
        button.addEventListener('click', function() {
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            modalElement.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');

            // Add backdrop manually
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        });

        // Handle modal close
        const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                modalElement.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            });
        });

        // Close modal when clicking outside
        modalElement.addEventListener('click', function(e) {
            if (e.target === modalElement) {
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                modalElement.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        });
    } else {
        console.error('Button or modal element not found.');
    }
});
</script>

