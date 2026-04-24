document.addEventListener("DOMContentLoaded", () => {

  const notifBtn = document.getElementById("notifBtn");
  const notifDropdown = document.getElementById("notifDropdown");

  const companyMenuBtn = document.getElementById("companyMenuBtn");
  const companyDropdown = document.getElementById("companyDropdown");

  // Toggle Notifications
  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener("click", (e) => {
      e.stopPropagation();

      // اقفلي قائمة الطالب لو مفتوحة
      if (companyDropdown) companyDropdown.style.display = "none";

      notifDropdown.classList.toggle("active");
    });
  }

  // Toggle Student Menu
  if (companyMenuBtn && companyDropdown) {
    companyMenuBtn.addEventListener("click", (e) => {
      e.stopPropagation();

      // اقفلي الإشعارات لو مفتوحة
      if (notifDropdown) notifDropdown.classList.remove("active");

      // فتح/إغلاق
      companyDropdown.style.display =
        companyDropdown.style.display === "block" ? "none" : "block";
    });
  }

  // Close when clicking outside
  document.addEventListener("click", () => {
    if (notifDropdown) notifDropdown.classList.remove("active");
    if (companyDropdown) companyDropdown.style.display = "none";
  });

  // Prevent closing when clicking inside dropdown
  if (notifDropdown) {
    notifDropdown.addEventListener("click", (e) => e.stopPropagation());
  }

  if (companyDropdown) {
    companyDropdown.addEventListener("click", (e) => e.stopPropagation());
  }

});
const links = document.querySelectorAll(".company-pages-container a");

const currentPage = window.location.pathname.split("/").pop();

links.forEach(link => {

  const linkPage = link.getAttribute("href").split("/").pop();


  if (linkPage === currentPage) {

    link.classList.add("active");

  }

});





// Admin dashbored

document.addEventListener("DOMContentLoaded", () => {

  // Counters
  const counters = document.querySelectorAll("[data-count]");
  counters.forEach(el => {
    const target = Number(el.getAttribute("data-count")) || 0;
    let current = 0;
    const step = Math.max(1, Math.ceil(target / 45));

    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      el.textContent = current;
    }, 20);
  });

  // Buttons
  const refreshBtn = document.getElementById("refreshBtn");
  const exportBtn = document.getElementById("exportBtn");
  const clearLogBtn = document.getElementById("clearLogBtn");
  const logList = document.getElementById("logList");

  if (refreshBtn) refreshBtn.addEventListener("click", () => location.reload());

  if (exportBtn) exportBtn.addEventListener("click", () => {
    alert("تصدير تقرير (تجريبي) ✅ لاحقًا PDF/Excel مع Laravel");
  });

  if (clearLogBtn && logList) {
    clearLogBtn.addEventListener("click", () => {
      logList.innerHTML = `
        <li class="log-item">
          <span class="tag tag-blue">معلومة</span>
          <div><b>لا يوجد نشاطات حالياً</b><span class="subtext">تم مسح السجل</span></div>
        </li>
      `;
    });
  }

  // Simple bar chart (بدون مكتبات)
  function drawBars(canvasId, values) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    // Dynamic width
    const parentWidth = canvas.parentElement.clientWidth;
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

    values.forEach(v => {
      const barH = Math.round((v / max) * usableH);
      ctx.fillRect(x, h - barH - 10, barW, barH);
      x += barW + gap;
    });
  }

  // status: قيد التدريب / مكتمل / لم يبدأ / متوقف
  drawBars("internStatusChart", [64, 28, 18, 9]);

  // Redraw on resize
  window.addEventListener("resize", () => {
    drawBars("internStatusChart", [64, 28, 18, 9]);
  });

});













  document.addEventListener("DOMContentLoaded", () => {

  const table = document.getElementById("studentsTable");
  const rows = table ? table.querySelectorAll("tbody tr") : [];

  const searchInput = document.getElementById("searchInput");
  const departmentFilter = document.getElementById("departmentFilter");
  const statusFilter = document.getElementById("statusFilter");

  const studentsCount = document.getElementById("studentsCount");

  // Modal
  const addStudentBtn = document.getElementById("addStudentBtn");
  const modal = document.getElementById("studentModal");
  const closeModal = document.getElementById("closeModal");
  const cancelBtn = document.getElementById("cancelBtn");
  const saveStudentBtn = document.getElementById("saveStudentBtn");

  // Inputs
  const studentName = document.getElementById("studentName");
  const studentId = document.getElementById("studentId");
  const studentDept = document.getElementById("studentDept");
  const studentEmail = document.getElementById("studentEmail");
  const studentStatus = document.getElementById("studentStatus");
  const studentInternship = document.getElementById("studentInternship");

  // Export button (demo)
  const exportBtn = document.getElementById("exportBtn");

  function updateCount() {
    let visible = 0;
    rows.forEach(r => {
      if (r.style.display !== "none") visible++;
    });
    if (studentsCount) studentsCount.textContent = `عدد الطلاب: ${visible}`;
  }

  function filterRows() {
    const q = (searchInput?.value || "").trim().toLowerCase();
    const dept = departmentFilter?.value || "all";
    const status = statusFilter?.value || "all";

    rows.forEach(row => {
      const name = (row.dataset.name || "").toLowerCase();
      const id = (row.dataset.id || "").toLowerCase();
      const rowDept = row.dataset.dept || "";
      const rowStatus = row.dataset.status || "";

      const matchSearch = !q || name.includes(q) || id.includes(q);
      const matchDept = dept === "all" || rowDept === dept;
      const matchStatus = status === "all" || rowStatus === status;

      row.style.display = (matchSearch && matchDept && matchStatus) ? "" : "none";
    });

    updateCount();
  }

  // Listeners
  if (searchInput) searchInput.addEventListener("input", filterRows);
  if (departmentFilter) departmentFilter.addEventListener("change", filterRows);
  if (statusFilter) statusFilter.addEventListener("change", filterRows);

  // Delete buttons
  document.querySelectorAll(".delete").forEach(btn => {
    btn.addEventListener("click", () => {
      const row = btn.closest("tr");
      if (!row) return;

      const ok = confirm("هل تريد حذف هذا الطالب؟");
      if (ok) row.remove();

      updateCount();
    });
  });

  // Export demo
  if (exportBtn) {
    exportBtn.addEventListener("click", () => {
      alert("ميزة التصدير سيتم ربطها لاحقًا في Laravel ✅");
    });
  }

  // Modal functions
  function openModal() {
    if (!modal) return;
    modal.classList.add("active");
  }

  function closeModalFn() {
    if (!modal) return;
    modal.classList.remove("active");
  }

  if (addStudentBtn) addStudentBtn.addEventListener("click", openModal);
  if (closeModal) closeModal.addEventListener("click", closeModalFn);
  if (cancelBtn) cancelBtn.addEventListener("click", closeModalFn);

  if (modal) {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) closeModalFn();
    });
  }

  // Save (demo)
  if (saveStudentBtn) {
    saveStudentBtn.addEventListener("click", () => {

      if (!studentName.value.trim() || !studentId.value.trim()) {
        alert("رجاءً أدخل اسم الطالب والرقم الجامعي");
        return;
      }

      alert("تم الحفظ بشكل تجريبي ✅ (سيتم ربطه بقاعدة البيانات في Laravel)");

      // reset
      studentName.value = "";
      studentId.value = "";
      studentEmail.value = "";

      closeModalFn();
    });
  }

  // Init
  filterRows();
});







document.addEventListener("DOMContentLoaded", () => {

  const table = document.getElementById("companiesTable");
  const rows = table ? table.querySelectorAll("tbody tr") : [];

  const searchInput = document.getElementById("companySearchInput");
  const fieldFilter = document.getElementById("fieldFilter");
  const statusFilter = document.getElementById("companyStatusFilter");

  const companiesCount = document.getElementById("companiesCount");

  // Modal
  const addCompanyBtn = document.getElementById("addCompanyBtn");
  const modal = document.getElementById("companyModal");
  const closeModal = document.getElementById("closeCompanyModal");
  const cancelBtn = document.getElementById("cancelCompanyBtn");
  const saveBtn = document.getElementById("saveCompanyBtn");

  // Inputs
  const companyName = document.getElementById("companyName");
  const companyField = document.getElementById("companyField");
  const companyEmail = document.getElementById("companyEmail");
  const companyPhone = document.getElementById("companyPhone");
  const companyAddress = document.getElementById("companyAddress");
  const companyStatus = document.getElementById("companyStatus");

  // Export demo
  const exportBtn = document.getElementById("exportCompaniesBtn");

  function updateCount() {
    let visible = 0;
    rows.forEach(r => {
      if (r.style.display !== "none") visible++;
    });
    if (companiesCount) companiesCount.textContent = `عدد الشركات: ${visible}`;
  }

  function filterRows() {
    const q = (searchInput?.value || "").trim().toLowerCase();
    const field = fieldFilter?.value || "all";
    const status = statusFilter?.value || "all";

    rows.forEach(row => {
      const name = (row.dataset.name || "").toLowerCase();
      const email = (row.dataset.email || "").toLowerCase();
      const rowField = row.dataset.field || "";
      const rowStatus = row.dataset.status || "";

      const matchSearch = !q || name.includes(q) || email.includes(q);
      const matchField = field === "all" || rowField === field;
      const matchStatus = status === "all" || rowStatus === status;

      row.style.display = (matchSearch && matchField && matchStatus) ? "" : "none";
    });

    updateCount();
  }

  // Listeners
  if (searchInput) searchInput.addEventListener("input", filterRows);
  if (fieldFilter) fieldFilter.addEventListener("change", filterRows);
  if (statusFilter) statusFilter.addEventListener("change", filterRows);

  // Delete
  document.querySelectorAll(".delete").forEach(btn => {
    btn.addEventListener("click", () => {
      const row = btn.closest("tr");
      if (!row) return;

      const ok = confirm("هل تريد حذف هذه الشركة؟");
      if (ok) row.remove();

      updateCount();
    });
  });

  // Export demo
  if (exportBtn) {
    exportBtn.addEventListener("click", () => {
      alert("ميزة التصدير سيتم ربطها لاحقًا في Laravel ✅");
    });
  }

  // Modal
  function openModal() {
    if (!modal) return;
    modal.classList.add("active");
  }

  function closeModalFn() {
    if (!modal) return;
    modal.classList.remove("active");
  }

  if (addCompanyBtn) addCompanyBtn.addEventListener("click", openModal);
  if (closeModal) closeModal.addEventListener("click", closeModalFn);
  if (cancelBtn) cancelBtn.addEventListener("click", closeModalFn);

  if (modal) {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) closeModalFn();
    });
  }

  // Save demo
  if (saveBtn) {
    saveBtn.addEventListener("click", () => {

      if (!companyName.value.trim() || !companyEmail.value.trim()) {
        alert("رجاءً أدخل اسم الشركة والبريد");
        return;
      }

      alert("تم الحفظ بشكل تجريبي ✅ (سيتم ربطه بقاعدة البيانات لاحقًا)");

      // reset
      companyName.value = "";
      companyEmail.value = "";
      companyPhone.value = "";
      companyAddress.value = "";

      closeModalFn();
    });
  }

  // Init
  filterRows();
});
document.addEventListener("DOMContentLoaded", () => {
  const table = document.getElementById("studentsTable");
  const rows = Array.from(table.querySelectorAll("tbody tr"));

  const searchInput = document.getElementById("searchInput");
  const departmentFilter = document.getElementById("departmentFilter");
  const statusFilter = document.getElementById("statusFilter");
  const resetBtn = document.getElementById("resetBtn");

  const totalStudents = document.getElementById("totalStudents");
  const activeStudents = document.getElementById("activeStudents");
  const pendingStudents = document.getElementById("pendingStudents");
  const completedStudents = document.getElementById("completedStudents");

  const shownCount = document.getElementById("shownCount");
  const allCount = document.getElementById("allCount");
  let editingRow = null;
  // Modal
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

  function normalize(s) {
    return (s || "").toString().trim().toLowerCase();
  }

  function rowMatches(row) {
    const q = normalize(searchInput.value);
    const dept = departmentFilter.value;
    const status = statusFilter.value;

    const name = normalize(row.dataset.name);
    const id = normalize(row.dataset.id);
    const email = normalize(row.dataset.email);
    const rowDept = row.dataset.dept;
    const rowStatus = row.dataset.status;

    const matchesSearch =
      !q || name.includes(q) || id.includes(q) || email.includes(q);

    const matchesDept = dept === "all" || rowDept === dept;
    const matchesStatus = status === "all" || rowStatus === status;

    return matchesSearch && matchesDept && matchesStatus;
  }

  function updateStats() {
    const total = rows.length;
    allCount.textContent = total;

    let active = 0, pending = 0, completed = 0;

    rows.forEach(r => {
      if (r.dataset.status === "قيد التدريب") active++;
      if (r.dataset.status === "بانتظار الموافقة") pending++;
      if (r.dataset.status === "مكتمل") completed++;
    });

    totalStudents.textContent = total;
    activeStudents.textContent = active;
    pendingStudents.textContent = pending;
    completedStudents.textContent = completed;
  }

  function applyFilters() {
    let shown = 0;
    rows.forEach((row) => {
      const ok = rowMatches(row);
      row.style.display = ok ? "" : "none";
      if (ok) shown++;
    });
    shownCount.textContent = shown;
  }

  function openModalFromRow(row) {
    mName.textContent = row.dataset.name || "-";
    mId.textContent = row.dataset.id || "-";
    mDept.textContent = row.dataset.dept || "-";
    mEmail.textContent = row.dataset.email || "-";
    mStatus.textContent = row.dataset.status || "-";
    mCompany.textContent = row.dataset.company || "-";

    modal.classList.add("open");
    modal.setAttribute("aria-hidden", "false");
  }

  function closeModalFn() {
    modal.classList.remove("open");
    modal.setAttribute("aria-hidden", "true");
  }

  // Events
  searchInput.addEventListener("input", applyFilters);
  departmentFilter.addEventListener("change", applyFilters);
  statusFilter.addEventListener("change", applyFilters);

  resetBtn.addEventListener("click", () => {
    searchInput.value = "";
    departmentFilter.value = "all";
    statusFilter.value = "all";
    applyFilters();
  });

  // Row actions
  table.addEventListener("click", (e) => {
    const btn = e.target.closest("button");
    if (!btn) return;

    const row = e.target.closest("tr");
    if (!row) return;

    if (btn.classList.contains("viewBtn")) {
      openModalFromRow(row);
    }

    if (btn.classList.contains("editBtn")) {

  editingRow = row; // نحفظ الصف الحالي

  // نعبّي الفورم بالبيانات
  document.getElementById("newName").value = row.dataset.name;
  document.getElementById("newId").value = row.dataset.id;
  document.getElementById("newDept").value = row.dataset.dept;
  document.getElementById("newEmail").value = row.dataset.email;
  document.getElementById("newStatus").value = row.dataset.status;
  document.getElementById("newCompany").value = row.dataset.company;

  // نفتح نفس مودل الإضافة
  addModal.classList.add("open");
}

    if (btn.classList.contains("blockBtn")) {
      const current = row.dataset.status;

      if (current === "موقوف") {
        row.dataset.status = "قيد التدريب";
        row.querySelector(".chip").className = "chip chip-success";
        row.querySelector(".chip").textContent = "قيد التدريب";
      } else {
        row.dataset.status = "موقوف";
        row.querySelector(".chip").className = "chip chip-danger";
        row.querySelector(".chip").textContent = "موقوف";
      }

      updateStats();
      applyFilters();
    }
  });

  // Modal close
  [closeModal, cancelBtn, xClose].forEach(el => el.addEventListener("click", closeModalFn));
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeModalFn();
  });

  // Init
  updateStats();
  applyFilters();
});

// ===== Add Student Modal =====
const addBtn = document.getElementById("addStudentBtn");
const addModal = document.getElementById("addStudentModal");
const closeAddModal = document.getElementById("closeAddModal");
const cancelAdd = document.getElementById("cancelAdd");
const addBackdrop = document.getElementById("addBackdrop");

const saveNewStudent = document.getElementById("saveNewStudent");

addBtn.addEventListener("click", () => {
  addModal.classList.add("open");
});

function closeAdd() {
  addModal.classList.remove("open");
}

[closeAddModal, cancelAdd, addBackdrop].forEach(el => {
  el.addEventListener("click", closeAdd);
});

saveNewStudent.addEventListener("click", () => {

  const name = document.getElementById("newName").value.trim();
  const id = document.getElementById("newId").value.trim();
  const dept = document.getElementById("newDept").value;
  const email = document.getElementById("newEmail").value.trim();
  const status = document.getElementById("newStatus").value;
  const company = document.getElementById("newCompany").value.trim() || "-";

  if(!name || !id){
    alert("الرجاء إدخال الاسم والرقم الجامعي");
    return;
  }

  let chipClass = "chip-success";
  if(status === "بانتظار الموافقة") chipClass = "chip-warning";
  if(status === "مكتمل") chipClass = "chip-info";
  if(status === "موقوف") chipClass = "chip-danger";

  if (editingRow) {
    // ===== تعديل صف موجود =====
    editingRow.dataset.name = name;
    editingRow.dataset.id = id;
    editingRow.dataset.dept = dept;
    editingRow.dataset.email = email;
    editingRow.dataset.status = status;
    editingRow.dataset.company = company;

    editingRow.children[1].textContent = name;
    editingRow.children[2].textContent = id;
    editingRow.children[3].textContent = dept;
    editingRow.children[4].textContent = email;
    editingRow.children[5].innerHTML =
      `<span class="chip ${chipClass}">${status}</span>`;
    editingRow.children[6].textContent = company;

    editingRow = null;

  } else {
    // ===== إضافة صف جديد =====
    const tbody = document.querySelector("#studentsTable tbody");
    const rowCount = tbody.querySelectorAll("tr").length + 1;

    const newRow = document.createElement("tr");

    newRow.dataset.name = name;
    newRow.dataset.id = id;
    newRow.dataset.dept = dept;
    newRow.dataset.email = email;
    newRow.dataset.status = status;
    newRow.dataset.company = company;

    newRow.innerHTML = `
      <td>${rowCount}</td>
      <td class="fw">${name}</td>
      <td>${id}</td>
      <td>${dept}</td>
      <td>${email}</td>
      <td><span class="chip ${chipClass}">${status}</span></td>
      <td>${company}</td>
      <td class="actions">
        <button class="icon-btn viewBtn">👁</button>
        <button class="icon-btn editBtn">✏️</button>
        <button class="icon-btn blockBtn">⛔</button>
      </td>
    `;

    tbody.appendChild(newRow);
  }

  updateStats();
  applyFilters();
  closeAdd();

  document.getElementById("newName").value = "";
  document.getElementById("newId").value = "";
  document.getElementById("newEmail").value = "";
  document.getElementById("newCompany").value = "";
});








// compaines

