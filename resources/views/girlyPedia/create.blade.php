{{-- resources/views/girlyPedia/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New GirlyPedia Item</h1>
    <form action="{{ route('girlyPedia.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="link">Link</label>
            <input type="url" class="form-control" name="link" id="link" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('girlyPedia.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
