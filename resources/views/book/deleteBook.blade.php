@extends('layouts.master')

@section('titolo')
Remove the book "{{ $book->title }}" from database?
@endsection

@section('stile', 'style.css')

@section('left_navbar')
<li class="nav-item">
    <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
</li>
<li class="nav-item dropdown current">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">My Library</a>
    <ul class="dropdown-menu">
        <li class="current"><a class="dropdown-item" href="{{ route('book.index') }}">Books's list</a></li>
        <li><a class="dropdown-item" href="{{ route('author.index') }}">Authors' list</a></li>
    </ul>
</li>
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('book.index') }}">Library</a></li>
        <li class="breadcrumb-item"><a href="{{ route('book.index') }}">Books</a></li>
        <li class="breadcrumb-item">Delete</li>
    </ol>
</nav>
@endsection

@section('corpo')
<div class="row">
    <div class="col-md-6">
        <div class="card text-center border-secondary">
            <div class='card-header'>
                Revert
            </div>
            <div class='card-body'>
                <p>The book <strong>will not be removed</strong> from the database</p>
                <p><a class="btn btn-secondary" href="{{ route('book.index') }}"><i class="bi-box-arrow-left"></i> Back</a></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center border-danger">
            <div class='card-header'>
                Confirm
            </div>
            <div class='card-body'>
                <p>The book <strong>will be removed</strong> from the database</p>
                <p><a class="btn btn-danger" href="{{ route('book.destroy', ['id' => $book->id]) }}"><i class="bi-trash3"></i> Remove</a></p>
            </div>
        </div>
    </div>
</div>
@endsection