@extends('front.layout.main')
@section('title', 'How It Work')

@section('content')
@section('css')
@endsection





<!-- Header -->
<section class="page-header">
  <h1>كيف يعمل نظام التدريب؟</h1>
  <p>
    تعرّف على خطوات استخدام منصة التدريب الميداني من التسجيل حتى إتمام التدريب بنجاح.
  </p>
</section>

<!-- Timeline -->
<section class="how-container">

  <div class="timeline">

    <div class="step-item">
      <div class="step-number">1</div>
      <div class="step-card">
        <h3>تسجيل الحساب</h3>
        <p>
          يقوم الطالب أو الشركة بإنشاء حساب على المنصة وإدخال البيانات الأساسية
          لبدء استخدام النظام.
        </p>
      </div>
    </div>

    <div class="step-item">
      <div class="step-number">2</div>
      <div class="step-card">
        <h3>استعراض فرص التدريب</h3>
        <p>
          يمكن للطالب تصفح الفرص المتاحة باستخدام أدوات البحث والتصفية
          لاختيار الفرصة المناسبة.
        </p>
      </div>
    </div>

    <div class="step-item">
      <div class="step-number">3</div>
      <div class="step-card">
        <h3>التقديم على الفرصة</h3>
        <p>
          يرسل الطالب طلب التقديم إلكترونيًا ويتم مراجعته من قبل الشركة
          وإدارة الكلية.
        </p>
      </div>
    </div>

    <div class="step-item">
      <div class="step-number">4</div>
      <div class="step-card">
        <h3>بدء التدريب</h3>
        <p>
          بعد الموافقة، يبدأ الطالب التدريب ويتابع تقدمه من خلال النظام.
        </p>
      </div>
    </div>

    <div class="step-item">
      <div class="step-number">5</div>
      <div class="step-card">
        <h3>التقييم وإتمام التدريب</h3>
        <p>
          يتم تقييم أداء الطالب وتوثيق إتمام التدريب داخل المنصة.
        </p>
      </div>
    </div>

  </div>

  <!-- Summary -->
  <div class="workflow-summary">
    <h2>رحلة تدريب سهلة ومنظمة</h2>
    <p>
      تم تصميم النظام لتبسيط عملية التدريب الميداني وربط الطلبة بسوق العمل
      بطريقة احترافية تضمن تجربة سلسة لجميع الأطراف.
    </p>
  </div>

</section>




@section('js')
@endsection
@endsection
