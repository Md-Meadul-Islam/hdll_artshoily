<?php
namespace App\Controllers;

use App\Models\Art;
use App\Models\User;

class UserController
{
    public function loadUsersPaginate()
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $user = new User();
        $artists = $user->paginateUsers($page, $limit);
        echo json_encode(['success' => true, 'data' => $artists]);
    }
    public function loadCreateUserModal()
    {
        $mode = 'create';
        view('admin.users-modal', ['mode' => $mode]);
    }
    public function loadEditUserModal()
    {
        $id = $_GET['dataId'];
        $user = new User();
        $artist = $user->get($id);
        view('admin.users-modal', ['user' => $artist, 'mode' => 'edit']);
    }
    public function loadFocusArtistsModal()
    {
        $user = new User();
        $artists = $user->artists();
        view('admin.focus-artists-modal', ['artists' => $artists]);
    }
    public function store()
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
        $res = $user->storeUser($data);
        $newArtist = ['user_id' => $data['user_id'], 'first_name' => $data['fname'], 'last_name' => $data['lname'], 'userphoto' => $data['userphoto'], 'coverphoto' => $data['coverphoto'], 'userrole' => $data['userrole'], 'cr_at' => 'now'];
        $msg = $data['userrole'] === 'artists' ? "Artists Added Successfully !" : "Blogger Added Successfully !";
        if ($res) {
            echo json_encode(['success' => true, 'message' => $msg, 'data' => $newArtist]);

        }
    }

    public function update()
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
        $updatedUser = ['user_id' => $data['user_id'], 'first_name' => $data['fname'], 'last_name' => $data['lname'], 'userphoto' => $data['userphoto'], 'coverphoto' => $data['coverphoto'], 'userrole' => $data['userrole'], 'cr_at' => 'now'];
        $user = new User();
        $res = $user->updateUser($data);
        if ($res) {
            $msg = $data['userrole'] === 'artists' ? "Artists Updated Successfully !" : "Blogger Updated Successfully !";
            echo json_encode(['success' => true, 'message' => $msg, 'data' => $updatedUser]);
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