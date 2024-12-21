<?php
namespace App\Middleware;

class GuestMiddleware
{
    public function handle()
    {
        if (user()->email) {
            if (user()->role == 'artists') {
                redirect('/artists');
                exit();
            } elseif (user()->role == 'admin') {
                redirect('/admin');
                exit();
            }
        }
    }
}