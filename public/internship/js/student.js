document.addEventListener("DOMContentLoaded", () => {
    initStudentDropdowns();
    initStudentNavActive();
    initStudentPageTitle();
});

/* =========================
   Shared Dropdowns
========================= */
function initStudentDropdowns() {
    const notifBtn = document.getElementById("notifBtn");
    const notifDropdown = document.getElementById("notifDropdown");

    const studentMenuBtn = document.getElementById("studentMenuBtn");
    const studentDropdown = document.getElementById("studentDropdown");

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle("show");

            if (studentDropdown) {
                studentDropdown.classList.remove("show");
            }
        });
    }

    if (studentMenuBtn && studentDropdown) {
        studentMenuBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            studentDropdown.classList.toggle("show");

            if (notifDropdown) {
                notifDropdown.classList.remove("show");
            }
        });
    }

    if (notifDropdown) {
        notifDropdown.addEventListener("click", (e) => e.stopPropagation());
    }

    if (studentDropdown) {
        studentDropdown.addEventListener("click", (e) => e.stopPropagation());
    }

    document.addEventListener("click", () => {
        if (notifDropdown) notifDropdown.classList.remove("show");
        if (studentDropdown) studentDropdown.classList.remove("show");
    });
}

/* =========================
   Active Nav Link
========================= */
function initStudentNavActive() {
    const links = document.querySelectorAll(".student-pages-container a");
    const currentUrl = window.location.href;
    const currentPath = window.location.pathname.replace(/\/$/, "");

    links.forEach(link => {
        const linkUrl = link.href;
        const linkPath = new URL(linkUrl, window.location.origin).pathname.replace(/\/$/, "");

        if (currentUrl === linkUrl || currentPath === linkPath) {
            link.classList.add("active");
        }
    });
}

/* =========================
   Dynamic Page Title
========================= */
function initStudentPageTitle() {
    const pageTitle = document.getElementById("pageTitle");
    if (!pageTitle) return;

    const activeLink = document.querySelector(".student-pages-container a.active");
    if (activeLink && activeLink.dataset.title) {
        pageTitle.textContent = activeLink.dataset.title;
        return;
    }

    const currentPage = window.location.pathname.split("/").pop();

    const titles = {
        "dashboard": "لوحة الطالب",
        "profile": "الملف الشخصي",
        "applications": "طلباتي",
        "internship": "ملف التدريب",
        "messages": "الرسائل",
        "weekly-reports": "التقارير",
        "hours": "ساعات التدريب",
        "certificate": "الشهادة",
        "notifications": "الإشعارات"
    };

    if (titles[currentPage]) {
        pageTitle.textContent = titles[currentPage];
    }
}
// student.js
document.querySelectorAll('.progress-fill').forEach(el => {
    el.style.width = '0%';
    setTimeout(() => {
        el.style.width = '68%';
    }, 300);
});
