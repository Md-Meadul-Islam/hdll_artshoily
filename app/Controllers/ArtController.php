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
        $data = [];
        $image_upload_dir = 'storage/arts/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

        foreach ($_POST as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
        if (!empty($_FILES['image']['name'])) {
            $image = [
                'name' => $_FILES['image']['name'],
                'type' => $_FILES['image']['type'],
                'tmp_name' => $_FILES['image']['tmp_name'],
                'error' => $_FILES['image']['error'],
                'size' => $_FILES['image']['size']
            ];
            $filename = $this->uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
            if (!$filename) {
                $_SESSION['error'][] = "Failed to upload image!";
                return 0;
            }
            $data['art_id'] = generateUId();
            $artists = json_decode($_POST['artists'], true);
            $data['artists'] = json_encode($artists);
            $data['image'] = $filename;
            $art = new Art();
            $res = $art->storeArt($data);
            if ($res['data']) {
                echo json_encode(['success' => true, 'message' => 'Art Inserted Successfully !', 'data' => $res['data']]);
            }
        }

    }
    public function loadLimitedEditionPrints()
    {
        header('Content-Type: application/json');
        $art = new Art();
        $arts = $art->limitedEdition();
        echo json_encode(['success' => true, 'data' => $arts]);
    }
    private function uploadFile($file, $upload_dir, $allowed_types, $max_size)
    {
        if (!file_exists('storage/arts')) {
            mkdir('storage/arts', 0777, true);
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "Error uploading file: " . $file['error'];
        }
        if (!in_array(mime_content_type($file['tmp_name']), $allowed_types)) {
            return "Invalid file type.";
        }
        if ($file['size'] > $max_size) {
            return "File size exceeds the allowed limit.";
        }
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = random_str(20) . "." . $extension;
        $file_path = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return $filename;
        } else {
            return false;
        }
    }
}