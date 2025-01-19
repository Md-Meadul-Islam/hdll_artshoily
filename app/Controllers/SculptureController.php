<?php
namespace App\Controllers;

use App\Models\Art;
use App\Models\Sculpture;
use App\Models\User;

class SculptureController
{
    public function index()
    {
        $sculpture = new Sculpture();
        $sculptures = $sculpture->sculptures(1);
        view('sculptures', ['sculptures' => $sculptures]);
    }
    public function homeSculpture()
    {
        header('Content-Type: application/json');
        $sculp = new Sculpture();
        $sculps = $sculp->homeSculpture(3);
        echo json_encode(['success' => true, 'data' => $sculps]);
    }
    public function loadSculpPaginate()
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $sculpture = new Sculpture();
        $sculptures = $sculpture->sculptures($page, $limit);
        echo json_encode(['success' => true, 'data' => $sculptures]);
    }
    public function view($sid)
    {
        $sculps = new Sculpture();
        if ($sid) {
            $sculp = $sculps->view($sid);
            view('viewart', ['art' => $sculp]);
        }
    }
    public function loadCreateSculpModal()
    {
        $user = new User();
        $artists = $user->artists();
        $mode = 'add';
        view('admin.sculpture-modal', ['artists' => $artists, 'mode' => $mode]);
    }
    public function loadCopySculpModal()
    {
        $sculpId = $_GET['dataId'];
        $mode = $_GET['mode'];
        $user = new User();
        $artists = $user->artists();
        $sculps = new Sculpture();
        $sculp = $sculps->view($sculpId);
        view('admin.sculpture-modal', ['artists' => $artists, 'sculpture' => $sculp, 'mode' => $mode]);
    }
    public function store()
    {
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/sculptures/';
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
                $_SESSION['error'][] = "Failed to upload image!";
                return 0;
            }
            $data['sculpture_id'] = generateUId();
            $artists = json_decode($_POST['artists'], true);
            $data['artists'] = json_encode($artists);
            $data['image'] = $filename;
            $sculpture = new Sculpture();
            $res = $sculpture->store($data);
            if ($res['data']) {
                echo json_encode(['success' => true, 'message' => 'Sculpture Inserted Successfully !', 'data' => $res['data']]);
            }
        }
    }
    public function update()
    {
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/sculptures/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

        $previousImage = $data['previousImage'] ?? "";
        $sculpImgName = '';

        if (empty($data['sculpId'])) {
            echo json_encode(['success' => false, 'message' => 'Sculpture ID is required!']);
            return;
        }
        if (!$previousImage && empty($_FILES['image']['name'])) {
            echo json_encode(['success' => false, 'message' => 'Sculpture image is required!']);
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
            $sculpImgName = uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
        } else {
            $sculpImgName = explode('/storage/sculptures/', $previousImage)[1];
        }
        $artists = json_decode($_POST['artists'], true);
        $data['artists'] = json_encode($artists);
        $data['image'] = $sculpImgName;
        try {
            $sculptures = new Sculpture();
            $res = $sculptures->update($data);
            if ($res['data']) {
                echo json_encode(['success' => true, 'message' => 'Sculpture updated successfully!', 'data' => $res['data']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Sculpture update failed!']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['success' => false, 'message' => 'Error updating Sculpture: ' . $th->getMessage()]);
        }

    }
    public function delete()
    {
        header('Content-type: application/json');
        if (empty($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Something Wrong !']);
            return 0;
        }
        $id = sanitizeInput($_POST['id']);
        $sculps = new Sculpture();
        $res = $sculps->delete($id);
        if ($res['success']) {
            echo json_encode(['success' => true, 'message' => 'Sculpture Deleted Successfully !']);
            return 0;
        } else {
            echo json_encode(['success' => false, 'message' => $res['message']]);
        }
    }
}