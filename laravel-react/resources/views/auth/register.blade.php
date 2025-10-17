@extends('layout')
@section('title', 'register')
@section('content')
<div class="container">
  <div class="mt-5">
    {{-- Error and success messages --}}
    @if($errors->any())
    <div class="col-12">
      @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
      @endforeach
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
  </div>

  <form action="{{ route('register.post') }}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px">
    @csrf

    {{-- Basic user info --}}

       <div class="mb-3">
        <label class="form-label">Volledige/Bedrijfs naam</label>
        <input type="text" class="form-control" name="name" required>
      </div>

    <div class="mb-3">
      <label class="form-label">Email adres</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Wachtwoord</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Registreer als</label>
      <select name="role" id="roleSelect" class="form-select" required>
        <option value="">-- Selecteer rol --</option>
        <option value="student">Student</option>
        <option value="company">Company</option>
      </select>
    </div>

    {{-- Student Section --}}
    <div id="studentQuestions" class="mb-3" style="display: none;">
      <h6 class="mt-3">Student Information</h6>

      <div class="mb-2">
        <label class="form-label">Portfolio</label>
        <input type="text" class="form-control" name="Portfolio_Link">
      </div>

      <div class="mb-2">
        <label class="form-label">Over mij</label>
        <input type="text" class="form-control" name="About_Text">
      </div>

      <div class="mb-2">
        <label class="form-label">Adres</label>
        <input type="text" class="form-control" name="Address">
      </div>

      <div class="mb-2">
        <label class="form-label">Leeftijd</label>
        <input type="number" class="form-control" name="Age">
      </div>

      <div class="mb-3">
        <label class="form-label">Geslacht</label>
        <select name="Gender" class="form-select">
          <option value="">-- Selecteer Geslacht --</option>
          <option value="Male">Man</option>
          <option value="Female">Vrouw</option>
          <option value="Other">Anders</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Studie</label>
        <select name="Profession_ID" class="form-select">
          <option value="">-- Selecteer Studie --</option>
          @php
          $professions = \App\Models\Profession::all();
          @endphp
          @foreach($professions as $profession)
          <option value="{{ $profession->Profession_ID }}">{{ $profession->Profession_Name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-2">
        <label class="form-label">School</label>
        <select name="School_ID" class="form-select">
          <option value="">-- Selecteer School --</option>
          @php
          $schools = \App\Models\School::all();
          @endphp
          @foreach($schools as $school)
          <option value="{{ $school->School_ID }}">{{ $school->School_Name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Company Section --}}
    <div id="companyQuestions" class="mb-3" style="display: none;">
      <h6 class="mt-3">Bedrijf Informatie</h6>

      <div class="mb-2">
        <label class="form-label">Bedrijf Adres</label>
        <input type="text" class="form-control" name="Company_Address">
      </div>

      <div class="mb-2">
        <label class="form-label">KVK</label>
        <input type="number" class="form-control" name="KVK" maxlength="8">
      </div>

      <div class="mb-2">
        <label class="form-label">Website</label>
        <input type="text" class="form-control" name="Website_Link">
      </div>

      <div class="mb-2">
        <label class="form-label">Field</label>
        <input type="text" class="form-control" name="field">
      </div>
      <div class="mb-3">
        <label class="form-label">Studie</label>
        <select name="profession_id" class="form-select">
          <option value="">-- Selecteer Studie --</option>
          @php
          $professions = \App\Models\Profession::all();
          @endphp
          @foreach($professions as $profession)
          <option value="{{ $profession->Profession_ID }}">{{ $profession->Profession_Name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">aanmelden</button>

    <a href="{{ route('login') }}" class="btn btn-primary">Heb al een account</a>
  </form>
</div>

{{-- ✅ JavaScript: show/hide sections and manage required fields --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    const studentQuestions = document.getElementById('studentQuestions');
    const companyQuestions = document.getElementById('companyQuestions');

    // Helper to toggle "required" dynamically
    function setRequired(container, enable) {
      const inputs = container.querySelectorAll('input, select, textarea');
      inputs.forEach(el => {
        if (enable) el.setAttribute('required', true);
        else el.removeAttribute('required');
      });
    }

    roleSelect.addEventListener('change', function() {
      if (this.value === 'student') {
        studentQuestions.style.display = 'block';
        companyQuestions.style.display = 'none';
        setRequired(studentQuestions, true);
        setRequired(companyQuestions, false);
      } else if (this.value === 'company') {
        companyQuestions.style.display = 'block';
        studentQuestions.style.display = 'none';
        setRequired(companyQuestions, true);
        setRequired(studentQuestions, false);
      } else {
        studentQuestions.style.display = 'none';
        companyQuestions.style.display = 'none';
        setRequired(companyQuestions, false);
        setRequired(studentQuestions, false);
      }
    });
  });
</script>
@endsection