<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header("Location: " . url('/'));
    exit();
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $db = new Database;
        
        // Match the column name 'cfrj_email' from your database
        $user = $db->table('cfrj_users')->where('cfrj_email', $email)->get();

        if ($user) {
            // Check if password matches
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
</head>

<body class="bg-pink-50 flex items-center justify-center min-h-screen">

<div class="max-w-6xl mx-auto w-full px-4">

    <div class="bg-white rounded-3xl p-6 mb-6 shadow-sm border border-pink-100 text-center max-w-md mx-auto">
        <h1 class="text-3xl font-extrabold text-pink-900 tracking-tight">
            <span class="text-pink-500 italic">Welcome</span> Back
        </h1>
        <p class="text-slate-400 text-sm mt-1">Login to access the system</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-pink-200/50 border border-pink-100 p-8 max-w-md mx-auto">

        <h2 class="text-xl font-bold text-pink-500 mb-4 text-center">User Login</h2>

        <?php if($error): ?>
            <div class="bg-red-50 text-red-500 p-3 rounded-xl mb-4 text-sm border border-red-100 text-center font-bold">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">

            <input type="email" name="email" placeholder="Email" required
                class="w-full p-4 bg-pink-50 border-none rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all text-sm">

            <input type="password" name="password" placeholder="Password" required
                class="w-full p-4 bg-pink-50 border-none rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all text-sm">

            <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-pink-200 active:scale-95 mt-2">
                Login
            </button>

        </form>

        <p class="text-center mt-6 text-sm text-pink-500">
            Don’t have an account?
            <a href="<?= url('/sign_up') ?>" class="font-bold hover:underline">Sign up</a>
        </p>

    </div>
</div>

</body>
</html>
