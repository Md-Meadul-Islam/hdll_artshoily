<?php
namespace App\Controllers;

use App\Models\User;

class ArtistsController
{
    public function index()
    {
        view('artists');
    }
    public function view($a)
    {
        $user = new User();
        $artist = $user->get($a, 'artists');
        view('viewartists', ['artist' => $artist]);
    }
    public function getArtists()
    {
        header('Content-Type: application/json');
        $user = new User();
        $artists = $user->artists();
        if (!$artists) {
            echo json_encode(["success" => false, "message" => "No artists!"]);
            return 0;
        }
        echo json_encode(["success" => true, "data" => $artists]);
    }
    public function focusArtists()
    {
        header('Content-Type: application/json');
        $user = new User();
        $artists = $user->focusArtists();
        if (!$artists) {
            echo json_encode(["success" => false, "message" => "No artists!"]);
            return 0;
        }
        echo json_encode(["success" => true, "data" => $artists]);
    }
    public function storeArtist()
    {
        dd($_FILES);
    }
}