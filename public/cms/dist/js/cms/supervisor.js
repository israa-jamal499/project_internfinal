
document.addEventListener("DOMContentLoaded", () => {

  const notifBtn = document.getElementById("notifBtn");
  const notifDropdown = document.getElementById("notifDropdown");

  const studentMenuBtn = document.getElementById("supervisorMenuBtn");
  const studentDropdown = document.getElementById("supervisorDropdown");

  // Toggle Notifications
  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener("click", (e) => {
      e.stopPropagation();

      // اقفلي قائمة الطالب لو مفتوحة
      if (studentDropdown) studentDropdown.style.display = "none";

      notifDropdown.classList.toggle("active");
    });
  }

  // Toggle Student Menu
  if (studentMenuBtn && studentDropdown) {
    studentMenuBtn.addEventListener("click", (e) => {
      e.stopPropagation();

      // اقفلي الإشعارات لو مفتوحة
      if (notifDropdown) notifDropdown.classList.remove("active");

      // فتح/إغلاق
      studentDropdown.style.display =
        studentDropdown.style.display === "block" ? "none" : "block";
    });
  }

  // Close when clicking outside
  document.addEventListener("click", () => {
    if (notifDropdown) notifDropdown.classList.remove("active");
    if (studentDropdown) studentDropdown.style.display = "none";
  });

  // Prevent closing when clicking inside dropdown
  if (notifDropdown) {
    notifDropdown.addEventListener("click", (e) => e.stopPropagation());
  }

  if (studentDropdown) {
    studentDropdown.addEventListener("click", (e) => e.stopPropagation());
  }

});

const links = document.querySelectorAll(".student-pages-container a");

const currentPage = window.location.pathname.split("/").pop();

links.forEach(link => {

  const linkPage = link.getAttribute("href");

  if (linkPage === currentPage) {

    link.classList.add("active");

  }

});

document.addEventListener("DOMContentLoaded", function () {

  const currentPage = window.location.pathname.split("/").pop();

  const pageTitle = document.getElementById("pageTitle");

  const titles = {

    "dashboard.html": "لوحة التحكم",
    "profile.html": "الملف الشخصي",
    "applications.html": "طلباتي",
    "internship.html": "ملف التدريب",
    "reports.html": "التقارير",
    "hours.html": "ساعات التدريب",
    "certificate.html": "الشهادة",
    "notifications.html": "الإشعارات"

  };

  if (titles[currentPage]) {
    pageTitle.textContent = titles[currentPage];
  }

});











document.addEventListener("DOMContentLoaded", () => {

  // بيانات تجريبية
  const students = [
    { name: "إسراء كسكين", id: "202225583", company: "شركة أحمد", status: "نشط" },
    { name: "سارة أحمد", id: "202200111", company: "شركة المستقبل", status: "نشط" },
    { name: "هبة علي", id: "202201777", company: "شركة التقنية", status: "متوقف" },
    { name: "دعاء عمر", id: "202199333", company: "شركة القدس", status: "نشط" },
  ];

  const reports = [
    { student: "إسراء كسكين", week: "الأسبوع 1", status: "بانتظار المراجعة" },
    { student: "سارة أحمد", week: "الأسبوع 2", status: "تمت المراجعة" },
    { student: "هبة علي", week: "الأسبوع 1", status: "بانتظار المراجعة" },
  ];

  // Stats
  document.getElementById("statStudents").textContent = students.length;
  document.getElementById("statReports").textContent = reports.length;
  document.getElementById("statPending").textContent =
    reports.filter(r => r.status.includes("بانتظار")).length;

  document.getElementById("statEvaluations").textContent = 2;

  // Preview students
  const studentsPreview = document.getElementById("studentsPreview");
  studentsPreview.innerHTML = "";

  students.slice(0, 3).forEach((s, i) => {
    studentsPreview.innerHTML += `
      <tr>
        <td>${i + 1}</td>
        <td>${s.name}</td>
        <td>${s.id}</td>
        <td>${s.company}</td>
        <td>
          <span class="pill ${s.status === "نشط" ? "pill-ok" : "pill-pending"}">${s.status}</span>
        </td>
      </tr>
    `;
  });

  // Preview reports
  const reportsPreview = document.getElementById("reportsPreview");
  reportsPreview.innerHTML = "";

  reports.slice(0, 3).forEach((r, i) => {
    reportsPreview.innerHTML += `
      <tr>
        <td>${i + 1}</td>
        <td>${r.student}</td>
        <td>${r.week}</td>
        <td>
          <span class="pill ${r.status.includes("بانتظار") ? "pill-pending" : "pill-ok"}">${r.status}</span>
        </td>
        <td><button class="action-btn" onclick="location.href='weekly-reports.html'">عرض</button></td>
      </tr>
    `;
  });

});


document.addEventListener("DOMContentLoaded", () => {

  const students = [
    { name: "إسراء كسكين", id: "202225583", company: "شركة أحمد", status: "نشط", lastReport:"الأسبوع 2" },
    { name: "سارة أحمد", id: "202200111", company: "شركة المستقبل", status: "نشط", lastReport:"الأسبوع 1" },
    { name: "هبة علي", id: "202201777", company: "شركة التقنية", status: "متوقف", lastReport:"لا يوجد" },
    { name: "دعاء عمر", id: "202199333", company: "شركة القدس", status: "نشط", lastReport:"الأسبوع 3" },
    { name: "نور حسن", id: "202212222", company: "شركة رواد", status: "نشط", lastReport:"الأسبوع 1" },
    { name: "رنا محمد", id: "202198888", company: "شركة البرمجة", status: "متوقف", lastReport:"الأسبوع 1" },
  ];

  const studentsTable = document.getElementById("studentsTable");
  const searchStudent = document.getElementById("searchStudent");
  const filterStatus = document.getElementById("filterStatus");

  const modal = document.getElementById("studentModal");
  const closeModal = document.getElementById("closeModal");

  const modalStudentName = document.getElementById("modalStudentName");
  const modalStudentId = document.getElementById("modalStudentId");
  const modalStudentCompany = document.getElementById("modalStudentCompany");
  const modalStudentStatus = document.getElementById("modalStudentStatus");
  const modalStudentLastReport = document.getElementById("modalStudentLastReport");

  function renderTable(){
    const q = searchStudent.value.trim().toLowerCase();
    const st = filterStatus.value;

    const filtered = students.filter(s => {
      const matchText =
        s.name.toLowerCase().includes(q) ||
        s.id.toLowerCase().includes(q) ||
        s.company.toLowerCase().includes(q);

      const matchStatus = (st === "all") ? true : (s.status === st);
      return matchText && matchStatus;
    });

    studentsTable.innerHTML = "";

    filtered.forEach((s, i) => {
      studentsTable.innerHTML += `
        <tr>
          <td>${i + 1}</td>
          <td>${s.name}</td>
          <td>${s.id}</td>
          <td>${s.company}</td>
          <td>
            <span class="pill ${s.status === "نشط" ? "pill-ok" : "pill-pending"}">${s.status}</span>
          </td>
          <td>
            <button class="action-btn" data-id="${s.id}">عرض</button>
          </td>
        </tr>
      `;
    });

    document.querySelectorAll(".action-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const id = btn.getAttribute("data-id");
        const student = students.find(x => x.id === id);

        modalStudentName.textContent = student.name;
        modalStudentId.textContent = student.id;
        modalStudentCompany.textContent = student.company;
        modalStudentStatus.textContent = student.status;
        modalStudentLastReport.textContent = student.lastReport;

        modal.classList.add("active");
      });
    });
  }

  searchStudent.addEventListener("input", renderTable);
  filterStatus.addEventListener("change", renderTable);

  closeModal.addEventListener("click", () => modal.classList.remove("active"));
  modal.addEventListener("click", (e) => {
    if(e.target === modal) modal.classList.remove("active");
  });

  renderTable();
});


document.addEventListener("DOMContentLoaded", () => {

  let reports = [
    {
      id: 1,
      student: "إسراء كسكين",
      week: "الأسبوع 1",
      date: "2026-02-10",
      status: "بانتظار المراجعة",
      content: "قمت هذا الأسبوع بتعلم أساسيات Laravel وتنفيذ CRUD وتجربة routes وcontrollers."
    },
    {
      id: 2,
      student: "سارة أحمد",
      week: "الأسبوع 2",
      date: "2026-02-12",
      status: "تمت المراجعة",
      content: "تم تنفيذ صفحة تسجيل الدخول وتحسين واجهة المستخدم وربطها مع localStorage."
    },
    {
      id: 3,
      student: "هبة علي",
      week: "الأسبوع 1",
      date: "2026-02-13",
      status: "بانتظار المراجعة",
      content: "تعلمت التعامل مع GitHub وإنشاء repository ورفع المشروع."
    },
    {
      id: 4,
      student: "دعاء عمر",
      week: "الأسبوع 3",
      date: "2026-02-15",
      status: "مرفوض",
      content: "تم إرسال تقرير ناقص بدون تفاصيل واضحة."
    }
  ];

  const reportsTable = document.getElementById("reportsTable");
  const searchReport = document.getElementById("searchReport");
  const filterReportStatus = document.getElementById("filterReportStatus");

  const modal = document.getElementById("reportModal");
  const closeBtn = document.getElementById("closeReportModal");

  const reportStudent = document.getElementById("reportStudent");
  const reportWeek = document.getElementById("reportWeek");
  const reportContent = document.getElementById("reportContent");
  const reportTitle = document.getElementById("reportTitle");

  const btnReject = document.getElementById("btnReject");
  const btnApprove = document.getElementById("btnApprove");

  let currentReportId = null;

  function pillClass(status){
    if(status === "تمت المراجعة") return "pill-ok";
    if(status === "مرفوض") return "pill-pending";
    return "pill-pending";
  }

  function render(){
    const q = searchReport.value.trim().toLowerCase();
    const st = filterReportStatus.value;

    const filtered = reports.filter(r => {
      const matchText = r.student.toLowerCase().includes(q);
      const matchStatus = (st === "all") ? true : (r.status === st);
      return matchText && matchStatus;
    });

    reportsTable.innerHTML = "";

    filtered.forEach((r, i) => {
      reportsTable.innerHTML += `
        <tr>
          <td>${i + 1}</td>
          <td>${r.student}</td>
          <td>${r.week}</td>
          <td>${r.date}</td>
          <td><span class="pill ${pillClass(r.status)}">${r.status}</span></td>
          <td><button class="action-btn" data-id="${r.id}">عرض</button></td>
        </tr>
      `;
    });

    document.querySelectorAll(".action-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const id = Number(btn.getAttribute("data-id"));
        const rep = reports.find(x => x.id === id);

        currentReportId = id;

        reportTitle.textContent = `📄 تقرير ${rep.week}`;
        reportStudent.textContent = rep.student;
        reportWeek.textContent = rep.week;
        reportContent.textContent = rep.content;

        modal.classList.add("active");
      });
    });
  }

  btnApprove.addEventListener("click", () => {
    const rep = reports.find(x => x.id === currentReportId);
    rep.status = "تمت المراجعة";
    modal.classList.remove("active");
    render();
  });

  btnReject.addEventListener("click", () => {
    const rep = reports.find(x => x.id === currentReportId);
    rep.status = "مرفوض";
    modal.classList.remove("active");
    render();
  });

  closeBtn.addEventListener("click", () => modal.classList.remove("active"));
  modal.addEventListener("click", (e) => {
    if(e.target === modal) modal.classList.remove("active");
  });

  searchReport.addEventListener("input", render);
  filterReportStatus.addEventListener("change", render);

  render();
});


document.addEventListener("DOMContentLoaded", () => {

  const students = [
    "إسراء كسكين",
    "سارة أحمد",
    "هبة علي",
    "دعاء عمر"
  ];

  const evalStudent = document.getElementById("evalStudent");
  const evalRate = document.getElementById("evalRate");
  const evalCommit = document.getElementById("evalCommit");
  const evalSkills = document.getElementById("evalSkills");
  const evalComm = document.getElementById("evalComm");
  const evalNotes = document.getElementById("evalNotes");
  const saveEval = document.getElementById("saveEval");
  const evalCards = document.getElementById("evalCards");

  let evaluations = [];

  students.forEach(s => {
    evalStudent.innerHTML += `<option value="${s}">${s}</option>`;
  });

  function render(){
    evalCards.innerHTML = "";
    if(evaluations.length === 0){
      evalCards.innerHTML = `<p style="color:#666;font-size:13px;margin:0;">لا يوجد تقييمات محفوظة بعد.</p>`;
      return;
    }

    evaluations.forEach(ev => {
      evalCards.innerHTML += `
        <div class="eval-card">
          <h4>👩‍🎓 ${ev.student} - ⭐ ${ev.rate}</h4>
          <p>
            <b>الالتزام:</b> ${ev.commit}/10 |
            <b>المهارات:</b> ${ev.skills}/10 |
            <b>التواصل:</b> ${ev.comm}/10
          </p>
          <p><b>ملاحظات:</b> ${ev.notes || "لا يوجد"}</p>
        </div>
      `;
    });
  }

  saveEval.addEventListener("click", () => {
    const ev = {
      student: evalStudent.value,
      rate: evalRate.value,
      commit: evalCommit.value,
      skills: evalSkills.value,
      comm: evalComm.value,
      notes: evalNotes.value.trim()
    };

    evaluations.unshift(ev);
    evalNotes.value = "";
    render();
  });

  render();
});











/* إدارة طلاب الأدمن (Front-end فقط) باستخدام localStorage
   مصادر (MDN):
   - Web Storage API: https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API
   - <dialog>: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/dialog
*/

(() => {
  const LS_KEY = "admin_students_v1";

  // Elements
  const tbody = document.getElementById("tbody");

  const searchInput = document.getElementById("searchInput");
  const statusFilter = document.getElementById("statusFilter");
  const companyFilter = document.getElementById("companyFilter");

  const stTotal = document.getElementById("stTotal");
  const stActive = document.getElementById("stActive");
  const stPaused = document.getElementById("stPaused");
  const stPending = document.getElementById("stPending");

  const shownCount = document.getElementById("shownCount");
  const allCount = document.getElementById("allCount");

  const addBtn = document.getElementById("addBtn");
  const seedBtn = document.getElementById("seedBtn");
  const clearBtn = document.getElementById("clearBtn");

  const dialog = document.getElementById("studentDialog");
  const dlgClose = document.getElementById("dlgClose");
  const cancelBtn = document.getElementById("cancelBtn");
  const saveBtn = document.getElementById("saveBtn");
  const dlgTitle = document.getElementById("dlgTitle");
  const dlgHint = document.getElementById("dlgHint");

  const studentId = document.getElementById("studentId");
  const fullName = document.getElementById("fullName");
  const uniId = document.getElementById("uniId");
  const company = document.getElementById("company");
  const status = document.getElementById("status");
  const notes = document.getElementById("notes");

  // Data
  let students = load();

  // Init
  refreshCompanyFilter();
  render();

  // Events
  searchInput.addEventListener("input", render);
  statusFilter.addEventListener("change", render);
  companyFilter.addEventListener("change", render);

  addBtn.addEventListener("click", () => openDialogForCreate());
  seedBtn.addEventListener("click", seedDemo);
  clearBtn.addEventListener("click", () => {
    if (!confirm("متأكدة بدك تمسحي كل البيانات المحفوظة؟")) return;
    localStorage.removeItem(LS_KEY);
    students = [];
    refreshCompanyFilter();
    render();
  });

  dlgClose.addEventListener("click", () => dialog.close());
  cancelBtn.addEventListener("click", () => dialog.close());

  saveBtn.addEventListener("click", () => {
    // تحقق بسيط
    const nameVal = fullName.value.trim();
    const uniVal = uniId.value.trim();
    const compVal = company.value.trim();
    const stVal = status.value;

    if (!nameVal || !uniVal || !compVal || !stVal) {
      alert("من فضلك عبّي الحقول الأساسية (الاسم/الرقم/الشركة/الحالة).");
      return;
    }

    const idVal = studentId.value;

    // منع تكرار الرقم الجامعي (إلا لو نفس السجل)
    const conflict = students.find(s => s.uniId === uniVal && String(s.id) !== String(idVal || ""));
    if (conflict) {
      alert("الرقم الجامعي موجود مسبقًا لطالب آخر. غيّريه أو عدّلي الطالب الصحيح.");
      return;
    }

    if (idVal) {
      // Update
      const idx = students.findIndex(s => String(s.id) === String(idVal));
      if (idx > -1) {
        students[idx] = {
          ...students[idx],
          name: nameVal,
          uniId: uniVal,
          company: compVal,
          status: stVal,
          notes: notes.value.trim(),
          updatedAt: new Date().toISOString(),
        };
      }
    } else {
      // Create
      students.unshift({
        id: Date.now(),
        name: nameVal,
        uniId: uniVal,
        company: compVal,
        status: stVal,
        notes: notes.value.trim(),
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString(),
      });
    }

    save(students);
    refreshCompanyFilter();
    render();
    dialog.close();
  });

  // Functions
  function load() {
    try {
      const raw = localStorage.getItem(LS_KEY);
      return raw ? JSON.parse(raw) : [];
    } catch {
      return [];
    }
  }

  function save(list) {
    localStorage.setItem(LS_KEY, JSON.stringify(list));
  }

  function seedDemo() {
    const demo = [
      { id: Date.now() + 1, name: "إسراء كسكين", uniId: "202225583", company: "شركة أحمد", status: "active", notes: "" },
      { id: Date.now() + 2, name: "سارة أحمد", uniId: "202200111", company: "شركة المستقبل", status: "active", notes: "" },
      { id: Date.now() + 3, name: "هبة علي", uniId: "202201777", company: "شركة التقنية", status: "paused", notes: "موقوف مؤقتًا" },
      { id: Date.now() + 4, name: "دعاء محمد", uniId: "202233999", company: "شركة التقنية", status: "pending", notes: "بانتظار مراجعة" },
    ].map(x => ({
      ...x,
      createdAt: new Date().toISOString(),
      updatedAt: new Date().toISOString(),
    }));

    // دمج بدون تكرار uniId
    const map = new Map(students.map(s => [s.uniId, s]));
    demo.forEach(d => map.set(d.uniId, d));
    students = Array.from(map.values()).sort((a,b) => b.id - a.id);

    save(students);
    refreshCompanyFilter();
    render();
  }

  function refreshCompanyFilter() {
    const current = companyFilter.value || "all";
    const companies = Array.from(new Set(students.map(s => s.company))).filter(Boolean).sort();

    companyFilter.innerHTML = `<option value="all">كل الشركات</option>` +
      companies.map(c => `<option value="${escapeHtml(c)}">${escapeHtml(c)}</option>`).join("");

    // حافظي على الاختيار لو موجود
    if ([...companyFilter.options].some(o => o.value === current)) {
      companyFilter.value = current;
    } else {
      companyFilter.value = "all";
    }
  }

  function render() {
    const q = (searchInput.value || "").trim().toLowerCase();
    const st = statusFilter.value;
    const comp = companyFilter.value;

    const filtered = students.filter(s => {
      const hay = `${s.name} ${s.uniId} ${s.company}`.toLowerCase();
      const matchQ = !q || hay.includes(q);
      const matchSt = (st === "all") || (s.status === st);
      const matchComp = (comp === "all") || (s.company === comp);
      return matchQ && matchSt && matchComp;
    });

    // Stats
    allCount.textContent = String(students.length);
    shownCount.textContent = String(filtered.length);

    const counts = students.reduce((acc, s) => {
      acc.total++;
      acc[s.status] = (acc[s.status] || 0) + 1;
      return acc;
    }, { total: 0 });

    stTotal.textContent = String(counts.total || 0);
    stActive.textContent = String(counts.active || 0);
    stPaused.textContent = String(counts.paused || 0);
    stPending.textContent = String(counts.pending || 0);

    // Table
    tbody.innerHTML = filtered.map((s, i) => rowTemplate(s, i + 1)).join("");

    // Bind row actions
    tbody.querySelectorAll("[data-action]").forEach(btn => {
      btn.addEventListener("click", (e) => {
        const action = e.currentTarget.getAttribute("data-action");
        const id = e.currentTarget.getAttribute("data-id");
        handleAction(action, id);
      });
    });
  }

  function rowTemplate(s, index) {
    const badge = statusBadge(s.status);
    return `
      <tr>
        <td>${index}</td>
        <td>${escapeHtml(s.name)}</td>
        <td>${escapeHtml(s.uniId)}</td>
        <td>${escapeHtml(s.company)}</td>
        <td>${badge}</td>
        <td>
          <div class="actions">
            <button class="icon-btn primary" data-action="edit" data-id="${s.id}">✏️ تعديل</button>
            <button class="icon-btn" data-action="toggle" data-id="${s.id}">
              ${s.status === "active" ? "⏸️ إيقاف" : "✅ تفعيل"}
            </button>
            <button class="icon-btn danger" data-action="delete" data-id="${s.id}">🗑 حذف</button>
          </div>
        </td>
      </tr>
    `;
  }

  function handleAction(action, id) {
    const idx = students.findIndex(s => String(s.id) === String(id));
    if (idx === -1) return;

    if (action === "edit") {
      openDialogForEdit(students[idx]);
      return;
    }

    if (action === "toggle") {
      const current = students[idx].status;
      students[idx].status = (current === "active") ? "paused" : "active";
      students[idx].updatedAt = new Date().toISOString();
      save(students);
      refreshCompanyFilter();
      render();
      return;
    }

    if (action === "delete") {
      if (!confirm("متأكدة بدك تحذفي الطالب؟")) return;
      students.splice(idx, 1);
      save(students);
      refreshCompanyFilter();
      render();
      return;
    }
  }

  function openDialogForCreate() {
    dlgTitle.textContent = "إضافة طالب";
    dlgHint.textContent = "أدخلي بيانات الطالب ثم اضغطي حفظ.";
    studentId.value = "";
    fullName.value = "";
    uniId.value = "";
    company.value = "";
    status.value = "active";
    notes.value = "";
    dialog.showModal();
  }

  function openDialogForEdit(s) {
    dlgTitle.textContent = "تعديل بيانات طالب";
    dlgHint.textContent = "عدّلي البيانات ثم اضغطي حفظ.";
    studentId.value = s.id;
    fullName.value = s.name || "";
    uniId.value = s.uniId || "";
    company.value = s.company || "";
    status.value = s.status || "active";
    notes.value = s.notes || "";
    dialog.showModal();
  }

  function statusBadge(st) {
    if (st === "active") return `<span class="badge b-active">نشط</span>`;
    if (st === "paused") return `<span class="badge b-paused">موقوف</span>`;
    return `<span class="badge b-pending">قيد المراجعة</span>`;
  }

  function escapeHtml(str) {
    return String(str ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }
})();