document.addEventListener("DOMContentLoaded", function () {
    feather.replace();
});

document.querySelectorAll('.step-header').forEach(function(header) {
    header.addEventListener('click', function() {
        const targetId = this.getAttribute('data-bs-target');
        const targetBody = document.querySelector(targetId);
        const isActive = this.classList.contains('active');

        // Reset semua step
        document.querySelectorAll('.step-body').forEach(function(body) {
            body.classList.remove('show');
        });
        document.querySelectorAll('.step-header').forEach(function(h) {
            h.classList.remove('active');
            const icon = h.querySelector('.toggle-icon');
            if (icon) {
                icon.classList.remove('ph-minus-circle');
                icon.classList.add('ph-plus-circle');
            }
        });

        // Jika sebelumnya belum aktif, maka buka
        if (!isActive) {
            targetBody.classList.add('show');
            this.classList.add('active');
            const icon = this.querySelector('.toggle-icon');
            icon.classList.remove('ph-plus-circle');
            icon.classList.add('ph-minus-circle');
        }
    });
});



    function toggleForm() {
        const registerForm = document.getElementById('registerForm');
        const loginForm = document.getElementById('loginForm');
        const imageSection = document.getElementById('imageSection');

        registerForm.classList.toggle('d-none');
        loginForm.classList.toggle('d-none');

        // Optional: flip image to opposite side or keep it depending on design
        imageSection.classList.toggle('order-md-first');
    }



