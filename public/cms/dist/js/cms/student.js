document.addEventListener("DOMContentLoaded", () => {

  const notifBtn = document.getElementById("notifBtn");
  const notifDropdown = document.getElementById("notifDropdown");

  const studentMenuBtn = document.getElementById("studentMenuBtn");
  const studentDropdown = document.getElementById("studentDropdown");

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



  if (titles[currentPage]) {
    pageTitle.textContent = titles[currentPage];
  }

function markAllRead(){

const badges=document.querySelectorAll(".notification-badge");

badges.forEach(badge=>{
badge.classList.remove("badge-new");
badge.classList.add("badge-read");
badge.textContent="تمت القراءة";
});

}

function clearNotifications(){

const list=document.getElementById("notificationsList");

list.innerHTML='<div class="empty">لا يوجد إشعارات</div>';

}

  if (titles[currentPage]) {
    pageTitle.textContent = titles[currentPage];
  }


document.addEventListener("DOMContentLoaded", () => {

  const reportForm = document.getElementById("reportForm");
  const reportsBody = document.getElementById("reportsBody");

  const totalReports = document.getElementById("totalReports");
  const submittedReports = document.getElementById("submittedReports");
  const pendingReports = document.getElementById("pendingReports");
  const rejectedReports = document.getElementById("rejectedReports");

  function updateSummary() {
    const rows = document.querySelectorAll(".report-row");
    totalReports.textContent = rows.length;

    let submitted = 0, pending = 0, rejected = 0;

    rows.forEach(row => {
      const statusEl = row.querySelector(".status");
      if (!statusEl) return;

      if (statusEl.classList.contains("submitted")) submitted++;
      if (statusEl.classList.contains("pending")) pending++;
      if (statusEl.classList.contains("rejected")) rejected++;
    });

    submittedReports.textContent = submitted;
    pendingReports.textContent = pending;
    rejectedReports.textContent = rejected;
  }

  function todayDate() {
    const d = new Date();
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  }

  // Delete Report
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("btn-delete")) {
      const row = e.target.closest(".report-row");
      if (row) row.remove();
      updateSummary();
    }
  });

  // Add Report
  if (reportForm) {
    reportForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const week = document.getElementById("weekSelect").value;
      const title = document.getElementById("reportTitle").value;
      const fileInput = document.getElementById("reportFile");
      const file = fileInput.files[0];

      if (!week || !title || !file) {
        alert("⚠️ الرجاء تعبئة جميع الحقول");
        return;
      }

      // ✅ إنشاء رابط للملف المرفوع
      const fileURL = URL.createObjectURL(file);

      // Default status
      const statusText = "قيد المراجعة";

      const newRow = document.createElement("div");
      newRow.className = "report-row";

      newRow.innerHTML = `
        <span>${week}</span>
        <span>${title}</span>
        <span>${todayDate()}</span>
        <span class="status pending">${statusText}</span>

        <div class="actions">
          
          <a class="btn-download" href="${fileURL}" download="${title}.pdf">تحميل</a>
          <button class="btn-delete">حذف</button>
        </div>
      `;

      reportsBody.prepend(newRow);

      reportForm.reset();
      updateSummary();
    });
  }

  updateSummary();
});













const DEPT_LABEL = { cs:'علوم حاسوب', se:'هندسة برمجيات', cy:'أمن معلومات' };

  function qs(k){
    return new URLSearchParams(location.search).get(k);
  }
  function statusBadge(status){
    if(status==='active') return {cls:'accepted', text:'نشط'};
    if(status==='pending') return {cls:'pending', text:'قيد المراجعة'};
    return {cls:'rejected', text:'محظور'};
  }

  // ========= Demo Data (بدّليها لاحقاً من API) =========
  // افتحي الصفحة هكذا: student.html?sid=2026002
  let student = {
    sid: qs('sid') || '2026002',
    name:'محمد علي',
    email:'mohammad@student.com',
    phone:'0591234567',
    dept:'se',
    level:'4',
    status:'active',
    date:'2026-01-22',
    hoursDone: 84,
    hoursRequired: 120,
    internship: {
      active: true,
      company:'GazaSoft',
      role:'Backend Intern',
      supervisor:'د. أحمد سالم',
      period:'فصل ثاني 2026',
      start:'2026-02-01',
      end:'2026-04-30'
    },
    reports: [
      {week:'1', title:'تقرير الأسبوع الأول', status:'review', date:'2026-02-07'},
      {week:'2', title:'تقرير الأسبوع الثاني', status:'approved', date:'2026-02-14'},
      {week:'3', title:'تقرير الأسبوع الثالث', status:'rejected', date:'2026-02-21'},
    ],
    hoursLog: [
      {date:'2026-02-03', hours:6, note:'مهام Backend'},
      {date:'2026-02-04', hours:7, note:'API + Validation'},
      {date:'2026-02-05', hours:5, note:'اختبارات'},
    ]
  };

  // ========= Render Header =========
  const avatarXL = document.getElementById('avatarXL');
  const stName = document.getElementById('stName');
  const stSid = document.getElementById('stSid');
  const stDept = document.getElementById('stDept');
  const stEmail = document.getElementById('stEmail');
  const stStatusBadge = document.getElementById('stStatusBadge');
  const stHours = document.getElementById('stHours');

  function renderStudent(){
    avatarXL.textContent = (student.name || '—').trim().slice(0,1);
    stName.textContent = student.name;
    stSid.textContent = student.sid;
    stDept.textContent = DEPT_LABEL[student.dept] || student.dept;
    stEmail.textContent = student.email;

    const b = statusBadge(student.status);
    stStatusBadge.className = 'badge ' + b.cls;
    stStatusBadge.textContent = b.text;

    stHours.textContent = (student.hoursDone||0) + ' ساعة';

    // Info
    document.getElementById('infoSid').textContent = student.sid;
    document.getElementById('infoName').textContent = student.name;
    document.getElementById('infoEmail').textContent = student.email;
    document.getElementById('infoPhone').textContent = student.phone || '—';
    document.getElementById('infoDept').textContent = DEPT_LABEL[student.dept] || student.dept;
    document.getElementById('infoLevel').textContent = student.level || '—';
    document.getElementById('infoDate').textContent = student.date || '—';
    document.getElementById('infoStatus').textContent = b.text;

    // Internship
    const internBox = document.getElementById('internBox');
    const internCard = document.getElementById('internCard');
    if(student.internship && student.internship.active){
      internBox.style.display = 'none';
      internCard.style.display = 'block';
      document.getElementById('internCompany').textContent = student.internship.company;
      document.getElementById('internRole').textContent = student.internship.role;
      document.getElementById('internSupervisor').textContent = student.internship.supervisor;
      document.getElementById('internPeriod').textContent = student.internship.period;
      document.getElementById('internStart').textContent = student.internship.start;
      document.getElementById('internEnd').textContent = student.internship.end;
    } else {
      internBox.style.display = 'block';
      internCard.style.display = 'none';
    }

    // Reports
    const reportsBody = document.getElementById('reportsBody');
    reportsBody.innerHTML = (student.reports||[]).map(r=>{
      let badge = '<span class="badge pending">قيد المراجعة</span>';
      if(r.status==='approved') badge = '<span class="badge accepted">مقبول</span>';
      if(r.status==='rejected') badge = '<span class="badge rejected">مرفوض</span>';
      return `
        <tr>
          <td>الأسبوع ${r.week}</td>
          <td>${r.title}</td>
          <td>${badge}</td>
          <td>${r.date}</td>
          <td><button class="btn btn-light btn-sm">عرض</button></td>
        </tr>
      `;
    }).join('') || `<tr><td colspan="5" class="muted">لا يوجد تقارير</td></tr>`;

    // Hours
    const required = Number(student.hoursRequired||0);
    const done = Number(student.hoursDone||0);
    document.getElementById('hrsRequired').textContent = required;
    document.getElementById('hrsDone').textContent = done;
    document.getElementById('hrsLeft').textContent = Math.max(0, required - done);

    const hoursBody = document.getElementById('hoursBody');
    hoursBody.innerHTML = (student.hoursLog||[]).map(h=>`
      <tr>
        <td>${h.date}</td>
        <td><span class="pill hours-pill">${h.hours} ساعات</span></td>
        <td>${h.note || '—'}</td>
      </tr>
    `).join('') || `<tr><td colspan="3" class="muted">لا يوجد سجل ساعات</td></tr>`;
  }

  // ========= Tabs =========
  document.querySelectorAll('.tab-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');

      const id = btn.getAttribute('data-tab');
      document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('show'));
      document.getElementById(id).classList.add('show');
    });
  });

  // ========= Actions =========
  document.getElementById('btnActivate').addEventListener('click', ()=>{ student.status='active'; renderStudent(); alert('تم تفعيل الطالب'); });
  document.getElementById('btnPending').addEventListener('click', ()=>{ student.status='pending'; renderStudent(); alert('تم تحويله لقيد المراجعة'); });
  document.getElementById('btnBlock').addEventListener('click', ()=>{ student.status='blocked'; renderStudent(); alert('تم حظر الطالب'); });

  document.getElementById('btnResetPass').addEventListener('click', ()=>{
    alert('تم إرسال رابط إعادة تعيين كلمة المرور (تجريبي).');
  });

  document.getElementById('btnDelete').addEventListener('click', ()=>{
    const ok = confirm('هل أنت متأكد من حذف هذا الطالب؟');
    if(ok) location.href='students.html';
  });

  document.getElementById('btnPrint').addEventListener('click', ()=> window.print());

  // ========= Edit Modal =========
  const editModal = document.getElementById('editModal');
  const openEdit = ()=> { editModal.classList.add('show'); editModal.setAttribute('aria-hidden','false'); };
  const closeEdit = ()=> { editModal.classList.remove('show'); editModal.setAttribute('aria-hidden','true'); };

  document.getElementById('btnEdit').addEventListener('click', ()=>{
    document.getElementById('eSid').value = student.sid;
    document.getElementById('eName').value = student.name;
    document.getElementById('eEmail').value = student.email;
    document.getElementById('ePhone').value = student.phone || '';
    document.getElementById('eDept').value = student.dept;
    document.getElementById('eLevel').value = student.level || '4';
    openEdit();
  });

  document.getElementById('closeEdit').addEventListener('click', closeEdit);
  document.getElementById('cancelEdit').addEventListener('click', closeEdit);
  editModal.addEventListener('click', (e)=>{ if(e.target===editModal) closeEdit(); });

  document.getElementById('saveEdit').addEventListener('click', ()=>{
    // basic validation
    const name = document.getElementById('eName').value.trim();
    const email = document.getElementById('eEmail').value.trim();
    if(!name || !email){ alert('الاسم والبريد مطلوبين'); return; }

    student.name = name;
    student.email = email;
    student.phone = document.getElementById('ePhone').value.trim();
    student.dept = document.getElementById('eDept').value;
    student.level = document.getElementById('eLevel').value;

    closeEdit();
    renderStudent();
    alert('تم حفظ التعديل (تجريبي).');
  });

  // init
  renderStudent();