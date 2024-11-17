<?php
namespace App\Middleware;

class GuestMiddleware
{
    public function handle()
    {
        if (user()->email) {
            if (user()->role == 'writer') {
                redirect('writer/dashboard');
                exit();
            } elseif (user()->role == 'admin') {
                redirect('admin/dashboard');
                exit();
            }
        }
    }
}