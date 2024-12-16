<?php

namespace App\Controllers;

use App\Models\User;
class AuthController
{
    public function loginView()
    {
        view(file_path: 'auth.login');
    }
    public function login()
    {
        $userId = generateUId();
        $email = sanitizeInput($_POST['email']);
        $pass = sanitizeInput($_POST['password']);
        $ip = getClientIP();
        $data = [
            'email' => $email,
            'pass' => $pass,
            'ip' => $ip
        ];
        if (isset($email) && isset($pass)) {
            $user = new User();
            $userinfo = $user->login($email, $pass, 'admin');
            if ($userinfo) {
                $_SESSION['success'][] = 'Welcome ! You are Successfully Logged In.';
                return redirect('/');
            }
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('login');
        }

    }

    public function signupView()
    {
        view('auth.signup');
    }

    public function signup()
    {
        $userId = generateUId();
        $firstName = sanitizeInput($_POST['firstname']);
        $lastName = sanitizeInput($_POST['lastname']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $pass = sanitizeInput($_POST['password']);
        $ip = getClientIP();
        $data = [
            'userid' => $userId,
            'fname' => $firstName,
            'lname' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'pass' => $pass,
            'ip' => $ip
        ];
        if (isset($firstName) && isset($email) && isset($pass)) {
            $user = new User();
            $userinfo = $user->signup($data);
            if ($userinfo) {
                // $_SESSION['user'] = ['userid' => $userinfo[0], 'name' => $userinfo[1]];
                $_SESSION['success'][] = 'Welcome ! You are Successfully Registered.';
                return redirect('login');
            }
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('register');
        }


    }

    public function artistView()
    {
        view('auth.artists');
    }
    public function artists()
    {
        $userId = generateUId();
        $firstName = sanitizeInput($_POST['firstname']);
        $lastName = sanitizeInput($_POST['lastname']);
        $bio = sanitizeInput($_POST['bio']);
        $ip = getClientIP();

        $image_upload_dir = 'storage/artists/';
        $image_max_size = 10 * 1024 * 1024; // 10 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        $data = [
            'userid' => $userId,
            'fname' => $firstName,
            'lname' => $lastName,
            'bio' => $bio,
            'ip' => $ip
        ];
        $user = new User();
        if (isset($firstName) && isset($_FILES)) {
            if (!empty($_FILES['profiles']['name'][0])) {
                foreach ($_FILES['profiles']['name'] as $index => $name) {
                    $image = [
                        'name' => $_FILES['profiles']['name'][$index],
                        'type' => $_FILES['profiles']['type'][$index],
                        'tmp_name' => $_FILES['profiles']['tmp_name'][$index],
                        'error' => $_FILES['profiles']['error'][$index],
                        'size' => $_FILES['profiles']['size'][$index]
                    ];
                    $file_path = $this->uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
                    if ($file_path) {
                        $data[$index] = $file_path;
                    }
                }
            }
            $userinfo = $user->addArtists($data);
            if ($userinfo) {
                $_SESSION['success'][] = 'Artists Added Successfully !';
                return redirect('add-artists');
            }
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('add-artists');
        }

    }
    private function uploadFile($file, $upload_dir, $allowed_types, $max_size)
    {
        if (!file_exists('storage/artists')) {
            mkdir('storage/artists', 0777, true);
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
            return $file_path;
        } else {
            return false;
        }
    }
}