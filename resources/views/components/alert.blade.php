@if (session('success') || session('error'))
    <div class="alert-container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

<style>
    .alert-container {
        position: fixed; /* Fixes the alert to the viewport */
        top: 20px; /* Distance from the top */
        right: 20px; /* Distance from the right */
        z-index: 9999; /* Make sure it appears on top */
    }

    .alert {
        border-radius: 5; /* Make it square */
        opacity: 1; /* Fully visible */
        transition: opacity 0.5s ease-in-out; /* Smooth transition for fade out */
        margin-bottom: 10px; /* Space between alerts */
    }

    .alert-success {
        background-color: #d4edda; /* Light green background */
        color: #155724; /* Dark green text */
        border: 1px solid #c3e6cb; /* Green border */
    }

    .alert-danger {
        background-color: #f8d7da; /* Light red background */
        color: #721c24; /* Dark red text */
        border: 1px solid #f5c6cb; /* Red border */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0'; // Fade out
                setTimeout(() => {
                    alert.remove(); // Remove from DOM
                }, 500); // Delay removal until fade out is complete
            }, 3000); // Show alert for 3 seconds
        });
    });
</script>
