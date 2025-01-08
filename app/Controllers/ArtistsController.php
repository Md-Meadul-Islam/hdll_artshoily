<?php
namespace App\Controllers;

use App\Models\Art;
use App\Models\User;

class ArtistsController
{
    public function index()
    {
        view('artists');
    }
    public function view($a)
    {
        $user = new User();
        $artist = $user->get($a, 'artists');
        view('viewartists', ['artist' => $artist]);
    }
    public function getArtists()
    {
        header('Content-Type: application/json');
        $user = new User();
        $page = sanitizeInput($_GET['page']);
        $limit = sanitizeInput($_GET['limit']);
        $artists = $user->paginateArtist($page, $limit);
        if (!$artists) {
            echo json_encode(["success" => false, "message" => "No artists!"]);
            return 0;
        }
        echo json_encode(["success" => true, "data" => $artists]);
    }
    public function getArtOfArtist()
    {
        header('Content-type: application/json');
        if (!isset($_GET['artistId']) && !empty($_GET['artistId'])) {
            return 0;
        }
        $artistId = sanitizeInput($_GET['artistId']);
        $art = new Art();
        $arts = $art->getArtOfArtist($artistId, 9);
        if ($arts) {
            echo json_encode(['success' => true, 'data' => $arts]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No Arts Found !']);
        }
    }
    public function focusArtists()
    {
        header('Content-Type: application/json');
        $user = new User();
        $artists = $user->focusArtists();
        if (!$artists) {
            echo json_encode(["success" => false, "message" => "No artists!"]);
            return 0;
        }
        echo json_encode(["success" => true, "data" => $artists]);
    }

    public function artistView()
    {
        view('auth.artists');
    }
    public function storeArtist()
    {
        header("Content-Type: application/json");
        $data = [];
        $image_upload_dir = 'storage/artists/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

        foreach ($_POST as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
        $profilePhotoFilename = '';
        $coverPhotoFilename = '';
        if (!empty($_FILES['images']['name'][0])) {
            $profilePhoto = [
                'name' => $_FILES['images']['name'][0],
                'type' => $_FILES['images']['type'][0],
                'tmp_name' => $_FILES['images']['tmp_name'][0],
                'error' => $_FILES['images']['error'][0],
                'size' => $_FILES['images']['size'][0]
            ];
            $profilePhotoFilename = uploadFile($profilePhoto, $image_upload_dir, $allowed_image_types, $image_max_size);
            if (!$profilePhotoFilename) {
                $_SESSION['error'][] = "Failed to upload image!";
                return 0;
            }
        }
        if (!empty($_FILES['images']['name'][1])) {
            $coverPhoto = [
                'name' => $_FILES['images']['name'][1],
                'type' => $_FILES['images']['type'][1],
                'tmp_name' => $_FILES['images']['tmp_name'][1],
                'error' => $_FILES['images']['error'][1],
                'size' => $_FILES['images']['size'][1]
            ];
            $coverPhotoFilename = uploadFile($coverPhoto, $image_upload_dir, $allowed_image_types, $image_max_size);
        }
        if (empty($coverPhotoFilename)) {
            $coverPhotoFilename = "storage/artists/default-cover.jpg";
        }

        $data['user_id'] = generateUId();
        $data['userphoto'] = $profilePhotoFilename;
        $data['coverphoto'] = $coverPhotoFilename;
        $user = new User();
        $res = $user->storeArtists($data);
        $newArtist = ['user_id' => $data['user_id'], 'first_name' => $data['fname'], 'last_name' => $data['lname'], 'userphoto' => $data['userphoto'], 'coverphoto' => $data['coverphoto'], 'cr_at' => 'now'];
        if ($res) {
            echo json_encode(['success' => true, 'message' => 'Artists Added Successfully !', 'data' => $newArtist]);

        }
    }
    public function updateArtist()
    {
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/artists/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

        $profilePhotoFilename = '';
        $coverPhotoFilename = '';
        $previousUserImage = $data['previousUserImage'] ?? "";
        $previousCoverImage = $data['previousCoverImage'] ?? "";
        if (!$previousUserImage && !$previousCoverImage) {
            if (!empty($_FILES['images']['name'][0])) {
                $profilePhoto = [
                    'name' => $_FILES['images']['name'][0],
                    'type' => $_FILES['images']['type'][0],
                    'tmp_name' => $_FILES['images']['tmp_name'][0],
                    'error' => $_FILES['images']['error'][0],
                    'size' => $_FILES['images']['size'][0]
                ];
                $profilePhotoFilename = uploadFile($profilePhoto, $image_upload_dir, $allowed_image_types, $image_max_size);
                if (!$profilePhotoFilename) {
                    $_SESSION['error'][] = "Failed to upload image!";
                    return 0;
                }
            }
            if (!empty($_FILES['images']['name'][1])) {
                $coverPhoto = [
                    'name' => $_FILES['images']['name'][1],
                    'type' => $_FILES['images']['type'][1],
                    'tmp_name' => $_FILES['images']['tmp_name'][1],
                    'error' => $_FILES['images']['error'][1],
                    'size' => $_FILES['images']['size'][1]
                ];
                $coverPhotoFilename = uploadFile($coverPhoto, $image_upload_dir, $allowed_image_types, $image_max_size);
            }
        } else if ($previousUserImage && !$previousCoverImage) {
            if (!empty($_FILES['images']['name'][0])) {
                $profilePhoto = [
                    'name' => $_FILES['images']['name'][0],
                    'type' => $_FILES['images']['type'][0],
                    'tmp_name' => $_FILES['images']['tmp_name'][0],
                    'error' => $_FILES['images']['error'][0],
                    'size' => $_FILES['images']['size'][0]
                ];
                $profilePhotoFilename = '/storage/artists/' . explode('/storage/artists/', $previousUserImage)[1];

                $coverPhotoFilename = uploadFile($profilePhoto, $image_upload_dir, $allowed_image_types, $image_max_size);
                if (!$coverPhotoFilename) {
                    $_SESSION['error'][] = "Failed to upload image!";
                    return 0;
                }
            }
        } else if ($previousCoverImage && !$previousUserImage) {
            if (!empty($_FILES['images']['name'][0])) {
                $profilePhoto = [
                    'name' => $_FILES['images']['name'][0],
                    'type' => $_FILES['images']['type'][0],
                    'tmp_name' => $_FILES['images']['tmp_name'][0],
                    'error' => $_FILES['images']['error'][0],
                    'size' => $_FILES['images']['size'][0]
                ];
                $coverPhotoFilename = '/storage/artists/' . explode('/storage/artists/', $previousCoverImage)[1];

                $profilePhotoFilename = uploadFile($profilePhoto, $image_upload_dir, $allowed_image_types, $image_max_size);
                if (!$profilePhotoFilename) {
                    $_SESSION['error'][] = "Failed to upload image!";
                    return 0;
                }
            }
        }

        if (empty($coverPhotoFilename)) {
            $coverPhotoFilename = "storage/artists/default-cover.jpg";
        }
        $data['userphoto'] = $profilePhotoFilename;
        $data['coverphoto'] = $coverPhotoFilename;
        $updatedUser = ['user_id' => $data['user_id'], 'first_name' => $data['fname'], 'last_name' => $data['lname'], 'userphoto' => $data['userphoto'], 'coverphoto' => $data['coverphoto'], 'cr_at' => 'now'];
        $user = new User();
        $res = $user->updateArtist($data);
        if ($res) {
            echo json_encode(['success' => true, 'message' => "Artist Updated !", 'data' => $updatedUser]);
        } else {
            echo json_encode(['success' => false, 'message' => "Something Wrong !"]);
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
        $user = new User();
        $res = $user->delete($id);
        if ($res['success']) {
            echo json_encode(['success' => true, 'message' => 'Artist Deleted Successfully !']);
            return 0;
        } else {
            echo json_encode(['success' => false, 'message' => $res['message']]);
        }
    }
}