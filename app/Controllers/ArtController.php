<?php
namespace App\Controllers;

use App\Models\Art;

class ArtController
{
    public function index()
    {
        $art = new Art();
        $arts = $art->arts(1);
        view('art-gallery', ['arts' => $arts]);
    }
    public function view($a)
    {
        $arts = new Art();
        if ($a) {
            $art = $arts->view($a);
            view('viewart', ['art' => $art]);
        }
    }
    public function moreFromArtist()
    {
        header('Content-type: application/json');
        $u = $_GET['user_id'];
        $a = $_GET['art_id'];
        $arts = new Art();
        $suggestions = $arts->moreFromArtist($a, $u, 6);
        if (!empty($suggestions)) {
            echo json_encode(['success' => true, 'data' => $suggestions]);
        } else {
            echo json_encode(['success' => false, 'message' => "No Data"]);
        }

    }
    public function loadLimitedEditionPrints()
    {
        header('Content-Type: application/json');
        $art = new Art();
        $arts = $art->limitedEdition();
        echo json_encode(['success' => true, 'data' => $arts]);
    }
}