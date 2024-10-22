<!-- resources/views/podcasts/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Podcasts</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('podcasts.create') }}" class="btn btn-primary">Create New Podcast</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($podcasts as $podcast)
            <tr>
                <td>{{ $podcast->id }}</td>
                <td>{{ $podcast->title }}</td>
                <td>{{ $podcast->description }}</td>
                <td><a href="{{ $podcast->link }}" target="_blank">{{ $podcast->link }}</a></td>
                <td>
                    <a href="{{ route('podcasts.show', $podcast->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('podcasts.edit', $podcast->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('podcasts.destroy', $podcast->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
