<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
    <title>Edit User</title>
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['cfrj_role'] !== 'admin') {
    header("Location: " . url('/'));
    exit();
}
$db = new Database;
$user = $db->table('cfrj_users')->where('cfrj_id', segment(2))->get();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $data = [
        'cfrj_last_name' => $_POST['last_name'],
        'cfrj_first_name' => $_POST['first_name'],
        'cfrj_gender' => $_POST['gender'],
        'cfrj_address' => $_POST['address'],
        'cfrj_email' => $_POST['email']
    ];
    $db->table('cfrj_users')->where('cfrj_id', segment(2))->update($data);
    header('Location:' . url('/')); exit;
}
?>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-pink-200/50 border border-white">
        <?php if ($user): ?>
            <div class="text-center mb-8">
                <div class="inline-block p-4 bg-pink-50 text-pink-600 rounded-2xl mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h1 class="text-2xl font-black text-pink-900 tracking-tight">MODIFY USER</h1>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">User ID: #<?= $user['cfrj_id'] ?></p>
            </div>

            <form action="<?= url('/update/' . segment(2)) ?>" method="POST" class="space-y-4">
                <input type="hidden" name="cfrj_id" value="<?= esc($user['cfrj_id']) ?>">
                <div class="grid grid-cols-2 gap-4">
                    <input name="first_name" type="text" value="<?= esc($user['cfrj_first_name']) ?>" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                    <input name="last_name" type="text" value="<?= esc($user['cfrj_last_name']) ?>" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                </div>
                <input name="gender" type="text" value="<?= esc($user['cfrj_gender']) ?>" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                <input name="address" type="text" value="<?= esc($user['cfrj_address']) ?>" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                <input name="email" type="email" value="<?= esc($user['cfrj_email']) ?>" required class="w-full bg-pink-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-pink-500/20 transition-all"/>
                
                <button type="submit" class="w-full py-4 bg-pink-500 text-white font-bold rounded-2xl hover:bg-pink-600 transition-all mt-4 shadow-xl shadow-pink-200">
                    Update Profile
                </button>
                <a href="<?= url('/') ?>" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest mt-6 transition-colors">Abort Changes</a>
            </form>
        <?php endif; ?>
    </div>
</body>                                                                                                                                                                                                           <script src="https://cdn.tailwindcss.com"></script>
</html>