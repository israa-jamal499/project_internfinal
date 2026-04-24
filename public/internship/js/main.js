console.log("UCAS Internship Portal loaded");

/* ===== Search ===== */
const searchBtn = document.getElementById("searchBtn");
const searchInput = document.getElementById("searchInput");

if (searchBtn && searchInput) {
    searchBtn.addEventListener("click", () => {
        const value = searchInput.value.trim();

        if (value === "") {
            alert("اكتب كلمة للبحث أولاً 😊");
            return;
        }

        window.location.href = `/front/home/opportunities?search=${encodeURIComponent(value)}`;
    });

    searchInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            searchBtn.click();
        }
    });
}

/* ===== Side Menu ===== */
const menuBtn = document.getElementById("btn_sidmenu");
const closeBtn = document.getElementById("closeMenu");
const sideMenu = document.getElementById("sideMenu");
const overlay = document.getElementById("overlay");

function openMenu() {
    if (!sideMenu || !overlay) return;

    sideMenu.classList.add("active");
    overlay.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeMenu() {
    if (!sideMenu || !overlay) return;

    sideMenu.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "auto";
}

if (menuBtn && sideMenu && overlay) {
    menuBtn.addEventListener("click", () => {
        sideMenu.classList.toggle("active");
        overlay.classList.toggle("active");

        document.body.style.overflow =
            sideMenu.classList.contains("active") ? "hidden" : "auto";
    });
}

if (closeBtn) {
    closeBtn.addEventListener("click", closeMenu);
}

if (overlay) {
    overlay.addEventListener("click", closeMenu);
}

document.querySelectorAll(".side-menu a").forEach(link => {
    link.addEventListener("click", closeMenu);
});

/* ===== Hero Search ===== */
const heroBtn = document.getElementById("heroSearchBtn");
const heroInput = document.getElementById("heroSearchInput");

if (heroBtn && heroInput) {
    heroBtn.addEventListener("click", () => {
        const value = heroInput.value.trim();

        if (!value) {
            alert("اكتب كلمة للبحث 😊");
            return;
        }

        window.location.href = `/front/home/opportunities?search=${encodeURIComponent(value)}`;
    });
}

/* ===== Step Boxes Animation ===== */
const boxes = document.querySelectorAll(".step-box");

if (boxes.length > 0) {
    window.addEventListener("scroll", () => {
        boxes.forEach(box => {
            const boxTop = box.getBoundingClientRect().top;

            if (boxTop < window.innerHeight - 100) {
                box.style.opacity = "1";
                box.style.transform = "translateY(0)";
            }
        });
    });
}

/* ===== Navbar Scroll ===== */
const navbar = document.querySelector(".navbar");

if (navbar) {
    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
}

/* ===== Hero Background Effect ===== */
const hero = document.querySelector(".hero-mostaql");

if (hero) {
    window.addEventListener("scroll", () => {
        let offset = window.scrollY;
        hero.style.backgroundPositionY = offset * 0.5 + "px";
    });
}

/* ===== Reveal On Scroll ===== */
const reveals = document.querySelectorAll(".reveal");

function revealOnScroll() {
    reveals.forEach(el => {
        const top = el.getBoundingClientRect().top;

        if (top < window.innerHeight - 100) {
            el.classList.add("active");
        }
    });
}

if (reveals.length > 0) {
    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll();
}

/* ===== Opportunities Page JS ===== */
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const majorFilter = document.getElementById("majorFilter");
    const typeFilter = document.getElementById("typeFilter");
    const cardsContainer = document.getElementById("cardsContainer");
    const emptyState = document.getElementById("emptyState");

    if (!cardsContainer || !searchInput || !majorFilter || !typeFilter || !emptyState) {
        return;
    }

    const cards = cardsContainer.querySelectorAll(".op-card");

    function filterCards() {
        const searchValue = searchInput.value.trim().toLowerCase();
        const majorValue = majorFilter.value;
        const typeValue = typeFilter.value;

        let visibleCount = 0;

        cards.forEach((card) => {
            const title = card.querySelector("h3")?.innerText.toLowerCase() || "";
            const company = card.querySelector(".company")?.innerText.toLowerCase() || "";
            const desc = card.querySelector(".desc")?.innerText.toLowerCase() || "";

            const cardMajor = card.getAttribute("data-major") || "";
            const cardType = card.getAttribute("data-type") || "";

            const matchSearch =
                title.includes(searchValue) ||
                company.includes(searchValue) ||
                desc.includes(searchValue);

            const matchMajor =
                majorValue === "all" ||
                cardMajor.split(",").includes(majorValue);

            const matchType = typeValue === "all" || typeValue === cardType;

            if (matchSearch && matchMajor && matchType) {
                card.style.display = "block";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        emptyState.style.display = visibleCount === 0 ? "block" : "none";
    }

    searchInput.addEventListener("input", filterCards);
    majorFilter.addEventListener("change", filterCards);
    typeFilter.addEventListener("change", filterCards);

    filterCards();
});

/* ===== Opportunity Details Page JS ===== */


/* ===== Account Boxes ===== */
document.querySelectorAll('.account-box').forEach(box => {
    box.addEventListener('click', () => {
        document.querySelectorAll('.account-box').forEach(b => b.classList.remove('active'));
        box.classList.add('active');
    });
});

/* ===== Reset Password ===== */
function sendResetLink(e) {
    e.preventDefault();

    const emailInput = document.getElementById("resetEmail");
    const email = emailInput ? emailInput.value : "";

    alert("تم إرسال رابط إعادة تعيين كلمة المرور إلى: " + email);
    window.location.href = "/front/auth/login";
}
