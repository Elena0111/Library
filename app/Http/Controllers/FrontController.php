<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\DataLayer;

class FrontController extends Controller
{
    public function getHome()
    {
        session_start();

        $language = App::getLocale();
        $dl = new DataLayer();
        $introduction = $dl->getTextForLanguage('introduction',$language);
        $citation = $dl->getTextForLanguage('citation',$language);
        $reference = $dl->getTextForLanguage('reference',$language);

        if (isset($_SESSION['logged'])) {
            return view('index')->with('logged', true)->with('loggedName', $_SESSION['loggedName'])->with('introduction',$introduction)->with('citation',$citation)->with('reference',$reference);
        } else {
            return view('index')->with('logged', false)->with('introduction',$introduction)->with('citation',$citation)->with('reference',$reference);
        }
    }
}
