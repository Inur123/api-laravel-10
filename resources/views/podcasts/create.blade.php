<!-- resources/views/podcasts/create.blade.php -->
@extends('layouts.app')

@section('title', 'Create Podcast')

@section('content')
<h1>Create Podcast</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('podcasts.store') }}" method="POST">
    @csrf
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="link">Link:</label>
        <input type="url" id="link" name="link" required>
    </div>
    <button type="submit">Create Podcast</button>
</form>
@endsection
