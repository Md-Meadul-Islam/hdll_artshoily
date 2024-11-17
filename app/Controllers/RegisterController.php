<?php
namespace App\Controllers;

use App\Models\User;

class RegisterController
{
    public function index()
    {
        view('auth.signup');
    }
    public function store()
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
    public function tempUserStore()
    {
        $userid = generateUId();
        $username = sanitizeInput($_POST['username']);
        $email = $userid . '@viralalready.com';
        $uuid = $_POST['device_uuid'];
        $ip = getClientIP();
        if ($uuid) {
            $user = new User();
            $userData = $user->tempRegister([
                'user_id' => $userid,
                'first_name' => $username,
                'email' => $email,
                'uuid' => $uuid,
                'ip' => $ip
            ]);
            if ($userData) {
                $_SESSION['temp'] = $userData;
                echo json_encode(['success' => true, 'message' => ' Now You are valid member !']);
            } else {
                $_SESSION['error'][] = 'Please try again!';
                echo json_encode(['success' => false, 'message' => 'Please try again!']);
            }
        } else {
            $_SESSION['error'][] = 'Invalid IP address!';
            echo json_encode(['success' => false, 'message' => 'Invalid  IP address!']);
        }
    }
    public function writerSignup()
    {
        view('writer.signup');
    }
    public function writerStore()
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
            $userinfo = $user->signup($data, 'writer');
            if ($userinfo) {
                // $_SESSION['user'] = ['userid' => $userinfo[0], 'name' => $userinfo[1]];
                $_SESSION['success'][] = 'Welcome ! You are Successfully Registered.';
                return redirect('writer');
            }
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('writersignup');
        }

    }
}