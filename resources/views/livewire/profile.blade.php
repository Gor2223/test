@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Профиль</h2>
    <p><strong>Имя:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
</div>
@endsection
