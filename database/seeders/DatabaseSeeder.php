<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Address;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\DataLayer;
use App\Models\Label;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->populateDB();
    }

    private function populateDB()
    {
        User::create([
            'name' => 'Devis',
            'email' => 'devis.bianchini@unibs.it',
            'password' => md5('bianchini')
        ]);

        User::create([
            'name' => 'Alessandro',
            'email' => 'alessandro.bianchini@unibs.it',
            'password' => md5('bianchini')
        ]);

        $dl = new DataLayer();
        $user1 = $dl->getUserID('devis.bianchini@unibs.it');
        $user2 = $dl->getUserID('alessandro.bianchini@unibs.it');

        Author::factory()->count(100)->create(['user_id' => $user1])->each(function ($author) {
            Address::factory()->count(1)->create(['author_id' => $author->id]);
        });

        $authors_list1 = json_decode($dl->listAuthors($user1));
        for ($i = 0; $i < 50; $i++) {
            $author = $authors_list1[array_rand($authors_list1)];
            Book::factory()->count(1)->create(['author_id' => $author->id, 'user_id' => $user1]);
        }

        Author::factory()->count(100)->create(['user_id' => $user2])->each(function ($author) {
            Address::factory()->count(1)->create(['author_id' => $author->id]);
        });

        $authors_list2 = json_decode($dl->listAuthors($user2));
        for ($i = 0; $i < 50; $i++) {
            $author = $authors_list2[array_rand($authors_list2)];
            Book::factory()->count(1)->create(['author_id' => $author->id, 'user_id' => $user2]);
        }

        $CategoryOptions = ['Biografia','Cronaca','Epica','Erotico','Fantascienza',
        'Fantasy','Giallo','Gotico','Orrore','Poesie','Saggio','Sentimentale']; 
        foreach($CategoryOptions as $option)
        {
            Category::create(['name' => $option]);
        }

        $categories_list = json_decode(Category::all());
        $books_list = json_decode(Book::all());

        foreach ($books_list as $book)
        {
            for ($j=0; $j < 3; $j++) {
                // randomly select a category
                $category = $categories_list[array_rand($categories_list)];
                DB::table('book_category')->insert(['book_id' => $book->id, 'category_id' => $category->id]);
            }
        }

        // Home page contents (multi-language)
        $introduction_it = "Un semplicissimo esempio di sito web realizzato 
            durante il corso di Programmazione Web e Servizi 
            Digitali. Il sito riporta l'elenco dei libri che 
            sto leggendo o che ho letto, e la lista degli 
            autori che hanno popolato le mie letture e la mia 
            fantasia. Il sito web continuerà a crescere durante 
            questo semestre, completandosi di volta in volta 
            grazie all'applicazione delle tecnologie web che 
            verranno presentate nel corso. Buon divertimento!";
        $introduction_en = "A very simple example of web site implemented 
            during the Web Programming and Digital Services course. 
            The web site contains the list of books I'm reading and
            I've read, and the list of authors who populated my readings
            and my fantasy. The web site will keep growing during this
            semester, completing itself step by step thanks to the 
            application of web technologies that will be presented in
            the course. Enjoy!";
        $citation_it = "Semina un atto, e raccogli un'abitudine; semina 
            un'abitudine, e raccogli un carattere; semina un 
            carattere, e raccogli un destino.";
        $citation_en = "Seed an action, and you will gather an inclination;
            seed an habit, and you will collect a personality; seed a
            personality, and you will collect a destiny.";
        $reference_it = "Il pensiero del Buddha";
        $reference_en = "Buddha's thought";

        Label::create([
            'label' => 'introduction',
            'it' => $introduction_it,
            'en' => $introduction_en
        ]);

        Label::create([
            'label' => 'citation',
            'it' => $citation_it,
            'en' => $citation_en
        ]);

        Label::create([
            'label' => 'reference',
            'it' => $reference_it,
            'en' => $reference_en
        ]);
        // Label::factory()->count(1)->create(['label' => 'introduction']);
        // Label::factory()->count(1)->create(['label' => 'citation']);
        // Label::factory()->count(1)->create(['label' => 'reference']);
    }
}
