@extends('layouts.app')

@section('title', 'Blog Editor | free-education.fun')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4">CKEditor Content Editor</h1>
        <form>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input class="form-control" type="text" placeholder="Enter post title">
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea id="editor" class="form-control" rows="10"></textarea>
            </div>
            <button class="btn btn-primary" type="button">Save Draft</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor')).catch(console.error);
</script>
@endsection
