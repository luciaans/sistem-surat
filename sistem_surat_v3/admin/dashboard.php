<?php
// admin/dashboard.php
session_start();
require_once '../config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch all letters
$stmt = $conn->query("SELECT * FROM surat ORDER BY created_at DESC");
$surat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
    background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
    font-family: 'Arial', sans-serif;
    min-height: 100vh;
    margin: 0;
    padding: 0;
}

.navbar {
    background: linear-gradient(45deg, #4481eb, #04befe) !important;
    padding: 15px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.navbar-brand {
    font-weight: 600;
    font-size: 1.4rem;
    color: white !important;
}

.nav-link {
    color: white !important;
    margin-left: 20px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    color: #f0f0f0 !important;
    transform: translateY(-2px);
}

.container.mt-4 {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    margin-top: 30px;
}

.table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.table thead {
    background: linear-gradient(45deg, #4481eb, #04befe);
    color: white;
}

.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    padding: 15px;
    border: none;
    color: black;
}

.table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.table tbody tr:hover {
    background-color: #e9ecef;
    transition: background-color 0.3s ease;
}

.table td {
    vertical-align: middle;
    padding: 12px 15px;
}

.btn-sm {
    padding: 5px 15px;
    margin: 0 3px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-sm.btn-warning, 
.btn-sm.btn-danger {
    width: 70px;  
    display: inline-block;
    text-align: center;
}

.btn-warning {
    background: linear-gradient(45deg, #4481eb, #04befe);
    border: none;
    color: white;
}

.btn-warning:hover {
    background:rgb(49, 242, 5);
    transform: translateY(-2px);
}

.btn-danger {
    background: linear-gradient(45deg, #4481eb, #04befe);
    border: none;
}

.btn-danger:hover {
    background:rgb(238, 7, 7);
    transform: translateY(-2px);
}

h2 {
    color: black !important;
    font-weight: 600;
    margin-bottom: 20px;
    border-bottom: 3px solid #4481eb;
    padding-bottom: 10px;
}

.table a {
    color: #4481eb;
    text-decoration: none;
    transition: color 0.3s ease;
}

.table a:hover {
    color: #04befe;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        padding: 3px 10px;
        font-size: 0.8rem;
    }
}
    </style>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem informasi surat masuk dan surat keluar</a>
            <div class="navbar-nav ms-auto">
            <a class="nav-link" href="home.php">Home</a>
                <a class="nav-link" href="dashboard.php">Daftar Surat</a>
                <a class="nav-link" href="buat_surat.php">Buat Surat</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Surat Keluar</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>File</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($surat as $index => $s): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($s['nomor_surat']) ?></td>
                    <td><?= htmlspecialchars($s['judul_surat']) ?></td>
                    <td><?= $s['tanggal_surat'] ?></td>
                    <td>
                        <?php if ($s['file_surat']): ?>
                            <a href="../uploads/<?= $s['file_surat'] ?>" target="_blank">Lihat File</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_surat.php?id=<?= $s['id_surat'] ?>" class="btn btn-sm btn-warning" style="color: black;">Edit</a>
                        <a href="hapus_surat.php?id=<?= $s['id_surat'] ?>" class="btn btn-sm btn-danger" style="color: black;" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>