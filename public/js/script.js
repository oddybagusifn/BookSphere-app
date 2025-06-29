document.addEventListener("DOMContentLoaded", function () {
    feather.replace();
});

document.querySelectorAll(".step-header").forEach(function (header) {
    header.addEventListener("click", function () {
        const targetId = this.getAttribute("data-bs-target");
        const targetBody = document.querySelector(targetId);
        const isActive = this.classList.contains("active");

        // Reset semua step
        document.querySelectorAll(".step-body").forEach(function (body) {
            body.classList.remove("show");
        });
        document.querySelectorAll(".step-header").forEach(function (h) {
            h.classList.remove("active");
            const icon = h.querySelector(".toggle-icon");
            if (icon) {
                icon.classList.remove("ph-minus-circle");
                icon.classList.add("ph-plus-circle");
            }
        });

        // Jika sebelumnya belum aktif, maka buka
        if (!isActive) {
            targetBody.classList.add("show");
            this.classList.add("active");
            const icon = this.querySelector(".toggle-icon");
            icon.classList.remove("ph-plus-circle");
            icon.classList.add("ph-minus-circle");
        }
    });
});

function toggleForm() {
    const registerForm = document.getElementById("registerForm");
    const loginForm = document.getElementById("loginForm");
    const imageSection = document.getElementById("imageSection");

    registerForm.classList.toggle("d-none");
    loginForm.classList.toggle("d-none");

    // Optional: flip image to opposite side or keep it depending on design
    imageSection.classList.toggle("order-md-first");
}

document.addEventListener("DOMContentLoaded", function () {
    // COUNT UP SCORE
    const ratingEl = document.getElementById("averageRating");
    const target = parseFloat(ratingEl.dataset.target);
    let count = 0;
    const duration = 1000;
    const frameRate = 10;
    const increment = target / (duration / frameRate);

    const interval = setInterval(() => {
        count += increment;
        if (count >= target) {
            count = target;
            clearInterval(interval);
        }
        ratingEl.innerText = count.toFixed(1);
    }, frameRate);

    // DYNAMIC STARS
    const starsContainer = document.getElementById("averageStars");
    const fullStars = parseFloat(target); // contoh: 4.3
    starsContainer.innerHTML = ""; // kosongkan isi sebelumnya

    for (let i = 1; i <= 5; i++) {
        const img = document.createElement("img");
        const diff = fullStars - i;

        if (diff >= 0) {
            img.src = "/img/star.svg"; // bintang penuh
        } else {
            img.src = "/img/star-disabled.svg"; // bintang kosong
        }

        img.alt = "Star";
        img.width = 16;
        starsContainer.appendChild(img);
    }

    // PROGRESS BAR ANIMATION
    document.querySelectorAll(".progress-bar").forEach((bar) => {
        const targetPercent = parseFloat(bar.dataset.progress);
        setTimeout(() => {
            bar.style.transition = "width 1s ease";
            bar.style.width = `${targetPercent}%`;
        }, 100); // short delay so animation is visible
    });
});

const cartSidebar = document.getElementById("cartSidebar");
const cartOverlay = document.getElementById("cartOverlay");
const openCartBtn = document.querySelector(".ph-shopping-cart"); // pastikan pakai class yg sama
const closeCartBtn = document.getElementById("closeCart");

function openCart() {
    cartSidebar.classList.add("show");

    // Tunggu sedikit sebelum menampilkan overlay untuk jamin render
    setTimeout(() => {
        cartOverlay.classList.add("show");
    }, 10);

    document.body.style.overflow = "hidden";
}

function closeCart() {
    cartSidebar.classList.remove("show");
    cartOverlay.classList.remove("show");
    document.body.style.overflow = "";
}

openCartBtn.addEventListener("click", (e) => {
    e.preventDefault();
    openCart();
});

closeCartBtn.addEventListener("click", closeCart);
cartOverlay.addEventListener("click", closeCart);

document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const bookId = this.dataset.id;

        fetch("/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({ book_id: bookId }),
        })
            .then((response) => response.json())
            .then((data) => {
                // Jika berhasil, update isi keranjang
                loadCartView(); // Ambil data baru dari server
                openCart(); // Tampilkan cart sidebar
            });
    });
});

function loadCartView() {
    fetch("/cart/view")
        .then((res) => res.text())
        .then((html) => {
            document.querySelector(".cart-body").innerHTML = html;
        });
}

function openCart() {
    document.getElementById("cartSidebar").classList.add("show");
    document.getElementById("cartOverlay").classList.add("show");
    document.body.classList.add("no-scroll");
}
