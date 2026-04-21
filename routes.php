<?php

$router->get('/', 'app/views/index.php')->middleware('AuthMiddleware');

$router->any('/add_record', 'app/views/add_record')->middleware('AuthMiddleware');  
$router->any('/sign_up', 'app/views/sign_up');
$router->any('/update/{id}', 'app/views/update')->middleware('AuthMiddleware'); 

$router->get('/delete/{id}', function($id) {
    $res =db()->table('cfrj_users')->where('cfrj_id', $id)->delete();
    if($res) {
        echo 'Account deleted successfully';
        header('Location:' . url('/'));
        exit;
    } else {
        echo "Failed to delete record";
    }   
})->middleware('AdminMiddleware');

$router->get('/logout', function() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header("Location: " . url('/Log_in'));
    exit();
})->middleware('AuthMiddleware');

$router->get('/Log_in', 'app/views/Log_in');
$router->post('/Log_in', function() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        $_SESSION['user'] = [
            'cfrj_email' => $email,
            'cfrj_password' => $password,
            'cfrj_role' => 'admin',
            'cfrj_first_name' => 'Admin',
            'cfrj_last_name' => 'User'
        ];
        header("Location: /");
        exit();
    }
    
    $user = db()->table('cfrj_users')->where('cfrj_email', $email)->get();
    
    if ($user && $password === $user['cfrj_password']) {
        $_SESSION['user'] = $user;
        header("Location: /");
        exit();
    }
    
    $error = "Invalid credentials";
    include 'app/views/Log_in.php';
});
