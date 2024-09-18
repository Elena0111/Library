@extends('layouts.master')

@section('titolo')
My books
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
        <li class="breadcrumb-item" aria-current="page">Library</li>
        <li class="breadcrumb-item">Books</li>
    </ol>
</nav>
@endsection

@section('corpo')
<div class="row">
    <div class="col-md-offset-10 col-xs-6">
        <p>
            <a class="btn btn-success" 
                href="{{ route('book.create') }}"><i class="bi-book"></i> Create new book</a>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-hover table-responsive" 
            style="width:100%">
            <col width='50%'>
            <col width='30%'>
            <col width='10%'>
            <col width='10%'>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($books_list as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author->lastname }}</td>
                        <td>
                            <a class="btn btn-primary" 
                                href="{{ route('book.edit', ['book' => $book->id]) }}"><i class="bi-pencil-square"></i> Edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger" 
                                href="{{ route('book.destroy.confirm', ['id' => $book->id]) }}"><i class="bi-trash3"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection