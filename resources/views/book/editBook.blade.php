@extends('layouts.master')

@section('titolo')
@if(isset($book->id))
    Edit book
@else
    Add new book
@endif
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
        @if(isset($book->id))
            <li class="breadcrumb-item">Edit</li>
        @else
            <li class="breadcrumb-item">Add</li>
        @endif
    </ol>
</nav>
@endsection

@section('corpo')
<div class="row">
    <div class='col-md-12'>
        @if(isset($book->id))
        <form class="form-horizontal" name="book" method="post" action="{{ route('book.update', ['book' => $book->id]) }}">
        @method('PUT')
        @else
        <form class="form-horizontal" name="book" method="post" action="{{ route('book.store') }}">
        @endif
        @csrf
            <div class="form-group">
                <label for="title">Title</label>
                @if(isset($book->id))
                <input class="form-control" type="text" id="title" name="title" placeholder="Title" value="{{ $book->title }}">
                @else
                <input class="form-control" type="text" id="title" name="title" placeholder="Title">
                @endif   
                <span class="invalid-input" id="invalid-title"></span>
            </div>
                
            <div class="form-group">
                <label for="author_id">Author</label>
                <select class="form-select" name="author_id">
                @foreach($authorList as $author)
                    @if((isset($book->id))&&($author->id == $book->author_id))
                    <option value="{{ $author->id }}" selected="selected">{{ $author->lastname }}</option>
                    @else
                    <option value="{{ $author->id }}">{{ $author->lastname }}</option>
                    @endif
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Categories</label>
                <select class="form-select" multiple="multiple" name="category_id[]">
                @foreach($categories as $cat)
                    @if((isset($book->id))&&($cat->books()->where('book_id',$book->id)->exists()))
                    <option value="{{ $cat->id }}" selected="selected">{{ $cat->name }}</option>
                    @else
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endif
                @endforeach
                </select>
                <span class="invalid-input" id="no-category-selection"></span>
            </div>
            <a href="{{ route('book.index') }}" class="btn btn-secondary"><i class="bi-box-arrow-left"></i> Cancel</a>
            @if(isset($book->id))
            <input type="hidden" name="id" value="{{ $book->id }}"/>
            <label for="mySubmit" class="btn btn-primary"><i class="bi-check-lg"></i> Save</label>
            <input id="mySubmit" type="submit" value="Save" class="hidden" onclick="event.preventDefault(); checkBook('Save')"/>
            @else
            <label for="mySubmit" class="btn btn-primary"><i class="bi-check-lg"></i> Create</label>
            <input id="mySubmit" type="submit" value="Create" class="hidden" onclick="event.preventDefault(); checkBook('Create')"/>
            @endif
        </form>
    </div>
</div>
@endsection