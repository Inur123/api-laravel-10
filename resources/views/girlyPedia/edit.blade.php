@extends('layouts.app')

@section('title', 'Edit GirlyPedia Item')

@push('style')
    <!-- CSS Libraries -->

@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit GirlyPedia</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('girlyPedia.update', $girlyPediaItem->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="image">Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                    @if ($girlyPediaItem->image)
                                        <img src="{{ asset('storage/' . $girlyPediaItem->image) }}" alt="Current Image" class="image-preview"  id="current-image" style="width: 100px; height: 100px;">
                                        <label for="preview">New Image Preview</label>
                                    @endif
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

@push('scripts')
    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/mimr482vltcpcta1nd94dwlkgbsdgmcyz4n3tve4ydvf4l83/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description', // Select the textarea for TinyMCE
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        });

        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            const currentImage = document.getElementById('current-image');

            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Show the new image preview
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                imagePreview.style.display = 'none'; // Hide if no file is selected
            }
        }
    </script>
@endpush
