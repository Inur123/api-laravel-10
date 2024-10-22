@extends('layouts.app')

@section('title', 'Edit GirlyPedia Item')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit GirlyPedia Item</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('girlyPedia.update', $girlyPediaItem->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $girlyPediaItem->title }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ $girlyPediaItem->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="url" class="form-control" id="link" name="link" value="{{ $girlyPediaItem->link }}" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning">Update Item</button>
                                    <a href="{{ route('girlyPedia.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
