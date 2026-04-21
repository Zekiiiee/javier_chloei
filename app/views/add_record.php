<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
    <title>New User</title>
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['cfrj_role'] !== 'admin') {
    header("Location: " . url('/'));
    exit();
}
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
    if($db->table('cfrj_users')->insert($data)) { header('Location:' . url('/')); exit; }
}
?>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-pink-200/50 border border-white">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-pink-900 tracking-tight uppercase">Join Registry</h1>
            <p class="text-slate-400 text-xs font-bold mt-1">Please fill out all credentials</p>
        </div>

        <form action="<?= url('add_record') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <input name="first_name" type="text" placeholder="First Name" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                <input name="last_name" type="text" placeholder="Last Name" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            </div>
            <input name="gender" type="text" placeholder="Gender" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            <input name="address" type="text" placeholder="Home Address" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            <input name="email" type="email" placeholder="Email Contact" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            <input name="password" type="password" placeholder="Password" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
            
            <button type="submit" class="w-full py-4 bg-pink-500 text-white font-bold rounded-2xl shadow-lg shadow-pink-200 hover:bg-pink-600 transition-all mt-4">
                Confirm 
            </button>
            <a href="<?= url('/') ?>" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest mt-6 transition-colors">Discard</a>
        </form>
    </div>
</body>                                                                                                                                                                                                                                                    <script src="https://cdn.tailwindcss.com"></script>
</html>