document.addEventListener("DOMContentLoaded", function () {
    initTopbarMenus();
    initActiveLinks();
    initDashboard();
    initStudentsPage();
    initCompaniesPage();
    initCertificatesPage();
});

/* =========================
   Topbar / Dropdowns
========================= */
function initTopbarMenus() {
    const notifBtn = document.getElementById("notifBtn");
    const notifDropdown = document.getElementById("notifDropdown");

    const companyMenuBtn = document.getElementById("companyMenuBtn");
    const companyDropdown = document.getElementById("companyDropdown");

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            if (companyDropdown) companyDropdown.style.display = "none";
            notifDropdown.classList.toggle("active");
        });
    }

    if (companyMenuBtn && companyDropdown) {
        companyMenuBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            if (notifDropdown) notifDropdown.classList.remove("active");
            companyDropdown.style.display =
                companyDropdown.style.display === "block" ? "none" : "block";
        });
    }

    document.addEventListener("click", function () {
        if (notifDropdown) notifDropdown.classList.remove("active");
        if (companyDropdown) companyDropdown.style.display = "none";
    });

    if (notifDropdown) {
        notifDropdown.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    }

    if (companyDropdown) {
        companyDropdown.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    }
}

/* =========================
   Active Sidebar Links
========================= */
function initActiveLinks() {
    const navLinks = document.querySelectorAll(".company-pages-container a");
    if (!navLinks.length) return;

    const currentPage = window.location.pathname.split("/").pop();

    navLinks.forEach(function (link) {
        const href = link.getAttribute("href");
        if (!href) return;

        const linkPage = href.split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });
}

/* =========================
   Dashboard
========================= */
function initDashboard() {
    const counters = document.querySelectorAll("[data-count]");
    if (!counters.length) return;

    counters.forEach(function (el) {
        const target = Number(el.getAttribute("data-count")) || 0;
        let current = 0;
        const step = Math.max(1, Math.ceil(target / 45));

        const timer = setInterval(function () {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = current;
        }, 20);
    });

    const refreshBtn = document.getElementById("refreshBtn");
    const exportBtn = document.getElementById("exportBtn");
    const clearLogBtn = document.getElementById("clearLogBtn");
    const logList = document.getElementById("logList");

    if (refreshBtn) {
        refreshBtn.addEventListener("click", function () {
            location.reload();
        });
    }

    if (exportBtn) {
        exportBtn.addEventListener("click", function () {
            alert("تصدير تقرير (تجريبي) ✅");
        });
    }

    if (clearLogBtn && logList) {
        clearLogBtn.addEventListener("click", function () {
            logList.innerHTML = `
                <li class="log-item">
                    <span class="tag tag-blue">معلومة</span>
                    <div>
                        <b>لا يوجد نشاطات حالياً</b>
                        <span class="subtext">تم مسح السجل</span>
                    </div>
                </li>
            `;
        });
    }

    drawBars("internStatusChart", [64, 28, 18, 9]);

    window.addEventListener("resize", function () {
        drawBars("internStatusChart", [64, 28, 18, 9]);
    });
}

function drawBars(canvasId, values) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    const parentWidth = canvas.parentElement ? canvas.parentElement.clientWidth : 400;
    canvas.width = Math.max(320, parentWidth - 10);

    const w = canvas.width;
    const h = canvas.height;

    ctx.clearRect(0, 0, w, h);

    const max = Math.max(...values, 1);
    const padding = 18;
    const usableW = w - padding * 2;
    const usableH = h - 26;

    const barW = Math.floor(usableW / (values.length * 1.6));
    const gap = Math.floor(barW * 0.6);

    let x = padding;

    values.forEach(function (v) {
        const barH = Math.round((v / max) * usableH);
        ctx.fillRect(x, h - barH - 10, barW, barH);
        x += barW + gap;
    });
}

/* =========================
   Students Page
========================= */
function initStudentsPage() {
    const table = document.getElementById("studentsTable");
    if (!table) return;

    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const searchInput = document.getElementById("searchInput");
    const departmentFilter = document.getElementById("departmentFilter");
    const statusFilter = document.getElementById("statusFilter");
    const resetBtn = document.getElementById("resetBtn");
    const shownCount = document.getElementById("shownCount");
    const allCount = document.getElementById("allCount");

    const modal = document.getElementById("studentModal");
    const closeModal = document.getElementById("closeModal");
    const cancelBtn = document.getElementById("cancelBtn");
    const xClose = document.getElementById("xClose");

    const mName = document.getElementById("mName");
    const mId = document.getElementById("mId");
    const mDept = document.getElementById("mDept");
    const mEmail = document.getElementById("mEmail");
    const mStatus = document.getElementById("mStatus");
    const mCompany = document.getElementById("mCompany");

    function filterRows() {
        const search = searchInput ? searchInput.value.trim().toLowerCase() : "";
        const dept = departmentFilter ? departmentFilter.value : "all";
        const status = statusFilter ? statusFilter.value : "all";

        let visibleCount = 0;

        rows.forEach(function (row) {
            const name = (row.dataset.name || "").toLowerCase();
            const id = (row.dataset.id || "").toLowerCase();
            const email = (row.dataset.email || "").toLowerCase();
            const rowDept = row.dataset.dept || "";
            const rowStatus = row.dataset.status || "";

            const matchSearch =
                name.includes(search) ||
                id.includes(search) ||
                email.includes(search);

            const matchDept = dept === "all" || rowDept === dept;
            const matchStatus = status === "all" || rowStatus === status;

            if (matchSearch && matchDept && matchStatus) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });

        if (shownCount) shownCount.textContent = visibleCount;
        if (allCount) allCount.textContent = rows.length;
    }

    if (searchInput) searchInput.addEventListener("input", filterRows);
    if (departmentFilter) departmentFilter.addEventListener("change", filterRows);
    if (statusFilter) statusFilter.addEventListener("change", filterRows);

    if (resetBtn) {
        resetBtn.addEventListener("click", function () {
            if (searchInput) searchInput.value = "";
            if (departmentFilter) departmentFilter.value = "all";
            if (statusFilter) statusFilter.value = "all";
            filterRows();
        });
    }

    const viewButtons = document.querySelectorAll('.actions .icon-btn[title="عرض"]');
    viewButtons.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            if (!modal) return;
            e.preventDefault();

            const row = this.closest("tr");
            if (!row) return;

            if (mName) mName.textContent = row.dataset.name || "-";
            if (mId) mId.textContent = row.dataset.id || "-";
            if (mDept) mDept.textContent = row.dataset.dept || "-";
            if (mEmail) mEmail.textContent = row.dataset.email || "-";
            if (mStatus) mStatus.textContent = row.dataset.status || "-";
            if (mCompany) mCompany.textContent = row.dataset.company || "-";

            modal.classList.add("show");
            modal.setAttribute("aria-hidden", "false");
        });
    });

    function closeStudentModal() {
        if (!modal) return;
        modal.classList.remove("show");
        modal.setAttribute("aria-hidden", "true");
    }

    [closeModal, cancelBtn, xClose].forEach(function (el) {
        if (el) el.addEventListener("click", closeStudentModal);
    });

    filterRows();
}

/* =========================
   Companies Page
========================= */
function initCompaniesPage() {
    const table = document.getElementById("companiesTable");
    if (!table) return;

    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const searchInput = document.getElementById("companySearchInput");
    const fieldFilter = document.getElementById("fieldFilter");
    const statusFilter = document.getElementById("companyStatusFilter");
    const companiesCount = document.getElementById("companiesCount");
    const exportBtn = document.getElementById("exportCompaniesBtn");

    function filterRows() {
        const q = searchInput ? searchInput.value.trim().toLowerCase() : "";
        const field = fieldFilter ? fieldFilter.value : "all";
        const status = statusFilter ? statusFilter.value : "all";

        let visible = 0;

        rows.forEach(function (row) {
            const name = (row.dataset.name || "").toLowerCase();
            const email = (row.dataset.email || "").toLowerCase();
            const rowField = row.dataset.field || "";
            const rowStatus = row.dataset.status || "";

            const matchSearch = !q || name.includes(q) || email.includes(q);
            const matchField = field === "all" || rowField === field;
            const matchStatus = status === "all" || rowStatus === status;

            row.style.display = (matchSearch && matchField && matchStatus) ? "" : "none";

            if (row.style.display !== "none") visible++;
        });

        if (companiesCount) companiesCount.textContent = `عدد الشركات: ${visible}`;
    }

    if (searchInput) searchInput.addEventListener("input", filterRows);
    if (fieldFilter) fieldFilter.addEventListener("change", filterRows);
    if (statusFilter) statusFilter.addEventListener("change", filterRows);

    if (exportBtn) {
        exportBtn.addEventListener("click", function () {
            alert("ميزة التصدير سيتم ربطها لاحقًا في Laravel ✅");
        });
    }

    filterRows();
}

/* =========================
   Certificates Page
========================= */
function initCertificatesPage() {
    const certTbody = document.getElementById("certTbody");
    if (!certTbody) return;

    const STORAGE_KEY = "admin_certificates_v1";

    const statusLabel = {
        active: "فعّالة",
        pending: "بانتظار اعتماد",
        revoked: "ملغاة"
    };

    function seedData() {
        return [
            { id: 1, code: "CERT-2026-A9K2", student: "أحمد علي", sid: "220243221", company: "شركة التقنية الحديثة", period: "2026-01-10 → 2026-03-10", status: "active", issuedAt: "2026-03-12" },
            { id: 2, code: "CERT-2026-Q7T4", student: "سارة محمد", sid: "220243199", company: "مؤسسة الأفق", period: "2026-01-15 → 2026-03-15", status: "pending", issuedAt: "2026-03-16" }
        ];
    }

    function loadCertificates() {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) {
            const seeded = seedData();
            localStorage.setItem(STORAGE_KEY, JSON.stringify(seeded));
            return seeded;
        }

        try {
            return JSON.parse(raw) || [];
        } catch {
            return [];
        }
    }

    function badgeClass(status) {
        if (status === "active") return "badge active";
        if (status === "pending") return "badge pending";
        return "badge revoked";
    }

    let certificates = loadCertificates();
    let filtered = [...certificates];

    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const sortBy = document.getElementById("sortBy");

    function applyFilters() {
        const q = searchInput ? searchInput.value.trim().toLowerCase() : "";
        const st = statusFilter ? statusFilter.value : "all";
        const sort = sortBy ? sortBy.value : "newest";

        filtered = certificates.filter(function (c) {
            const hay = `${c.code} ${c.student} ${c.sid} ${c.company} ${c.period} ${c.issuedAt}`.toLowerCase();
            const matchQ = !q || hay.includes(q);
            const matchSt = st === "all" || c.status === st;
            return matchQ && matchSt;
        });

        filtered.sort(function (a, b) {
            if (sort === "oldest") return (a.issuedAt || "").localeCompare(b.issuedAt || "");
            if (sort === "student") return (a.student || "").localeCompare(b.student || "", "ar");
            return (b.issuedAt || "").localeCompare(a.issuedAt || "");
        });

        renderTable();
    }

    function renderTable() {
        certTbody.innerHTML = "";

        filtered.forEach(function (c, index) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><strong>${c.code}</strong></td>
                <td>${c.student}</td>
                <td>${c.sid}</td>
                <td>${c.company}</td>
                <td>${c.period}</td>
                <td><span class="${badgeClass(c.status)}">${statusLabel[c.status]}</span></td>
                <td>${c.issuedAt}</td>
            `;
            certTbody.appendChild(tr);
        });
    }

    if (searchInput) searchInput.addEventListener("input", applyFilters);
    if (statusFilter) statusFilter.addEventListener("change", applyFilters);
    if (sortBy) sortBy.addEventListener("change", applyFilters);

    applyFilters();
}
