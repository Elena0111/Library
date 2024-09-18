@extends('layouts.master')

@section('titolo', 'Delete author from the list')

@section('stile', 'style.css')

@section('left_navbar')
<li class="nav-item">
    <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
</li>
<li class="nav-item dropdown current">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">My Library</a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('book.index') }}">Books's list</a></li>
        <li class="current"><a class="dropdown-item" href="{{ route('author.index') }}">Authors' list</a></li>
    </ul>
</li>
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('author.index') }}">Library</a></li>
        <li class="breadcrumb-item"><a href="{{ route('author.index') }}">Authors</a></li>
        <li class="breadcrumb-item">Delete</li>
    </ol>
</nav>
@endsection

@section('corpo')
<div class="row">
    <div class="col-md-12">
        <div class="card text-center border-danger">
            <div class='card-header'>
                Access denied
            </div>
            <div class='card-body text-danger'>
                <p>Something <strong>wrong</strong> happened during deleting procedure. Maybe wrong author's id?</p>
                <p><a class="btn btn-secondary" href="{{ route('author.index') }}"><i class="bi-box-arrow-left"></i> Back to the authors' list</a></p>
            </div>
        </div>
    </div>
</div>
@endsection