@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Радагування профіля</h1>
    <form action="{{ route('user.profile.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Ім'я</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
        @error('name')
        <div>{{ $message }}</div>
        @enderror
        <br>
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
        @error('email')
        <div>{{ $message }}</div>
        @enderror
        <br>
        <br>
        <label for="password">Пароль</label>
        <input type="password" name="password">
        @error('password')
        <div>{{ $message }}</div>
        @enderror
        <br>
        <br>
        <label for="password_confirmation">Підтвердіть пароль</label>
        <input type="password" name="password_confirmation">
        <br>
        <br>
        <button class="btn btn-success" type="submit">Оновити данні</button>

    </form>
</div>
@endsection