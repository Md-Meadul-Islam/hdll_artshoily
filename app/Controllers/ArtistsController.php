<?php
namespace App\Controllers;

use App\Models\User;

class ArtistsController
{
    public function index()
    {
        view('artists');
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
}