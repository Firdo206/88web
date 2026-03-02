@extends('layouts.app')

@section('title','Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center mb-4">Register</h4>

                <form method="POST" action="/register">
                    @csrf

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-success w-100">Register</button>
                </form>

                <div class="text-center mt-3">
                    <a href="/login">Sudah punya akun?</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection