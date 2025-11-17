<?php

namespace App\Controllers;

class Spalten extends BaseController
{
    public function index() : string
    {
        return view('spalten/spalten');
    }

    public function new() : string {
        return view('spalten/new');
    }
}
