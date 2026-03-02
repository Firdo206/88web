@extends('layouts.app')

@section('title','User Dashboard')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h3>User Dashboard</h3>
        <p>Selamat datang User, {{ auth()->user()->name }}</p>
    </div>
</div>
@endsection