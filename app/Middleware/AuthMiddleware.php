<?php
namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        if (!user()->email) {
            redirect('/');
            exit();
        }
    }
}