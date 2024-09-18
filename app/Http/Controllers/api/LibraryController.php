<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataLayer;
use App\Http\Resources\BookResource;

class LibraryController extends Controller
{
    public function listBooks(Request $request)
    {
        // Return all books (with authors if specified in the header)
        $dl = new DataLayer();
        if ($request->header('with_author') == 'true') {
            $books = $dl->listBooksWithAuthors();
        } else {
            $books = $dl->listBooksWithoutAuthors();
        }

        return $books;
    }

    public function listBooksPaginate(Request $request)
    {
        $dl = new DataLayer();
        if ($request->header('with_author') == 'true') {
            $books = $dl->listBooksWithAuthorsPaginate();
        } else {
            $books = $dl->listBooksWithoutAuthorsPaginate();
        }
        return $books;
    }

    public function listBooksPaginateAndSort(Request $request)
    {
        $dl = new DataLayer();
        if ($request->header('with_author') == 'true') {
            $books = $dl->listBooksWithAuthorsPaginateAndSorted($request->input('sort'));
        } else {
            $books = $dl->listBooksWithoutAuthorsPaginateAndSorted($request->input('sort'));
        }
        return $books;
    }

    public function listBooksWithResources(Request $request)
    {
        $dl = new DataLayer();
        $books = $dl->listBooksWithoutAuthorsPaginateAndSorted($request->input('sort'));
        
        return BookResource::collection($books);
    }

    public function listBookWithResponseHeaders(Request $request)
    {
        $dl = new DataLayer();
        $books = $dl->listBooksWithoutAuthorsPaginateAndSorted($request->input('sort'));
        
        return BookResource::collection($books)->response()->header('Owner', 'Devis');
    }

    public function addBook(Request $request)
    {
        $dl = new DataLayer();
        $data = $request->json()->all();

        if ($dl->checkEmail($data['email'])) {
            if ($dl->findAuthorByNames($data['author']['firstname'], $data['author']['lastname'])) {
                if ($dl->findBookByTitle($data['title'])) {
                    return response()->json(['Error' => 'Book already present in the database']);
                } else {
                    $author = $dl->getAuthorByName($data['author']['firstname'], $data['author']['lastname']);
                    $user = $dl->getUserID($data['email']);
                    $categories = array();
                    foreach($data['categories'] as $category_name)
                    {
                        $categories[] = $dl->getCategoryID($category_name)->id;
                    }
                    $dl->addBook($data['title'], $author->id, $categories, $user);
                    return response()->json(['Msg' => 'Book created']);
                }
            } else {
                return response()->json(['Error' => 'Author not found']);
            }
        } else {
            return response()->json(['Error' => 'Username not found']);
        }
    }

    public function listBooksByCategories(Request $request) 
    {
        $dl = new DataLayer();

        $books = $dl->getBooksByCategories();
        return $books;
    }
}
