@extends('layouts.master')

@section('titolo')
{{ trans('labels.siteTitle') }}
@endsection

@section('stile', 'style.css')

@section('left_navbar')
<li class="nav-item">
    <a class="nav-link current" aria-current="page" href="#">Home</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">{{ trans('labels.myLibrary') }}</a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('book.index') }}">@lang('labels.booksList')</a></li>
        <li><a class="dropdown-item" href="{{ route('author.index') }}">{{ trans('labels.authorsList') }}</a></li>
    </ul>
</li>
@endsection

@section('corpo')
<div class="row">
    <div class="col-sm-9">
           
    <!--
        <p>Un semplicissimo esempio di sito web realizzato 
            durante il corso di Programmazione Web e Servizi 
            Digitali. Il sito riporta l'elenco dei libri che 
            sto leggendo o che ho letto, e la lista degli 
            autori che hanno popolato le mie letture e la mia 
            fantasia. Il sito web continuerà a crescere durante 
            questo semestre, completandosi di volta in volta 
            grazie all'applicazione delle tecnologie web che 
            verranno presentate nel corso. Buon divertimento!
        </p>
        <blockquote>
            <p>Semina un atto, e raccogli un'abitudine; semina 
                un'abitudine, e raccogli un carattere; semina un 
                carattere, e raccogli un destino. 
            </p>
            <small>[Il pensiero del Buddha]</small>
        </blockquote>
                    
    -->
        <p>{{ $introduction }}</p>
        <blockquote>
            <p>{{ $citation }} 
            </p>
            <small>[{{ $reference }}]</small>
        </blockquote>
    </div><!-- /.col-sm-9 -->
    <div class="col-sm-3">
                    
        <img src="img/pretty-4-th.jpg" 
            class="img-thumbnail img-responsive">
                    
    </div><!-- /.col-sm-3 -->
</div><!-- /.row -->
@endsection