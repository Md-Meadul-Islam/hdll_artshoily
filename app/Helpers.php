<?php
use App\Models\User;

// function notFound($page)
// {
//     return require './pages/components/' . $page . '.php';
// }
function generateUId()
{
    $time = microtime(true);
    $timeHex = dechex($time * 1000000);
    $randomHex = bin2hex(random_bytes(8));
    return substr($timeHex, -8) . '-' . substr($randomHex, 0, 4) . '-' . substr($randomHex, 4, 4);
}
function user()
{
    if (isset($_SESSION['temp'])) {
        $userId = $_SESSION['temp'];
        $user = new User();
        return $user->user($userId);
    }
    return (object) ['firstname' => 'Anonymous', 'lastname' => '', 'email' => '', 'phone' => '', 'userphoto' => '', 'coverphoto' => '', 'role' => '', 'error' => 'User Not Found!'];
}
function redirect($url)
{
    header("Location: $url");
    exit();
}
function view($file_path, $data = [])
{
    $path = str_replace("\\", DIRECTORY_SEPARATOR, $file_path);
    $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
    $file = APP_ROOT . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $path . '.php';
    if (file_exists($file)) {
        extract($data);
        return require $file;
    }
    throw new Exception('Page Not Found!' . $file);
}
function pageAdd($file_path)
{
    include_once APP_ROOT . '/pages/' . $file_path . '.php';
}
function clientmac()
{
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content, '\\') - 20, 17);
}
function servermac()
{
    return strtok(exec('getmac'), ' ');
}
function getClientIP()
{
    $ipAddress = '';

    // Check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    }
    // Check for IPs passing through proxies
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Use the first IP address in the list (comma-separated)
        $ipAddress = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    // Check for IPs passing through load balancers
    elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $ipAddress = $_SERVER['HTTP_X_REAL_IP'];
    }
    // Fallback to REMOTE_ADDR
    else {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    return $ipAddress;
}
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function random_str($length = 10)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
function dump(...$datas)
{
    echo "<pre>";
    foreach ($datas as $data) {
        print_r($data);
        echo "</br>";
    }
    echo "</pre>";
}
function dd(...$datas)
{
    echo "<pre>";
    foreach ($datas as $data) {
        print_r($data);
        echo "</br>";
    }
    echo "</pre>";
    die;
}
if (!function_exists('diffForHumans')) {
    function diffForHumans($date)
    {
        $timezone = new DateTimeZone('Asia/Dhaka');
        $now = new DateTime('now');
        $now->setTimezone($timezone);
        $targetDate = new DateTime($date);
        $targetDate->setTimezone($timezone);
        $interval = $now->diff($targetDate);

        if ($interval->y > 0) {
            return $interval->y . 'y';
        } elseif ($interval->m > 0) {
            return $interval->m . 'month';
        } elseif ($interval->d > 0) {
            return $interval->d . 'd';
        } elseif ($interval->h > 0) {
            return $interval->h . 'h';
        } elseif ($interval->i > 30 && $interval->i < 59) {
            return 'New';
        } elseif ($interval->i > 0 && $interval->i < 29) {
            return $interval->i . 'm';
        } else {
            return 'Just Now';
        }
    }
}
function numForHumans($number)
{
    if ($number < 1000) {
        return (string) $number;
    }
    $units = ['', 'k', 'M', 'B', 'T'];
    $power = floor(log($number, 1000));
    $unit = $units[$power];
    $formattedNumber = number_format($number / pow(1000, $power), 1);
    $formattedNumber = rtrim(rtrim($formattedNumber, '0'), '.');
    return $formattedNumber . $unit;
}
function generateSlug($title)
{
    $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    // Remove all special characters except alphanumeric and spaces
    $slug = preg_replace('/[^\w\s]/u', '', $title);
    // Replace spaces and multiple dashes with a single dash
    $slug = preg_replace('/\s+/', '-', trim($slug));
    // Convert to lowercase
    $slug = strtolower($slug);
    return $slug;
}
