{{-- resources/views/girlyPedia/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $girlyPediaItem->title }}</h1>
    <p>{{ $girlyPediaItem->description }}</p>
    <a href="{{ $girlyPediaItem->link }}" target="_blank">View Link</a>
    <div class="mt-3">
        <a href="{{ route('girlyPedia.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('girlyPedia.edit', $girlyPediaItem->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('girlyPedia.destroy', $girlyPediaItem->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection
