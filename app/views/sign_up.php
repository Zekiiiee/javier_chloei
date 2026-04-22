<?php
$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database;
    $data = [
        'cfrj_last_name'  => $_POST['last_name'],
        'cfrj_first_name' => $_POST['first_name'],
        'cfrj_gender'     => $_POST['gender'],
        'cfrj_address'    => $_POST['address'],
        'cfrj_email'      => $_POST['email'],
        'cfrj_password'   => $_POST['password'],
        'cfrj_role'       => 'user'
    ];
    if($db->table('cfrj_users')->insert($data)) {
        $message = 'Account created successfully! Please log in.';
    } else {
        $message = 'Failed to create account.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-pink-200/50 border border-white">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-pink-900 tracking-tight uppercase">Sign Up</h1>
            <p class="text-slate-400 text-xs font-bold mt-1">Create your account</p>
        </div>

        <?php if($message): ?>
            <div class="bg-green-100 text-green-500 p-2 rounded mb-3">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="<?= url('/sign_up') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <input name="first_name" type="text" placeholder="First Name" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                <input name="last_name" type="text" placeholder="Last Name" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            </div>
            <input name="gender" type="text" placeholder="Gender" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            <input name="address" type="text" placeholder="Home Address" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            <input name="email" type="email" placeholder="Email Contact" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            
            <div class="relative">
                <input id="signupPass" name="password" type="password" placeholder="Password" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                <button type="button" onclick="togglePass('signupPass', 'eyeIcon2')" class="absolute right-4 top-1/2 -translate-y-1/2 text-pink-400">
                    <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.483 8.653 7.379 6 12 6s8.517 2.653 9.964 6.378a1.012 1.012 0 010 .644C20.517 15.347 16.621 18 12 18s-8.517-2.653-9.964-6.378z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            
            <button type="submit" class="w-full py-4 bg-pink-500 text-white font-bold rounded-2xl shadow-lg shadow-pink-200 hover:bg-pink-600 transition-all mt-4">
                Sign Up
            </button>
            <a href="<?= url('/Log_in') ?>" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest mt-6 transition-colors">Already have an account? Log in</a>
        </form>
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
