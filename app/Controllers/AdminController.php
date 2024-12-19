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
        view('admin.create-art-modal', ['artists' => $artists]);
    }
}