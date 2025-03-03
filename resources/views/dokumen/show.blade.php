@extends('layouts.main')

@section('content')
<div class="container">
    <h2>{{ $document->title }}</h2>
    
    <div class="card p-3">
        @if($document->type === 'pdf')
            <iframe src="{{ asset('storage/' . $document->file_path) }}" width="100%" height="600px"></iframe>
            <p><a href="{{ asset('storage/' . $document->file_path) }}" download class="btn btn-primary mt-2">Download PDF</a></p>
        @elseif($document->type === 'image')
            <img src="{{ asset('storage/' . $document->file_path) }}" class="img-fluid rounded" alt="Document Image">
            <p><a href="{{ asset('storage/' . $document->file_path) }}" download class="btn btn-primary mt-2">Download Image</a></p>
        @elseif($document->type === 'link')
            <p><a href="{{ $document->url }}" target="_blank" class="btn btn-success">Visit Link</a></p>
        @endif
    </div>

    <a href="{{ route('documents.index') }}" class="btn btn-secondary mt-3">Back to Documents</a>
</div>
@endsection
