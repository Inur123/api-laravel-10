@extends('layouts.app')

@section('title', 'Edit Podcast')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<script src="https://cdn.tiny.cloud/1/mimr482vltcpcta1nd94dwlkgbsdgmcyz4n3tve4ydvf4l83/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Podcast</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('podcasts.update', $podcast->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                               id="title" name="title" value="{{ old('title', $podcast->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="4" required>{{ old('description', $podcast->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="url" class="form-control @error('link') is-invalid @enderror"
                                               id="link" name="link" value="{{ old('link', $podcast->link) }}" required>
                                        @error('link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Update Podcast</button>
                                        <a href="{{ route('podcasts.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        tinymce.init({
            selector: '#description',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media',
                'searchreplace', 'table', 'visualblocks', 'wordcount',
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed',
                'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste',
                'advtable', 'advcode', 'editimage', 'advtemplate', 'ai',
                'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags',
                'autocorrect', 'typography', 'inlinecss', 'markdown',
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
            height: 300,
        });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
