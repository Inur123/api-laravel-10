<!-- resources/views/podcasts/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $podcast->title }}</h1>
    <p><strong>Description:</strong> {{ $podcast->description }}</p>
    <p><strong>Link:</strong> <a href="{{ $podcast->link }}" target="_blank">{{ $podcast->link }}</a></p>

    <a href="{{ route('podcasts.edit', $podcast->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('podcasts.destroy', $podcast->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
    <a href="{{ route('podcasts.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
