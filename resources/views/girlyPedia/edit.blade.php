{{-- resources/views/girlyPedia/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit GirlyPedia Item</h1>
    <form action="{{ route('girlyPedia.update', $girlyPediaItem->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ $girlyPediaItem->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required>{{ $girlyPediaItem->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="link">Link</label>
            <input type="url" class="form-control" name="link" id="link" value="{{ $girlyPediaItem->link }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('girlyPedia.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
