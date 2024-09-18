<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use Illuminate\Support\Facades\Redirect;

class AuthorController extends Controller
{
    public function index()
    {
        $dl = new DataLayer();
        $userID = $dl->getUserID($_SESSION["loggedEmail"]);
        $authors = $dl->listAuthors($userID);
        return view('author.authors')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with("authors_list",$authors);
    }

    public function create()
    {
        return view('author.editAuthor')->with('logged', true)->with('loggedName', $_SESSION["loggedName"]);
    }

    public function store(Request $request)
    {
        $dl = new DataLayer();
        $userID = $dl->getUserID($_SESSION["loggedEmail"]);
        $dl->addAuthor($request->input('firstName'),$request->input('lastName'),$userID);
        return Redirect::to(route('author.index'));
    }

    public function show() {
        // NOT USED
    }

    public function edit($id) {
        $dl = new DataLayer();
        $author = $dl->findAuthorById($id);

        return view('author.editAuthor')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with('author',$author);
    }

    public function update(Request $request, $id) {
        $dl = new DataLayer();
        $dl->editAuthor($id, $request->input('firstName'), $request->input('lastName'));
        return Redirect::to(route('author.index'));
    }

    public function destroy($id) {

        $dl = new DataLayer();
        $author = $dl->findAuthorById($id);
        if ($author !== null) {
            $dl->deleteAuthor($id);
            return Redirect::to(route('author.index'));
        } else {
            return view('author.deleteErrorPage');
        }
    }

    public function confirmDestroy($id) {
        $dl = new DataLayer();
        $author = $dl->findAuthorById($id);
        if ($author !== null) {
            return view('author.deleteAuthor')->with('logged', true)->with('loggedName', $_SESSION["loggedName"])->with('author', $author);
        } else {
            return view('author.deleteErrorPage')->with('logged', true)->with('loggedName', $_SESSION["loggedName"]);
        }
    }

    public function ajaxCheckForAuthors(Request $request) {
        
        $dl = new DataLayer();
        
        if($dl->findAuthorByNames($request->input('firstName'), $request->input('lastName')))
        {
            $response = array('found'=>true);
        } else {
            $response = array('found'=>false);
        }
        return response()->json($response);
    }

    public function ajaxCheckForAuthorsUpdated(Request $request) {
        
        $dl = new DataLayer();
        
        /* 
        Return TRUE (found) only if the author already exists, but for a different author ID 
        (otherwise, we are leaving unchanged the first and last names for the current author that is being updated and this is allowed)
        */
        if($dl->findAuthorByNamesForUpdate($request->input('firstName'), $request->input('lastName'), $request->input('id')))
        {
            $response = array('found'=>true);
        } else {
            $response = array('found'=>false);
        }
        return response()->json($response);
    }
}
