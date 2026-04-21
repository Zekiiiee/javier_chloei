<?php

?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url() ?>public/css/output.css" rel="stylesheet">
    <title>Registry</title>
</head>
<body class="bg-pink-50 text-slate-700 font-sans min-h-screen p-4 md:p-12">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: " . url('/Log_in'));
    exit();
}
$role = $_SESSION['user']['cfrj_role'];
$rows = db()->table('cfrj_users')->get_all();
?>

<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-3xl p-8 mb-8 shadow-sm border border-pink-100 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-pink-900 tracking-tight"><span class="text-pink-500 italic">Records</span></h1>
            <p class="text-slate-400 text-sm mt-1">Manage system operatives and personal directories</p>
        </div>
        <div class="flex items-center space-x-4 mt-6 md:mt-0">
            <?php if ($role === 'admin'): ?>
            <a href="<?= url('add_record') ?>" 
               class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-pink-200 active:scale-95">
                + Add New User
            </a>
            <?php endif; ?>
            <a href="<?= url('/logout') ?>" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-gray-200 active:scale-95">
                Logout
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-pink-200/50 border border-pink-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-pink-50/50 border-b border-pink-100">
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-pink-400">Reference</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-pink-400">User Identity</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-pink-400">Gender</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-pink-400">Location</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-pink-400 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-50">
                    <?php foreach($rows as $row): ?>
                    <tr class="hover:bg-pink-50/30 transition-colors group">
                        <td class="px-6 py-5">
                            <span class="bg-pink-100 text-pink-500 text-[10px] font-bold px-2 py-1 rounded-md">#<?= $row['cfrj_id'] ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-pink-900 font-bold"><?= esc($row['cfrj_first_name']) ?> <?= esc($row['cfrj_last_name']) ?></span>
                                <span class="text-xs text-pink-400"><?= esc($row['cfrj_email']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-medium px-3 py-1 rounded-full border border-pink-200"><?= esc($row['cfrj_gender']) ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-sm text-pink-500 italic truncate block max-w-[150px]"><?= esc($row['cfrj_address']) ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center space-x-3">
                                <?php if ($role === 'admin'): ?>
                                <a href="<?= url('/update/'.$row['cfrj_id']) ?>" class="p-2 text-pink-400 hover:text-pink-500 hover:bg-pink-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <a href="<?= url('/delete/'.$row['cfrj_id']) ?>" onclick="return confirm('Erase?')" class="p-2 text-red-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>                                                                                                                                                                                                                    <script src="https://cdn.tailwindcss.com"></script>
</html>