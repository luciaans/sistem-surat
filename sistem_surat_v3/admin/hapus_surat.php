<?php
// admin/hapus_surat.php
session_start();
require_once '../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$id_surat = $_GET['id'] ?? 0;

// Get file information before deleting record
$stmt = $conn->prepare("SELECT file_surat FROM surat WHERE id_surat = ?");
$stmt->execute([$id_surat]);
$surat = $stmt->fetch();

if ($surat) {
    // Delete file if exists
    if ($surat['file_surat'] && file_exists("../uploads/" . $surat['file_surat'])) {
        unlink("../uploads/" . $surat['file_surat']);
    }

    // Delete record from database
    $stmt = $conn->prepare("DELETE FROM surat WHERE id_surat = ?");
    $stmt->execute([$id_surat]);
}

header('Location: dashboard.php');
exit();
?>