<?php
namespace App\Controllers;

use App\Models\Art;
use App\Models\Search;
use App\Models\User;

class HomeController
{
    public function index()
    {
        view('index');
    }
    public function searchKey()
    {
        $search = new Search();
        $keys = $search->keys();
        echo json_encode(['success' => true, 'searchkey' => $keys]);
    }
    public function search($key)
    {
        $key = sanitizeInput($key);
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = new Search();
        $article = $search->search($key, $page);
        if (!empty($article)) {
            view('searchedarticle', ['article' => $article]);
        } else {
            echo 'N';
        }
    }
    public function storeKey()
    {
        $key = sanitizeInput($_POST['key']);
        $is_find = sanitizeInput($_POST['status']);
        $search = new Search();
        $search->storeKey($key, $is_find);
    }
    public function searchCategory($key)
    {
        $key = sanitizeInput($key);
        $is_find = 0;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = new Search();
        $article = $search->searchCategory($key, $page);
        if (!empty($article)) {
            view('searchedarticle', ['article' => $article]);
            $is_find = 1;
        } else {
            echo 'N';
        }
        $search->storeKey($key, $is_find);
    }
    public function terms()
    {
        view('terms');
    }
    public function privacy()
    {
        view('privacy');
    }
    public function contact()
    {
        view('contact');
    }
    public function about()
    {
        view('about');
    }
    public function cookie()
    {
        view('cookie');
    }
    public function notFound()
    {
        return require './pages/components/404.php';
    }
    public function accessDeined()
    {
        return require './pages/components/503.php';
    }
    public function logout()
    {
        unset($_SESSION['temp']);
        session_destroy();
        header('Location: /');
        exit();
    }
}