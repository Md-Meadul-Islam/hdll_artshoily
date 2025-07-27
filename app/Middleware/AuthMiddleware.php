<?php
namespace App\Middleware;

class AuthMiddleware
{
    public function handle($role = null)
    {
        $user = user(); // Assuming this returns the logged-in user object or null

        if (!$user || !$user->email) {
            redirect('/');
            exit();
        }

        if ($role && $user->role !== $role) {
            // If role is provided and doesn't match, deny access
            $_SESSION['error'][] = 'Unauthorized access';
            redirect('/');
            exit();
        }
    }
}