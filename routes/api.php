<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LibraryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/books', [LibraryController::class, 'listBooks']);
Route::get('/books_per_page', [LibraryController::class, 'listBooksPaginate']);
Route::get('/books_per_page_sorted', [LibraryController::class, 'listBooksPaginateAndSort']);
Route::get('/books_as_resources', [LibraryController::class, 'listBooksWithResources']);
Route::get('/books_with_headers', [LibraryController::class, 'listBookWithResponseHeaders']);
Route::post('/books', [LibraryController::class, 'addBook']);
Route::get('/books_per_categories', [LibraryController::class, 'listBooksByCategories']);
