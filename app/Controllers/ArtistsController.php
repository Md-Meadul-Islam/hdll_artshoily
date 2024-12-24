<?php
namespace App\Controllers;

use App\Models\Art;
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
        $page = sanitizeInput($_GET['page']);
        $limit = sanitizeInput($_GET['limit']);
        $artists = $user->artists($page, $limit);
        if (!$artists) {
            echo json_encode(["success" => false, "message" => "No artists!"]);
            return 0;
        }
        echo json_encode(["success" => true, "data" => $artists]);
    }
    public function getArtOfArtist()
    {
        header('Content-type: application/json');
        if (!isset($_GET['artistId']) && !empty($_GET['artistId'])) {
            return 0;
        }
        $artistId = sanitizeInput($_GET['artistId']);
        $art = new Art();
        $arts = $art->getArtOfArtist($artistId, 9);
        if ($arts) {
            echo json_encode(['success' => true, 'data' => $arts]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No Arts Found !']);
        }
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