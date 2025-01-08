<?php
namespace App\Controllers;

use App\Models\Art;

class SculptureController
{
    public function index()
    {
        view('sculptures');
    }
}