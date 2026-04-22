<?php

$router->get('/', 'app/views/index.php')->middleware('AuthMiddleware');

$router->any('/add_record', 'app/views/add_record')->middleware('AuthMiddleware');  
$router->any('/sign_up', 'app/views/sign_up');
$router->any('/update/{id}', 'app/views/update')->middleware('AuthMiddleware'); 

$router->get('/delete/{id}', function($id) {
    $res = db()->table('cfrj_users')->where('cfrj_id', $id)->delete();
    if($res) {
        // REMOVED: echo 'Account deleted successfully'; 
        // You cannot echo before a header() redirect!
        header('Location: ' . url('/'));
        exit;
    } else {
        // If it fails, it's better to redirect with an error or use a session message
        header('Location: ' . url('/') . '?error=failed_to_delete');
        exit;
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
$router->post('/Log_in', 'app/views/Log_in');
