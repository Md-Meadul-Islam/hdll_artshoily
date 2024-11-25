<?php
namespace App\Controllers;

use App\Models\Art;

class ArtController
{
    public function index()
    {
        view('art-gallery');
    }
    public function view($a)
    {
        $arts = new Art();
        if ($a) {
            $art = $arts->view($a);
            view('viewart', ['art' => $art]);
        }
    }
}