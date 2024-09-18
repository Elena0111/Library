<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    public function index()
    {
        $dl = new DataLayer();
        $userID = $dl->getUserID($_SESSION["loggedEmail"]);
        $books = $dl->listBooks($userID);
        return view('book.books')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with('books_list',$books);
    }

    public function create()
    {
        $dl = new DataLayer();
        $userID = $dl->getUserID($_SESSION["loggedEmail"]);
        $authors_list = $dl->listAuthors($userID);
        $categories = $dl->getAllCategories();

        return view('book.editBook')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with('authorList', $authors_list)->with('categories',$categories);
    }

    public function store(Request $request)
    {
        $dl = new DataLayer();
        $userID = $dl->getUserID($_SESSION["loggedEmail"]);
        $dl->addBook($request->input('title'), $request->input('author_id'), $request->input('category_id'),$userID);

        return Redirect::to(route('book.index'));
    }

    public function show()
    {
        // NOT USED 
    }

    public function edit($id)
    {
        $dl = new DataLayer();
        $userID = $dl->getUserID($_SESSION["loggedEmail"]);
        $authors_list = $dl->listAuthors($userID);
        $book = $dl->findBookById($id);
        $categories = $dl->getAllCategories();

        return view('book.editBook')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with('authorList', $authors_list)->with('book', $book)->with('categories',$categories);
    }

    public function update(Request $request, $id)
    {
        $dl = new DataLayer();
        $dl->editBook($id, $request->input('title'), $request->input('author_id'), $request->input('category_id'));
        return Redirect::to(route('book.index'));
    }

    public function destroy($id)
    {
        $dl = new DataLayer();
        $book = $dl->findBookById($id);
        if ($book !== null) {
            $dl->deleteBook($id);
            return Redirect::to(route('book.index'));
        } else {
            return view('book.deleteErrorPage');
        }
        
    }

    public function confirmDestroy($id)
    {
        $dl = new DataLayer();
        $book = $dl->findBookById($id);
        if ($book !== null) {
            return view('book.deleteBook')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with('book', $book);
        } else {
            return view('book.deleteErrorPage')->with('logged', true)->with('loggedName', $_SESSION["loggedName"]);
        }
    }

    public function ajaxCheckForBooks(Request $request) {
        
        $dl = new DataLayer();
        
        if($dl->findBookByTitle($request->input('title')))
        {
            $response = array('found'=>true);
        } else {
            $response = array('found'=>false);
        }
        return response()->json($response);
    }

    public function ajaxCheckForBooksUpdated(Request $request) {
        
        $dl = new DataLayer();
    
        /* 
        Return TRUE (found) only if the book title already exists, but for a different book ID 
        (otherwise, we are leaving unchanged the title for the current book that is being updated and this is allowed)
        */
        
        if($dl->findBookByTitleForUpdate($request->input('title'),$request->input('id')))
        {
            $response = array('found'=>true);
        } else {
            $response = array('found'=>false);
        }
        return response()->json($response);
    }
}
