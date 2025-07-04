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
    public function uploadFile(){
        $response = ['success' => false];
        $image_upload_dir = 'storage/blogs/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!empty($_FILES['image']['name'])) {
            $image = [
                'name' => $_FILES['image']['name'],
                'type' => $_FILES['image']['type'],
                'tmp_name' => $_FILES['image']['tmp_name'],
                'error' => $_FILES['image']['error'],
                'size' => $_FILES['image']['size']
            ];
            $filename = uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
            if (!$filename) {
                $response['error'] = 'Upload failed';
                $_SESSION['error'][] = "Failed to upload image!";
                return 0;
            }
            $response['success'] = true;
            $response['url'] = $filename;
        }
        echo json_encode($response);
    }
    public function deleteFile(){
        $response = ['success' => false];
        if (isset($_POST['image_url'])) {
            $filePath = $_POST['image_url'];
            $response = deleteFile($filePath);
        } else {
            $response['error'] = 'Image URL not provided';
        }
        echo json_encode($response);
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