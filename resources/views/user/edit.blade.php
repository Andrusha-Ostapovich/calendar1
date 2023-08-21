@extends('layouts.app')

@section('content')
    <h1>Edit Profile</h1>
    <form method="POST" action="{{ route('user.update') }}">
        @csrf
        @method('PUT')
        
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
        @error('name')
            <div>{{ $message }}</div>
        @enderror
        
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
        @error('email')
            <div>{{ $message }}</div>
        @enderror
        
        <label for="password">Password</label>
        <input type="password" name="password">
        @error('password')
            <div>{{ $message }}</div>
        @enderror
        
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation">
        
        <button type="submit">Update Profile</button>
    </form>
@endsection
