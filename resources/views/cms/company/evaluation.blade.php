@extends('cms.company.temp')
@section('title','evaluation')
@section('main-title','التقييم')
@section('content')

<style>
.company-evaluation-page {
    width: 92%;
    margin: 30px auto;
    font-family: Tahoma, Arial, sans-serif;
    direction: rtl;
    text-align: right;
}
.company-evaluation-card {
    background: #fff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}
.company-evaluation-title {
    margin: 0 0 10px;
    color: #1c2b4a;
    font-size: 24px;
    font-weight: 700;
}
.company-evaluation-desc {
    margin: 0;
    color: #6b7280;
    font-size: 13px;
}
.company-evaluation-intern {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}
.company-evaluation-intern img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
}
.company-evaluation-name {
    font-weight: bold;
    font-size: 16px;
    color: #1c2b4a;
    margin-bottom: 6px;
}
.company-evaluation-meta {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 4px;
}
.company-evaluation-stars {
    margin-top: 20px;
    font-size: 28px;
    cursor: pointer;
    color: #ddd;
    user-select: none;
}
.company-evaluation-stars span.active {
    color: #f59e0b;
}
.company-evaluation-group {
    margin-top: 15px;
}
.company-evaluation-label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    color: #1c2b4a;
    font-size: 14px;
}
.company-evaluation-select,
.company-evaluation-textarea {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-family: Tahoma, Arial, sans-serif;
    font-size: 14px;
    outline: none;
    background: #fff;
    color: #333;
}
.company-evaluation-select:focus,
.company-evaluation-textarea:focus {
    border-color: #3e7cd7;
    box-shadow: 0 0 0 3px rgba(62,124,215,0.12);
}
.company-evaluation-textarea {
    resize: none;
    height: 110px;
}
.company-evaluation-btn {
    margin-top: 18px;
    background: #3e7cd7;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
    transition: 0.2s ease;
}
.company-evaluation-btn:hover {
    background: #2f68bd;
}
.company-evaluation-success {
    display: none;
    margin-top: 12px;
    color: #16a34a;
    font-weight: bold;
    font-size: 14px;
}
.alert{
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:16px;
}
.alert-success{
    background:#e7f8ee;
    color:#0a7a36;
    border:1px solid #c8f0d7;
}
.alert-danger{
    background:#ffe9e9;
    color:#b00000;
    border:1px solid #ffd0d0;
}
@media (max-width: 768px) {
    .company-evaluation-page {
        width: 95%;
    }
    .company-evaluation-title {
        font-size: 20px;
    }
    .company-evaluation-intern {
        align-items: flex-start;
    }
}
</style>

<div class="company-evaluation-page">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $selectedInternship = $internships->first();
        $selectedEvaluation = $selectedInternship?->companyEvaluation;
    @endphp

    <div class="company-evaluation-card">

        <h2 class="company-evaluation-title">تقييم المتدرب</h2>
        <p class="company-evaluation-desc">يرجى تقييم أداء المتدرب بعد انتهاء فترة التدريب</p>

        <form method="POST" action="{{ route('cms.company.evaluation.store') }}">
            @csrf

            <div class="company-evaluation-group">
                <label class="company-evaluation-label" for="internships_id">اختيار المتدرب</label>
                <select name="internships_id" id="internships_id" class="company-evaluation-select">
                    @foreach($internships as $internship)
                        <option value="{{ $internship->id }}" {{ old('internships_id') == $internship->id ? 'selected' : '' }}>
                            {{ $internship->student->full_name ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($selectedInternship)
            <div class="company-evaluation-intern">
                <img src="{{ asset('internship/img/israa.jpeg') }}" alt="صورة المتدرب">

                <div>
                    <div class="company-evaluation-name">{{ $selectedInternship->student->full_name ?? '-' }}</div>
                    <div class="company-evaluation-meta">التخصص: {{ $selectedInternship->student->specialization->name ?? '-' }}</div>
                    <div class="company-evaluation-meta">التدريب: {{ $selectedInternship->opportunity->title ?? '-' }}</div>
                </div>
            </div>
            @endif

            <div class="company-evaluation-stars" id="companyEvaluationStars">
                <span data-value="1">★</span>
                <span data-value="2">★</span>
                <span data-value="3">★</span>
                <span data-value="4">★</span>
                <span data-value="5">★</span>
            </div>

            <input type="hidden" name="overall_assessment" id="overall_assessment" value="{{ old('overall_assessment', $selectedEvaluation?->overall_assessment) }}">

            <div class="company-evaluation-group">
                <label class="company-evaluation-label" for="technical_skills">مستوى المهارات التقنية</label>
                <select name="technical_skills" id="technical_skills" class="company-evaluation-select">
                    <option value="ممتاز">ممتاز</option>
                    <option value="جيد جدا">جيد جدا</option>
                    <option value="جيد">جيد</option>
                    <option value="ضعيف">ضعيف</option>
                </select>
            </div>

            <div class="company-evaluation-group">
                <label class="company-evaluation-label" for="commitment_discipline">الالتزام والانضباط</label>
                <select name="commitment_discipline" id="commitment_discipline" class="company-evaluation-select">
                    <option value="ممتاز">ممتاز</option>
                    <option value="جيد جدا">جيد جدا</option>
                    <option value="جيد">جيد</option>
                    <option value="ضعيف">ضعيف</option>
                </select>
            </div>

            <div class="company-evaluation-group">
                <label class="company-evaluation-label" for="communication_teamwork">التواصل والعمل الجماعي</label>
                <select name="communication_teamwork" id="communication_teamwork" class="company-evaluation-select">
                    <option value="ممتاز">ممتاز</option>
                    <option value="جيد جدا">جيد جدا</option>
                    <option value="جيد">جيد</option>
                    <option value="ضعيف">ضعيف</option>
                </select>
            </div>

            <div class="company-evaluation-group">
                <label class="company-evaluation-label" for="general_feedback">تعليق الشركة</label>
                <textarea name="general_feedback" id="general_feedback" class="company-evaluation-textarea" placeholder="اكتب ملاحظاتك هنا...">{{ old('general_feedback', $selectedEvaluation?->general_feedback) }}</textarea>
            </div>

            <button type="submit" class="company-evaluation-btn">
                حفظ التقييم
            </button>
        </form>

    </div>
</div>

<script>
let companyEvaluationRating = document.getElementById("overall_assessment").value || 0;

function paintStars(num) {
    const stars = document.querySelectorAll("#companyEvaluationStars span");
    stars.forEach((star, index) => {
        if (index < num) {
            star.classList.add("active");
        } else {
            star.classList.remove("active");
        }
    });
}

document.querySelectorAll("#companyEvaluationStars span").forEach(star => {
    star.addEventListener("click", function () {
        companyEvaluationRating = this.dataset.value;
        document.getElementById("overall_assessment").value = companyEvaluationRating;
        paintStars(companyEvaluationRating);
    });
});

paintStars(companyEvaluationRating);

document.getElementById('technical_skills').value = @json(old('technical_skills', $selectedEvaluation?->technical_skills ?? 'ممتاز'));
document.getElementById('commitment_discipline').value = @json(old('commitment_discipline', $selectedEvaluation?->commitment_discipline ?? 'ممتاز'));
document.getElementById('communication_teamwork').value = @json(old('communication_teamwork', $selectedEvaluation?->communication_teamwork ?? 'ممتاز'));
</script>

@endsection
