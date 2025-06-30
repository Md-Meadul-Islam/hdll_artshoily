<?php
namespace App\Controllers;

use App\Models\Art;
use App\Models\User;

class AdminController
{
    public function index()
    {
        view('admin/index');
    }
    public function loadArtsPaginate()
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $art = new Art();
        $arts = $art->arts($page, $limit);
        echo json_encode(['success' => true, 'data' => $arts]);
    }
    public function loadCreateArtModal()
    {
        $user = new User();
        $artists = $user->artists();
        view('admin.add-art-modal', ['artists' => $artists]);
    }
    public function loadCopyArtModal()
    {
        $artId = $_GET['dataId'];
        $mode = $_GET['mode'];
        $user = new User();
        $artists = $user->artists();
        $arts = new Art();
        $art = $arts->view($artId);
        view('admin.copy-art-modal', ['artists' => $artists, 'art' => $art, 'mode' => $mode]);
    }
    public function updateRowOrder(){
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);
        $order = $data['order'] ?? [];
        $tableName = sanitizeInput($data['arrayName'] ?? '');
        // List of allowed tables
        $myTables = [
            "focusArtists" => "focus_artists",
            "users" =>"users",
            "arts" => "arts",
            "blogs" => "blogs"
        ];
        if (!array_key_exists($tableName, $myTables)) {
            echo json_encode(['success' => false, 'message' => 'Table Not Found!']);
            return;
        }
        // Use the actual DB table name
        $dbTableName = $myTables[$tableName];

        $user = new User();
        $user->updateTableOrder($dbTableName, $order);
        echo json_encode(['success' => true, 'message' => 'Order Updated !']);
    }
}