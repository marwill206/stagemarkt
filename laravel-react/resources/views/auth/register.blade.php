@extends('layout')
@section('title', 'register')
@section('content')
<div class="container">
  <div class="mt-5">
    @if($errors->any())
      <div class="col-12">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
      </div>
    @endif

    @if (session()->has('error'))
      <div class="alert alert-danger">{{session('error')}}</div>
    @endif

    @if (session()->has('success'))
      <div class="alert alert-success">{{session('success')}}</div>
    @endif
  </div>

  <form action="{{ route('register.post') }}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px">
    @csrf

    <div class="mb-3">
      <label class="form-label">Fullname</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Register as</label>
      <select name="role" class="form-select" required>
        <option value="">-- Select Role --</option>
        <option value="student">Student</option>
        <option value="company">Company</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>
@endsection
