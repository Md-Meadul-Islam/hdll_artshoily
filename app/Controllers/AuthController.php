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
        $email = sanitizeInput($_POST['email']);
        $pass = sanitizeInput($_POST['password']);
        if (isset($email) && isset($pass)) {
            $user = new User();
            $userinfo = $user->login($email, $pass);
            if (isset($userinfo['error'])) {
                // Login failed
                $_SESSION['error'][] = $userinfo['error'];
                return redirect('/login');
            }
           // Login success
            $_SESSION['temp'] = $userinfo['userid'];
            $_SESSION['success'][] = 'Welcome! You are successfully logged in.';
            return redirect("/" . $userinfo['userrole']);
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('login');
        }

    }
    public function adminLoginView()
    {
        view(file_path: 'auth.admin-login');
    }
    public function adminLogin()
    {
        $username = sanitizeInput($_POST['username']);
        $pass = sanitizeInput($_POST['password']);
        if (isset($username) && isset($pass)) {
            $user = new User();
            $userinfo = $user->login($username, $pass, 'admin');
            if (isset($userinfo['error'])) {
                // Login failed
                $_SESSION['error'][] = $userinfo['error'];
                return redirect('/admin');
            }
           // Login success
            $_SESSION['temp'] = $userinfo['userid'];
            $_SESSION['success'][] = 'Welcome! You are successfully logged in.';
            return redirect("/admin/dashboard");
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('admin');
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
            'ip' => $ip,
            'userphoto'=>"storage/artists/default-user.jpg",
            'coverphoto'=>"storage/artists/default-cover.jpg"
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
            return redirect('signup');
        }


    }
}