<?php
defined('APP_ROOT') OR exit('No direct script access allowed');


return function($method, $params) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']['cfrj_role'] !== 'admin') {
        header('Location: ' . (function_exists('url') ? url('/Log_in') : '/Log_in'));
        exit;
    }

    return true;
};
