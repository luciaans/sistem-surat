<?php
// process_register.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $table = ($role == 'admin') ? 'admin' : 'users';
    
    try {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT username FROM $table WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            header('Location: register.php?error=username_exists');
            exit();
        }

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO $table (username, password, nama_lengkap, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $nama_lengkap, $email]);

        header('Location: login.php?success=1');
        exit();
    } catch(PDOException $e) {
        header('Location: register.php?error=database');
        exit();
    }
}
?>