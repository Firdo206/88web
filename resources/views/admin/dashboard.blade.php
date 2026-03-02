@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h3>Admin Dashboard</h3>
        <p>Selamat datang Admin, {{ auth()->user()->name }}</p>
    </div>
</div>
@endsection