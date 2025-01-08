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
            $userinfo = $user->login($email, $pass, 'artists');
            if ($userinfo) {
                $_SESSION['success'][] = 'Welcome ! You are Successfully Logged In.';
                return redirect('/');
            }
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
            if ($userinfo['userid']) {
                $_SESSION['temp'] = $userinfo['userid'];
                $_SESSION['success'][] = 'Welcome ! You are Logged In.';
                return redirect('/admin');
            } else {
                $_SESSION['error'][] = $userinfo['error'];
                return redirect('/admin/login');
            }
        } else {
            $_SESSION['error'][] = 'Please fill Up Required Field !';
            return redirect('admin/login');
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
}