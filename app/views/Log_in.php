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

    // 1. ADMIN CHECK
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        $_SESSION['user'] = [
            'cfrj_email' => $email,
            'cfrj_role' => 'admin',
            'cfrj_first_name' => 'Admin',
            'cfrj_last_name' => 'User'
        ];
        header("Location: " . url('/'));
        exit();
    }

    // 2. USER DATABASE CHECK
    if (!empty($email) && !empty($password)) {
        $db = new Database;
        $results = $db->table('cfrj_users')->where('cfrj_email', $email)->get();

        if ($results) {
            $user = is_array($results) && isset($results[0]) ? $results[0] : $results;
            $dbPassword = is_array($user) ? $user['cfrj_password'] : $user->cfrj_password;

            if ($password === $dbPassword) {
                $_SESSION['user'] = (array)$user;
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-pink-50 flex items-center justify-center min-h-screen">
<div class="max-w-6xl mx-auto w-full px-4">
    <div class="bg-white rounded-3xl p-6 mb-6 shadow-sm border border-pink-100 text-center">
        <h1 class="text-3xl font-extrabold text-pink-900 tracking-tight">
            <span class="text-pink-500 italic">Welcome</span> Back
        </h1>
        <p class="text-slate-400 text-sm mt-1">Login to access the system</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-pink-200/50 border border-pink-100 p-8 max-w-md mx-auto">
        <h2 class="text-xl font-bold text-pink-500 mb-4 text-center">User Login</h2>

        <?php if(isset($error)): ?>
            <div class="bg-red-100 text-red-500 p-3 rounded-xl mb-4 text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email"
                class="w-full p-3 border border-pink-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-300">

            <div class="relative">
                <input type="password" id="loginPass" name="password" placeholder="Password"
                    class="w-full p-3 border border-pink-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-300">
                <button type="button" onclick="togglePass('loginPass', 'eyeIcon1')" class="absolute right-4 top-1/2 -translate-y-1/2 text-pink-400">
                    <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.483 8.653 7.379 6 12 6s8.517 2.653 9.964 6.378a1.012 1.012 0 010 .644C20.517 15.347 16.621 18 12 18s-8.517-2.653-9.964-6.378z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <button class="w-full bg-pink-500 hover:bg-pink-600 text-white py-3 rounded-2xl font-bold transition-all shadow-lg shadow-pink-200 active:scale-95">
                Login
            </button>
        </form>

        <p class="text-center mt-6 text-sm text-pink-500">
            Don’t have an account?
            <a href="<?= url('/sign_up') ?>" class="font-bold hover:underline">Sign up</a>
        </p>
    </div>
</div>

<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
    } else {
        input.type = "password";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.483 8.653 7.379 6 12 6s8.517 2.653 9.964 6.378a1.012 1.012 0 010 .644C20.517 15.347 16.621 18 12 18s-8.517-2.653-9.964-6.378z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
    }
}
</script>
</body>
</html>
