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
        $artist = $user->get($a);
        view('viewartists', ['artist' => $artist]);
    }
    public function getArtists()
    {
        header('Content-Type: application/json');
        $user = new User();
        $page = sanitizeInput($_GET['page']);
        $limit = sanitizeInput($_GET['limit']);
        $artists = $user->paginateArtist($page, $limit);
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
    public function paginatedFocusArtists(){
        header('Content-Type: application/json');
        $page = sanitizeInput($_GET['page']);
        $limit = sanitizeInput($_GET['limit']);
        $user = new User();
        $artists = $user->paginatedFocusArtists($page, $limit);
           if (!$artists) {
            echo json_encode(["success" => false, "message" => "No Artists In Focus !"]);
            return 0;
        }
        echo json_encode(["success" => true, "data" => $artists]);
    }
    public function storeFocusArtists(){
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $artists = json_decode($_POST['artists'], true);
        $data['artists'] = $artists;
        $user = new User();
        $res = $user->storeFocusArtists($data);
       if (!empty($res)) {
            echo json_encode([
                'success' => true,
                'message' => 'Artists Inserted Successfully !',
                'data' => $res
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No New Artists Were Inserted !',
                'data' => []
            ]);
        }
    }
    public function deleteFocusArtists(){
        header('Content-Type: application/json');
        $user_id = sanitizeInput($_POST['id']);
        $user = new User();
        $res= $user->deleteFocusArtists($user_id);
        if ($res["success"]) {
            echo json_encode(["success" => true, "message" => $res["message"]]);
            return 0;
        }
        echo json_encode(["success" => false, "message"=>$res['message']]);
    }
}