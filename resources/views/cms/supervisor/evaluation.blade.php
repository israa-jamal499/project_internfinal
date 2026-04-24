@extends('cms.supervisor.parent')

@section('title','التقييم')

@section('styles')
<style>
    .evaluation-page {
    padding: 25px 20px 40px;
    background: #f4f6f9;
    min-height: calc(100vh - 120px);
}
.evaluation-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}
.evaluation-hero {
    background: linear-gradient(135deg, #1f5fa8, #3e7cd7);
    border-radius: 22px;
    padding: 28px 30px;
    margin-bottom: 22px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10);
}
.evaluation-hero h2 {
    margin: 0 0 8px;
    color: #fff;
    font-size: 32px;
    font-weight: 800;
}
.evaluation-hero p {
    margin: 0;
    color: #e8f1ff;
    font-size: 15px;
}
.evaluation-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}
.eval-stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #ecf0f4;
}
.eval-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: #eaf2ff;
    color: #2f69c0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.eval-stat-card h3 {
    margin: 0;
    color: #2f69c0;
    font-size: 24px;
    font-weight: 800;
}
.eval-stat-card p {
    margin: 4px 0 0;
    color: #6b7280;
    font-size: 14px;
}
.evaluation-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 20px;
}
.evaluation-card {
    background: #fff;
    border-radius: 22px;
    padding: 24px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
    border: 1px solid #edf1f5;
}
.card-head {
    margin-bottom: 20px;
}
.card-head h3 {
    margin: 0 0 8px;
    font-size: 28px;
    color: #2c5aa0;
    font-weight: 800;
}
.card-head p {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
}
.evaluation-form .form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
}
.evaluation-form label {
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}
.evaluation-form input,
.evaluation-form select,
.evaluation-form textarea {
    width: 100%;
    border: 1px solid #d8e0ea;
    border-radius: 14px;
    padding: 14px 16px;
    font-size: 15px;
    background: #fafbfd;
    transition: 0.2s ease;
}
.evaluation-form input:focus,
.evaluation-form select:focus,
.evaluation-form textarea:focus {
    outline: none;
    border-color: #3e7cd7;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(62, 124, 215, 0.10);
}
.scores-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
.evaluation-actions {
    margin-top: 20px;
}
.save-eval-btn {
    min-width: 220px;
    height: 50px;
    border: none;
    border-radius: 14px;
    background: #3e7cd7;
    color: #fff;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    transition: 0.2s ease;
}
.save-eval-btn:hover {
    background: #2f69c0;
}
.eval-cards-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.eval-card {
    background: #f8fbff;
    border: 1px solid #dce9fb;
    border-radius: 16px;
    padding: 16px;
}
.eval-card h4 {
    margin: 0 0 10px;
    color: #2c5aa0;
    font-size: 17px;
    font-weight: 800;
}
.eval-card p {
    margin: 6px 0;
    color: #374151;
    line-height: 1.8;
    font-size: 14px;
}
.empty-state {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
    background: #f8fafc;
    border: 1px dashed #cfd8e3;
    border-radius: 14px;
    padding: 18px;
    text-align: center;
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
@media (max-width: 992px) {
    .evaluation-grid {
        grid-template-columns: 1fr;
    }
    .evaluation-stats {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 768px) {
    .scores-grid {
        grid-template-columns: 1fr;
    }
    .save-eval-btn {
        width: 100%;
    }
    .evaluation-hero h2 {
        font-size: 26px;
    }
}
</style>
@endsection

@section('content')
<main class="evaluation-page">
    <div class="evaluation-wrapper">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <section class="evaluation-hero">
            <div class="evaluation-hero-text">
                <h2>⭐ التقييم النهائي للطالب</h2>
                <p>اختاري الطالب ثم أدخلي تقييم التدريب النهائي بشكل واضح ومنظم.</p>
            </div>
        </section>

        <section class="evaluation-stats">
            <div class="eval-stat-card">
                <span class="eval-stat-icon">👨‍🎓</span>
                <div>
                    <h3 id="evalStudentsCount">{{ $studentsCount }}</h3>
                    <p>عدد الطلاب</p>
                </div>
            </div>

            <div class="eval-stat-card">
                <span class="eval-stat-icon">📝</span>
                <div>
                    <h3 id="evalSavedCount">{{ $savedCount }}</h3>
                    <p>تقييمات محفوظة</p>
                </div>
            </div>

            <div class="eval-stat-card">
                <span class="eval-stat-icon">⏳</span>
                <div>
                    <h3>{{ $pendingCount }}</h3>
                    <p>بانتظار التقييم</p>
                </div>
            </div>
        </section>

        <section class="evaluation-grid">

            <div class="evaluation-card form-card">
                <div class="card-head">
                    <h3>📝 نموذج التقييم</h3>
                    <p>املئي النموذج التالي ثم احفظي التقييم.</p>
                </div>

                <form class="evaluation-form" method="POST" action="{{ route('cms.supervisor.evaluation.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="internships_id">الطالب</label>
                        <select id="internships_id" name="internships_id">
                            <option value="">اختاري الطالب</option>
                            @foreach($internships as $internship)
                                <option value="{{ $internship->id }}" {{ old('internships_id') == $internship->id ? 'selected' : '' }}>
                                    {{ $internship->student->full_name ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="overall_assessment">التقييم العام</label>
                        <select id="overall_assessment" name="overall_assessment">
                            <option value="ممتاز">ممتاز</option>
                            <option value="جيد جدًا">جيد جدًا</option>
                            <option value="جيد">جيد</option>
                            <option value="مقبول">مقبول</option>
                        </select>
                    </div>

                    <div class="scores-grid">
                        <div class="form-group">
                            <label for="commitment">الالتزام</label>
                            <input type="number" id="commitment" name="commitment" min="1" max="10" value="{{ old('commitment', 8) }}">
                        </div>

                        <div class="form-group">
                            <label for="skills">المهارات</label>
                            <input type="number" id="skills" name="skills" min="1" max="10" value="{{ old('skills', 8) }}">
                        </div>

                        <div class="form-group">
                            <label for="communication">التواصل</label>
                            <input type="number" id="communication" name="communication" min="1" max="10" value="{{ old('communication', 8) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="general_feedback">ملاحظات المشرف</label>
                        <textarea id="general_feedback" name="general_feedback" rows="5" placeholder="اكتبي ملاحظاتك هنا...">{{ old('general_feedback') }}</textarea>
                    </div>

                    <div class="evaluation-actions">
                        <button type="submit" class="save-eval-btn">💾 حفظ التقييم</button>
                    </div>
                </form>
            </div>

            <div class="evaluation-card saved-card">
                <div class="card-head">
                    <h3>📌 تقييمات محفوظة</h3>
                    <p>ستظهر هنا التقييمات التي تم حفظها.</p>
                </div>

                <div id="evalCards" class="eval-cards-list">
                    @forelse($evaluations as $evaluation)
                        <div class="eval-card">
                            <h4>👩‍🎓 {{ $evaluation->internship->student->full_name ?? '-' }} - ⭐ {{ $evaluation->overall_assessment }}</h4>
                            <p>
                                <b>الالتزام:</b> {{ $evaluation->commitment }}/10 |
                                <b>المهارات:</b> {{ $evaluation->skills }}/10 |
                                <b>التواصل:</b> {{ $evaluation->communication }}/10
                            </p>
                            <p><b>ملاحظات:</b> {{ $evaluation->general_feedback ?? 'لا يوجد' }}</p>
                        </div>
                    @empty
                        <p class="empty-state">لا يوجد تقييمات محفوظة بعد.</p>
                    @endforelse
                </div>
            </div>

        </section>
    </div>
</main>
@endsection
