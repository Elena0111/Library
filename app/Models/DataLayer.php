<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{
    public function listAuthors($user) {        
        $authors = Author::where('user_id',$user)->orderBy('lastname','asc')->orderBy('firstname','asc')->get();
        return $authors;
    }

    public function listBooks($user) {        
        $books = Book::where('user_id',$user)->orderBy('title','asc')->get();
        return $books;
    }

    public function findAuthorById($id) {
        return Author::find($id);
    }

    public function deleteAuthor($id) {
        $author = Author::find($id);
        $author->address->delete();
        $author->delete();
    }

    public function editAuthor($id, $first_name, $last_name) {
        $author = Author::find($id);
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->save();
        // massive update (only with fillable property enabled on Author): 
        // Author::find($id)->update(['firstname' => $first_name, 'lastname' => $last_name]);
    }

    public function addAuthor($first_name, $last_name, $user) {
        $author = new Author;
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->user_id = $user;
        $author->save();

        //use the factory to randomly generate an address
        Address::factory()->count(1)->create(['author_id' => $author->id]);

        // massive creation (only with fillable property enabled on Author):
        // Author::create(['firstname' => $first_name, 'lastname' => $last_name, 'user_id' => $user]);
    }

    public function findBookById($id) {
        return Book::find($id);
    }

    public function deleteBook($id) {
        $book = Book::find($id);
        $categories = $book->categories;
        foreach($categories as $cat) {
            $book->categories()->detach($cat->id);
        }
        $book->delete();
    }

    public function editBook($id, $title, $author_id, $categories) {
        $book = Book::find($id);
        $book->title = $title;
        $book->author_id = $author_id;
        $book->save();

        // Cancel the previous list of categories
        $prevCategories = $book->categories;
        foreach($prevCategories as $prevCat) {
            $book->categories()->detach($prevCat->id);
        }

        // Update the list of categories
        foreach($categories as $cat) {
            $book->categories()->attach($cat);
        }
        // massive update (only with fillable property enabled on Book): 
        // Book::find($id)->update(['title' => $title, 'author_id' => $author_id]);
    }

    public function addBook($title, $author_id, $categories, $user) {
        $book = new Book;
        $book->title = $title;
        $book->author_id = $author_id;
        $book->user_id = $user;
        $book->save();
        foreach($categories as $cat) {
            $book->categories()->attach($cat);
        }
        // massive creation (only with fillable property enabled on Book):
        // Book::create(['title' => $title, 'author_id' => $author_id, 'user_id' => $user]);
    }

    public function getAllCategories() {
        return Category::orderBy('name','asc')->get();
    }

    public function validUser($username, $password) {
        $users = User::where('email',$username)->get(['password']);
        
        if(count($users) == 0)
        {
            return false;
        }
        
        return (md5($password) == ($users[0]->password));
    }

    public function addUser($name, $password, $email) {
        $user = new User();
        $user->name = $name;
        $user->password = md5($password);
        $user->email = $email;
        $user->save();
    }
    
    public function getUserID($username) {
        $users = User::where('email',$username)->get(['id']);
        return $users[0]->id;
    }

    public function getUserName($email) {
        $users = User::where('email',$email)->get();
        return $users[0]->name;
    }

    public function findBookByTitle($title) {
        $books = Book::where('title', $title)->get();
        
        if (count($books) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function findBookByTitleForUpdate($title,$bookID) {
        $books = Book::where('title', $title)->get();
        
        if (count($books) == 0) {
            return false;
        } else {
            if($books[0]->id == $bookID) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function findAuthorByNames($first_name, $last_name) {
        //$authors = DB::table('author')->where(['firstname' => $first_name,'lastname' => $last_name]);
        //$authors = Author::where('firstname', $first_name)->get();
        
        $authors = DB::select('select * from author where (firstname = ? AND lastname = ?)',[$first_name, $last_name]);
        if (count($authors) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function findAuthorByNamesForUpdate($first_name, $last_name, $authorID) {
        //$authors = DB::table('author')->where(['firstname' => $first_name,'lastname' => $last_name]);
        //$authors = Author::where('firstname', $first_name)->get();
        
        $authors = DB::select('select * from author where (firstname = ? AND lastname = ?)',[$first_name, $last_name]);
        if (count($authors) == 0) {
            return false;
        } else {
            if($authors[0]->id == $authorID) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function checkEmail($email) {
        $users = User::where('email',$email)->get();
        if (count($users) == 0) {
            return false;
        } else {
            return true;
        }
    }

    // Methods for APIs
    public function listBooksWithAuthors()
    {
        $books = DB::table('book')->join('author', 'author_id', '=', 'author.id')
            ->select('book.*', 'author.firstname', 'author.lastname')->get();

        return $books;
    }

    public function listBooksWithoutAuthors()
    {
        $books = Book::all();

        return $books;
    }

    public function listBooksWithAuthorsPaginate()
    {
        $blockFactor = 10;
        $books = DB::table('book')->join('author', 'author_id', '=', 'author.id')
            ->select('book.*', 'author.firstname', 'author.lastname')->paginate($blockFactor);

        return $books;
    }

    public function listBooksWithoutAuthorsPaginate()
    {
        $blockFactor = 10;
        $books = Book::paginate($blockFactor);

        return $books;
    }

    public function listBooksWithAuthorsPaginateAndSorted($sortColumn)
    {
        // Return paginated and multi-sorted results
        $blockFactor = 10;
        $sorts = explode(',', $sortColumn);
        $query = DB::table('book')->join('author', 'author_id', '=', 'author.id')
            ->select('book.*', 'author.firstname', 'author.lastname');
        foreach ($sorts as $sortCriterium) {
            $sortDirection = str_starts_with($sortCriterium, '-') ? 'desc' : 'asc';
            $sortCriterium = ltrim($sortCriterium, '-');
            $query->orderBy($sortCriterium, $sortDirection);
        }
        $books = $query->paginate($blockFactor);

        return $books;
    }

    public function listBooksWithoutAuthorsPaginateAndSorted($sortColumn)
    {
        // Return paginated and multi-sorted results
        $blockFactor = 10;
        $sorts = explode(',', $sortColumn);
        $query = Book::query();
        foreach ($sorts as $sortCriterium) {
            $sortDirection = str_starts_with($sortCriterium, '-') ? 'desc' : 'asc';
            $sortCriterium = ltrim($sortCriterium, '-');
            $query->orderBy($sortCriterium, $sortDirection);
        }
        $books = $query->paginate($blockFactor);

        return $books;
    }

    public function getAuthorByName($first_name, $last_name)
    {
        $authors = DB::select('select * from author where (firstname = ? AND lastname = ?)', [$first_name, $last_name]);
        
        return $authors[0];
    }

    public function getCategoryID($category_name) 
    {
        $category = Category::where('name',$category_name)->get();
        return $category[0];
    }

    public function getBooksByCategories()
    {
        $books = DB::select('select name as Category, count(book.id) as BooksNum from book, book_category, category where (book.id=book_category.book_id AND category.id=book_category.category_id) GROUP BY category.name');

        return $books;
    }

    // Multi-language website
    public function getTextForLanguage($label, $language)
    {
        $text = Label::where('label',$label)->get($language);
        
        return $text[0][$language];
    }
}