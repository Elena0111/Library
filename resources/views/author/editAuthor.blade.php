@extends('layouts.master')

@section('titolo')
@if(isset($author->id))
    Edit author
@else
    Add new author
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
        @if(isset($author->id))
            <li class="breadcrumb-item">Update</li>
        @else
            <li class="breadcrumb-item">Add</li>
        @endif
    </ol>
</nav>
@endsection

@section('corpo')
<div class="row">
    <div class='col-md-12'>
        @if(isset($author->id))
        <form class="form-horizontal" name="author" method="post" action="{{ route('author.update', ['author' => $author->id]) }}">
        @method('PUT')
        @else
        <form class="form-horizontal" name="author" method="post" action="{{ route('author.store') }}">
        @endif
        @csrf
            <div class="form-group">
                <label for="firstName">Nome</label>
                @if(isset($author->id))
                <input class="form-control" type="text" id="firstName" name="firstName" placeholder="Nome autore" value="{{ $author->firstname }}">
                @else
                <input class="form-control" type="text" id="firstName" name="firstName" placeholder="Nome autore">
                @endif
                <span class="invalid-input" id="invalid-firstName"></span>
            </div>

            <div class="form-group">
                <label for="lastName">Cognome</label>
                @if(isset($author->id))
                <input class="form-control" type="text" id="lastName" name="lastName" placeholder="Cognome autore" value="{{ $author->lastname }}">
                @else
                <input class="form-control" type="text" id="lastName" name="lastName" placeholder="Cognome autore">
                @endif  
                <span class="invalid-input" id="invalid-lastName"></span>  
            </div>
            <a href="{{ route('author.index') }}" class="btn btn-secondary"><i class="bi-box-arrow-left"></i> Back</a>
            @if(isset($author->id))
            <input type="hidden" name="id" value="{{ $author->id }}"/>
            <label for="mySubmit" class="btn btn-primary"><i class="bi-check-lg"></i> Save</label>
            <input id="mySubmit" type="submit" value="Save" class="hidden" onclick="event.preventDefault(); checkAuthor('Save')"/>
            @else
            <label for="mySubmit" class="btn btn-primary"><i class="bi-check-lg"></i> Create</label>
            <input id="mySubmit" type="submit" value="Create" class="hidden" onclick="event.preventDefault(); checkAuthor('Create')"/>
            @endif
        </form>
    </div>
</div>
@endsection