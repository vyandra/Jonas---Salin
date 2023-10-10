@extends('layouts.admin')

@section('content')
<div>
    <h1>File Details</h1>
    <iframe src="{{ $fileUrl }}" width="100%" height="500px"></iframe>
</div>
@endsection