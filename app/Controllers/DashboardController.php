<?php
namespace App\Controllers;

class DashboardController
{
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