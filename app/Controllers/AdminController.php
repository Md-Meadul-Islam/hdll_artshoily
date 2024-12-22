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
    public function loadArtistsPaginate()
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $user = new User();
        $artists = $user->paginateArtist($page, $limit);
        echo json_encode(['success' => true, 'data' => $artists]);
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
        $user = new User();
        $artists = $user->artists();
        $arts = new Art();
        $art = $arts->view($artId);
        view('admin.copy-art-modal', ['artists' => $artists, 'art' => $art]);
    }
    public function loadCreateArtistsModal()
    {
        view('admin.add-artists-modal', );
    }
    public function loadFocusArtistsModal()
    {
        $user = new User();
        $artists = $user->artists();
        view('admin.focus-artists-modal', ['artists' => $artists]);
    }
}