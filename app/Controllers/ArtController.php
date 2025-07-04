<?php
namespace App\Controllers;

use App\Models\Art;

class ArtController
{
    public function index()
    {
        view('art-gallery');
    }
    public function paginatedArts(){
        header('Content-type: application/json');
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 20;

        $filters = [
            'art_name' => $_GET['art_name'] ?? null,
            'artist_name' => $_GET['artist_name'] ?? null,
            'price' => $_GET['price'] ?? null,
        ];

        $art = new Art();
        $arts = $art->arts($page, $limit, $filters);
        echo json_encode(['success' => true, 'data' => $arts]);
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
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/arts/';
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
    public function updateArt()
    {
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/arts/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

        $previousImage = $data['previousImage'] ?? "";
        $artImgName = '';

        if (empty($data['artId'])) {
            echo json_encode(['success' => false, 'message' => 'Art ID is required!']);
            return;
        }
        if (!$previousImage && empty($_FILES['image']['name'])) {
            echo json_encode(['success' => false, 'message' => 'Art image is required!']);
            return;
        }
        if (!empty($_FILES['image']['name'])) {
            $image = [
                'name' => $_FILES['image']['name'],
                'type' => $_FILES['image']['type'],
                'tmp_name' => $_FILES['image']['tmp_name'],
                'error' => $_FILES['image']['error'],
                'size' => $_FILES['image']['size']
            ];
            $artImgName = $this->uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
        } else {
            $artImgName = explode('/storage/arts/', $previousImage)[1];
        }
        $artists = json_decode($_POST['artists'], true);
        $data['artists'] = json_encode($artists);
        $data['image'] = $artImgName;
        try {
            $arts = new Art();
            $res = $arts->updateArt($data);
            if ($res['data']) {
                echo json_encode(['success' => true, 'message' => 'Art updated successfully!', 'data' => $res['data']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Art update failed!']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['success' => false, 'message' => 'Error updating art: ' . $th->getMessage()]);
        }

    }
    public function loadLimitedEditionPrints()
    {
        header('Content-Type: application/json');
        $art = new Art();
        $arts = $art->limitedEdition();
        echo json_encode(['success' => true, 'data' => $arts]);
    }
    public function delete()
    {
        header('Content-type: application/json');
        if (empty($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Something Wrong !']);
            return 0;
        }
        $id = sanitizeInput($_POST['id']);
        $arts = new Art();
        $res = $arts->delete($id);
        if ($res['success']) {
            echo json_encode(['success' => true, 'message' => 'Art Deleted Successfully !']);
            return 0;
        } else {
            echo json_encode(['success' => false, 'message' => $res['message']]);
        }
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