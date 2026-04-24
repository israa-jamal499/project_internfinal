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

    window.location.href =
      `opportunities.html?search=${encodeURIComponent(value)}`;
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

/* Toggle menu safely */

if (menuBtn && sideMenu && overlay) {
  menuBtn.addEventListener("click", () => {
    sideMenu.classList.toggle("active");
    overlay.classList.toggle("active");

    document.body.style.overflow =
      sideMenu.classList.contains("active")
        ? "hidden"
        : "auto";
  });
}

/* Close button */

if (closeBtn) {
  closeBtn.addEventListener("click", closeMenu);
}

/* Click outside */

if (overlay) {
  overlay.addEventListener("click", closeMenu);
}

/* Close when clicking links */

document.querySelectorAll(".side-menu a").forEach(link => {
  link.addEventListener("click", closeMenu);
});

/* الضغط خارج القائمة */

if (overlay) {
  overlay.addEventListener("click", closeMenu);
}
const heroBtn = document.getElementById("heroSearchBtn");
const heroInput = document.getElementById("heroSearchInput");

if (heroBtn && heroInput) {

  heroBtn.addEventListener("click", () => {

    const value = heroInput.value.trim();

    if (!value) {
      alert("اكتب كلمة للبحث 😊");
      return;
    }

    window.location.href =
      `opportunities.html?search=${encodeURIComponent(value)}`;
  });

}
const boxes = document.querySelectorAll(".step-box");

window.addEventListener("scroll", () => {
  boxes.forEach(box => {
    const boxTop = box.getBoundingClientRect().top;

    if (boxTop < window.innerHeight - 100) {
      box.style.opacity = "1";
      box.style.transform = "translateY(0)";
    }
  });
});




const navbar = document.querySelector(".navbar");

window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});
const hero = document.querySelector(".hero-mostaql");

if (hero) {
  window.addEventListener("scroll", () => {
    let offset = window.scrollY;
    hero.style.backgroundPositionY = offset * 0.5 + "px";
  });
}

const reveals = document.querySelectorAll(".reveal");

function revealOnScroll() {
  reveals.forEach(el => {
    const top = el.getBoundingClientRect().top;

    if (top < window.innerHeight - 100) {
      el.classList.add("active");
    }
  });
}

window.addEventListener("scroll", revealOnScroll);
revealOnScroll();
/* =========================
   Opportunities Page JS
========================= */

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const majorFilter = document.getElementById("majorFilter");
  const typeFilter = document.getElementById("typeFilter");

  const cardsContainer = document.getElementById("cardsContainer");
  const cards = cardsContainer ? cardsContainer.querySelectorAll(".op-card") : [];
  const emptyState = document.getElementById("emptyState");

  function filterCards() {
    const searchValue = searchInput.value.trim().toLowerCase();
    const majorValue = majorFilter.value;
    const typeValue = typeFilter.value;

    let visibleCount = 0;

    cards.forEach((card) => {
      const title = card.querySelector("h3").innerText.toLowerCase();
      const company = card.querySelector(".company").innerText.toLowerCase();
      const desc = card.querySelector(".desc").innerText.toLowerCase();

      const cardMajor = card.getAttribute("data-major");
      const cardType = card.getAttribute("data-type");

      const matchSearch =
        title.includes(searchValue) ||
        company.includes(searchValue) ||
        desc.includes(searchValue);

      const matchMajor = majorValue === "all" || majorValue === cardMajor;
      const matchType = typeValue === "all" || typeValue === cardType;

      if (matchSearch && matchMajor && matchType) {
        card.style.display = "block";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    if (visibleCount === 0) {
      emptyState.style.display = "block";
    } else {
      emptyState.style.display = "none";
    }
  }

  if (searchInput && majorFilter && typeFilter) {
    searchInput.addEventListener("input", filterCards);
    majorFilter.addEventListener("change", filterCards);
    typeFilter.addEventListener("change", filterCards);
  }
});
// Opportunity Details Page JS

document.addEventListener("DOMContentLoaded", () => {
  const applyBtn = document.getElementById("applyBtn");

  applyBtn.addEventListener("click", () => {
    // حاليا لأنه ما في backend بعد:
    alert("لازم تسجلي دخول كطالب أولاً ✨");

    // لاحقاً بعد Laravel:
    // window.location.href = "login.html";
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const opportunities = {
  1: {
    title: "تدريب Web Developer (Laravel)",
    company: "شركة CodeLine",
    type: "عن بعد",
    status: "مفتوحة",
    location: "عن بعد",
    hours: "160 ساعة",
    major: "تكنولوجيا المعلومات",
    date: "2026-02-09",
    cover: "../../img/webDev.jpeg",
    desc: "فرصة تدريب ميداني لطلبة الكلية الجامعية للعلوم التطبيقية، تهدف إلى تدريب الطالب عملياً على تطوير تطبيقات الويب باستخدام Laravel و MySQL وبناء REST API.",
    requirements: [
      "معرفة أساسية بلغة PHP.",
      "معرفة بأساسيات Laravel (Routes, Controllers, Views).",
      "فهم قواعد البيانات MySQL.",
      "الالتزام بالحضور/المهام حسب خطة التدريب."
    ],
    tasks: [
      "بناء صفحات Backend وربطها مع قاعدة البيانات.",
      "إنشاء CRUD لموديولات بسيطة.",
      "كتابة API وربطها مع Front-End.",
      "تسليم تقارير أسبوعية عن الإنجاز."
    ],
    skills: ["Laravel", "MySQL", "REST API", "GitHub", "Clean Code"]
  },

  2: {
    title: "تدريب UI/UX Designer",
    company: "شركة VisionTech",
    type: "وجاهي",
    status: "مفتوحة",
    location: "غزة - الرمال",
    hours: "120 ساعة",
    major: "التصميم",
    date: "2026-02-08",
    cover: "../../img/Illiustrations.co_Day_94_ui_ux.png",
    desc: "فرصة تدريب لتطوير مهارات تصميم واجهات المستخدم باستخدام Figma، والعمل على Prototype وتحسين تجربة المستخدم.",
    requirements: [
      "معرفة بأساسيات التصميم.",
      "إتقان Figma بشكل جيد.",
      "القدرة على تصميم صفحات Web/Mobile.",
      "تسليم واجهات أسبوعياً حسب خطة التدريب."
    ],
    tasks: [
      "تصميم صفحات واجهات للمشروع.",
      "إنشاء Wireframes و Prototype.",
      "تحسين UX بناء على ملاحظات الفريق.",
      "تجهيز UI Kit بسيط."
    ],
    skills: ["Figma", "UI Design", "UX Research", "Prototyping"]
  },

  3: {
    title: "تدريب Cyber Security Intern",
    company: "مركز Secure Gaza",
    type: "وجاهي",
    status: "مفتوحة",
    location: "غزة - الجامعة",
    hours: "140 ساعة",
    major: "الأمن السيبراني",
    date: "2026-02-07",
    cover: "../../img/cyber.jpg",
    desc: "تدريب عملي على أساسيات الأمن السيبراني واختبار الاختراق وفق OWASP، والتعامل مع أدوات أمنية.",
    requirements: [
      "معرفة بأساسيات الشبكات.",
      "معرفة بأساسيات Linux.",
      "الاهتمام بمجال الأمن السيبراني.",
      "الالتزام بالتدريب والتقارير."
    ],
    tasks: [
      "التدرب على OWASP Top 10.",
      "تجربة أدوات فحص الثغرات.",
      "كتابة تقارير أمنية بسيطة.",
      "محاكاة اختبارات اختراق."
    ],
    skills: ["OWASP", "Linux", "Web Security", "Penetration Testing"]
  },

  4: {
    title: "تدريب Software Testing",
    company: "شركة QA Masters",
    type: "عن بعد",
    status: "مفتوحة",
    location: "عن بعد",
    hours: "110 ساعة",
    major: "علوم الحاسوب",
    date: "2026-02-06",
    cover: "../../img/test.jpeg",
    desc: "تدريب على كتابة Test Cases و Bug Reports وفهم أساسيات QA و Automation بشكل مبسط.",
    requirements: [
      "معرفة بأساسيات البرمجة.",
      "القدرة على كتابة تقارير واضحة.",
      "اهتمام بمجال اختبار البرمجيات."
    ],
    tasks: [
      "كتابة حالات اختبار.",
      "توثيق الأخطاء.",
      "تجربة أدوات بسيطة للاختبار.",
      "مراجعة المتطلبات."
    ],
    skills: ["Test Cases", "Bug Reports", "QA Basics", "Automation Basics"]
  },

  5: {
    title: "تدريب Network Support",
    company: "شركة NetPro",
    type: "وجاهي",
    status: "مفتوحة",
    location: "غزة - تل الهوى",
    hours: "90 ساعة",
    major: "تكنولوجيا المعلومات",
    date: "2026-02-05",
    cover: "../../img/netSupport.jpeg",
    desc: "تدريب عملي على شبكات Cisco وإعدادات Router/Switch ومهارات الدعم الفني داخل الشركة.",
    requirements: [
      "معرفة بأساسيات الشبكات.",
      "يفضل معرفة Packet Tracer.",
      "الالتزام بالحضور."
    ],
    tasks: [
      "إعداد وصيانة الشبكة داخل الشركة.",
      "مساعدة الموظفين في مشاكل الشبكات.",
      "تطبيق إعدادات أمنية بسيطة."
    ],
    skills: ["Cisco", "Networking", "Troubleshooting", "Packet Tracer"]
  },

  6: {
    title: "تدريب Digital Marketing",
    company: "شركة Media Boost",
    type: "عن بعد",
    status: "مفتوحة",
    location: "عن بعد",
    hours: "80 ساعة",
    major: "إدارة وأعمال",
    date: "2026-02-04",
    cover: "../../img/digital.jpeg",
    desc: "تدريب على التسويق الرقمي وكتابة المحتوى وإدارة الصفحات وتنفيذ حملات إعلانية بسيطة.",
    requirements: [
      "مهارات تواصل جيدة.",
      "كتابة محتوى بالعربي بشكل ممتاز.",
      "الالتزام بالمواعيد."
    ],
    tasks: [
      "كتابة منشورات أسبوعية.",
      "إدارة صفحات التواصل.",
      "تحليل نتائج الحملات."
    ],
    skills: ["Content Writing", "Social Media", "Ads Basics", "Marketing"]
  },

  7: {
    title: "تدريب Mobile App Developer",
    company: "شركة Appify",
    type: "هجين",
    status: "مفتوحة",
    location: "غزة | جزئي عن بعد",
    hours: "150 ساعة",
    major: "تكنولوجيا المعلومات",
    date: "2026-02-03",
    cover: "../../img/webDev.jpeg",
    desc: "تدريب على تطوير تطبيقات Android وربطها بـ API والتعامل مع قواعد البيانات وإدارة الشاشات.",
    requirements: [
      "معرفة بأساسيات Java أو Kotlin.",
      "معرفة بأساسيات Android Studio.",
      "اهتمام بتطوير التطبيقات."
    ],
    tasks: [
      "إنشاء شاشات تطبيق.",
      "ربط التطبيق مع API.",
      "تخزين بيانات محلياً."
    ],
    skills: ["Android", "Java/Kotlin", "API Integration", "UI Screens"]
  },

  8: {
    title: "تدريب Data Analyst",
    company: "شركة Smart Analytics",
    type: "هجين",
    status: "مفتوحة",
    location: "غزة | جزئي عن بعد",
    hours: "100 ساعة",
    major: "علوم الحاسوب",
    date: "2026-02-02",
    cover: "../../img/Business_Analyst_(BA).jpg",
    desc: "تدريب على تحليل البيانات باستخدام Excel و Power BI مع مبادئ SQL وبناء Dashboards احترافية.",
    requirements: [
      "معرفة جيدة ببرنامج Excel.",
      "اهتمام بتحليل البيانات.",
      "القدرة على التعلم الذاتي."
    ],
    tasks: [
      "تنظيف البيانات وتجهيزها.",
      "إنشاء تقارير Dashboard.",
      "استخراج نتائج وتحليلات."
    ],
    skills: ["Excel", "Power BI", "SQL Basics", "Data Cleaning"]
  }
};

  // Get ID from URL
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id") || "1";

  const data = opportunities[id];

  // لو المستخدم كتب id غلط
  if (!data) {
    alert("هذه الفرصة غير موجودة ❌");
    window.location.href = "opportunities.html";
    return;
  }

  // Fill data in HTML
  document.getElementById("opTitle").textContent = data.title;
  document.getElementById("opCompany").textContent = data.company;
  document.getElementById("opType").textContent = data.type;
  document.getElementById("opStatus").textContent = data.status;
  document.getElementById("opLocation").textContent = data.location;
  document.getElementById("opHours").textContent = data.hours;
  document.getElementById("opMajor").textContent = data.major;
  document.getElementById("opDate").textContent = data.date;
  document.getElementById("opDesc").textContent = data.desc;

  // Cover Image
  const coverImg = document.querySelector(".details-cover img");
  coverImg.src = data.cover;

  // Requirements
  const reqList = document.getElementById("opRequirements");
  reqList.innerHTML = "";
  data.requirements.forEach((item) => {
    const li = document.createElement("li");
    li.textContent = item;
    reqList.appendChild(li);
  });

  // Tasks
  const tasksList = document.getElementById("opTasks");
  tasksList.innerHTML = "";
  data.tasks.forEach((item) => {
    const li = document.createElement("li");
    li.textContent = item;
    tasksList.appendChild(li);
  });

  // Skills
  const skillsBox = document.getElementById("opSkills");
  skillsBox.innerHTML = "";
  data.skills.forEach((skill) => {
    const span = document.createElement("span");
    span.className = "skill";
    span.textContent = skill;
    skillsBox.appendChild(span);
  });

  // Apply Button
  document.getElementById("applyBtn").addEventListener("click", () => {
    alert("لازم تسجلي دخول كطالب أولاً ✨");
    // لاحقاً في Laravel:
    // window.location.href = "login.html";
  });
});



document.querySelectorAll('.account-box').forEach(box => {
  box.addEventListener('click', () => {
    document.querySelectorAll('.account-box')
      .forEach(b => b.classList.remove('active'));
    box.classList.add('active');
  });
});

function sendResetLink(e){
  e.preventDefault();

  const email = document.getElementById("resetEmail").value;

  alert("تم إرسال رابط إعادة تعيين كلمة المرور إلى: " + email);

  window.location.href = "login.html";
}

