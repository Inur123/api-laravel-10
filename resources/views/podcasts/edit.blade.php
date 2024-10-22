<!-- resources/views/podcasts/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Podcast')

@section('content')
<h1>Edit Podcast</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('podcasts.update', $podcast->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Add this line for PUT method -->

    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ old('title', $podcast->title) }}" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required>{{ old('description', $podcast->description) }}</textarea>
    </div>
    <div>
        <label for="link">Link:</label>
        <input type="url" id="link" name="link" value="{{ old('link', $podcast->link) }}" required>
    </div>
    <button type="submit">Update Podcast</button>
</form>
@endsection
