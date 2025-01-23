<?php
// process_login.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $table = ($role == 'admin') ? 'admin' : 'users';
    
    $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user[($role == 'admin') ? 'id_admin' : 'id_user'];
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $user['username'];

        if ($role == 'admin') {
            header('Location: admin/home.php');
        } else {
            header('Location: user/home.php');
        }
        exit();
    } else {
        header('Location: login.php?error=1');
        exit();
    }
}
?>