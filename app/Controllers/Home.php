<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index() : string
    {
        return view('startseite');
    }

    public function spalten() : string
    {
        return view('spalten');
    }
}
