<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. If already logged in, go to dashboard
if (isset($_SESSION['user'])) {
    header("Location: " . url('/'));
    exit();
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 2. YOUR HARDCODED ADMIN CHECK
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        $_SESSION['user'] = [
            'cfrj_email' => $email,
            'cfrj_password' => $password,
            'cfrj_role' => 'admin',
            'cfrj_first_name' => 'Admin',
            'cfrj_last_name' => 'User'
        ];
        header("Location: " . url('/'));
        exit();
    }

    // 3. IF NOT ADMIN, CHECK DATABASE
    if (!empty($email) && !empty($password)) {
        try {
            $db = new Database;
            // Using first() is safer than get() for single users
            $user = $db->table('cfrj_users')->where('cfrj_email', $email)->first();

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
        } catch (Exception $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="bg-pink-50 flex items-center justify-center min-h-screen">

<div class="max-w-6xl mx-auto w-full px-4">

    <!-- HEADER STYLE (same as dashboard) -->
    <div class="bg-white rounded-3xl p-6 mb-6 shadow-sm border border-pink-100 text-center">
        <h1 class="text-3xl font-extrabold text-pink-900 tracking-tight">
            <span class="text-pink-500 italic">Welcome</span> Back
        </h1>
        <p class="text-slate-400 text-sm mt-1">Login to access the system</p>
    </div>

    
    <div class="bg-white rounded-3xl shadow-xl shadow-pink-200/50 border border-pink-100 p-8 max-w-md mx-auto">

        <h2 class="text-xl font-bold text-pink-500 mb-4 text-center">User Login</h2>

        <!-- Error message -->
        <?php if(isset($error)): ?>
            <div class="bg-red-100 text-red-500 p-3 rounded-xl mb-4 text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Login form -->
        <form method="POST" class="space-y-4">

            <input type="email" name="email" placeholder="Email"
                class="w-full p-3 border border-pink-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-300">

            <input type="password" name="password" placeholder="Password"
                class="w-full p-3 border border-pink-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-300">

            <button
                class="w-full bg-pink-500 hover:bg-pink-600 text-white py-3 rounded-2xl font-bold transition-all shadow-lg shadow-pink-200 active:scale-95">
                Login
            </button>

        </form>

        <!-- Sign up link -->
        <p class="text-center mt-6 text-sm text-pink-500">
            Don’t have an account?
            <a href="<?= url('/sign_up') ?>" class="font-bold hover:underline">Sign up</a>
        </p>

    </div>
</div>
</body>
</html>
