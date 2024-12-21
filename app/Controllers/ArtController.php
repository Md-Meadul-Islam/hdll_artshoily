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
    public function storeArt()
    {
        // [name] => Baker Nash
        //     [artists] => dadfddaf3424
        //     [price] => 768
        //     [place] => Necessitatibus nulla neque dolorum sunt Nam nisi aut vel a commodo sit quos reiciendis
        //     [creationDate] => 23-Apr-2015
        //     [media] => Eligendi enim et laboris mollitia veritatis neque animi nihil rerum et ex cumque dolore
        //     [canvasType] => Tenetur sunt sint non dolor
        //     [size] => Nobis dolorem corporis placeat in dolore fugit incididunt similique maiores quos atque dolore faci
        //     [frame] => Provident repellendus Illum animi rem lorem omnis consequat Consequatur Laborum qui harum maxi
        //     [currency] => BDT
        //     [availability] => available
        //     [description] => Cupidi
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
        $name = sanitizeInput($_POST['name']);
        $artists = json_encode($_POST['artists']);
        $price = sanitizeInput($_POST['price']);
        dd($_POST);
    }
    public function loadLimitedEditionPrints()
    {
        header('Content-Type: application/json');
        $art = new Art();
        $arts = $art->limitedEdition();
        echo json_encode(['success' => true, 'data' => $arts]);
    }
}