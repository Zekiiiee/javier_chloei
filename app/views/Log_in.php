<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    header("Location: " . url('/'));
    exit();
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 1. CHECK HARDCODED ADMIN FIRST
    // Replace 'admin@email.com' and 'admin123' with your actual hardcoded info
    if ($email === 'admin@email.com' && $password === 'admin123') {
        $_SESSION['user'] = [
            'cfrj_first_name' => 'System',
            'cfrj_last_name' => 'Admin',
            'cfrj_email' => 'admin@email.com',
            'cfrj_role' => 'admin' // Crucial for your AdminMiddleware
        ];
        header("Location: " . url('/'));
        exit();
    }

    // 2. IF NOT HARDCODED ADMIN, CHECK DATABASE
    if (!empty($email) && !empty($password)) {
        $db = new Database;
        $user = $db->table('cfrj_users')->where('cfrj_email', $email)->get();

        if ($user) {
            if ($password === $user['cfrj_password']) {
                $_SESSION['user'] = $user;
                header("Location: " . url('/'));
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Account not found.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
