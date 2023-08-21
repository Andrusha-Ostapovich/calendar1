@extends('layouts.app')

@section('content')
<div class = 'container'><h1>Профіль</h1>
<p>Ім'я: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<a class="btn btn-success" href="{{ route('user.profile.edit', ['user' => $user->id]) }}">
    {{ __('Редагувати профіль') }}
</a>
</div>
@endsection