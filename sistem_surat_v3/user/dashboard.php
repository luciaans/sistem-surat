<?php
// user/dashboard.php
session_start();
require_once '../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
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
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            color: black;
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

        h2 {
            color: black !important;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 3px solid #4481eb;
            padding-bottom: 10px;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            color: black;
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
        th, td {
            white-space: nowrap; 
            text-align: center; 
            vertical-align: middle; 
        }


        .table tbody tr {
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

        .surat-content {
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-sm {
            padding: 5px 15px;
            margin: 0 3px;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: black;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4481eb, #04befe);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #3a70c4, #03b0ff);
            transform: translateY(-2px);
        }

        .modal-body pre {
            white-space: pre-wrap;
            word-wrap: break-word;
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem Surat</a>
            <div class="navbar-nav ms-auto">
            <a class="nav-link" href="home.php">Home</a>
            <a class="nav-link" href="dashboard.php">Surat Masuk</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Surat Masuk</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Judul</th>
                        <th>Isi Surat</th>
                        <th>Tanggal</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($surat as $index => $s): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($s['nomor_surat']) ?></td>
                        <td><?= htmlspecialchars($s['judul_surat']) ?></td>
                        <td>
                            <div class="surat-content">
                                <?= nl2br(htmlspecialchars(substr($s['isi_surat'], 0, 100))) ?>
                                <?php if (strlen($s['isi_surat']) > 100): ?>
                                    ...
                                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#suratModal<?= $s['id_surat'] ?>">
                                        Baca Selengkapnya
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Modal for full content -->
                            <div class="modal fade" id="suratModal<?= $s['id_surat'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?= htmlspecialchars($s['judul_surat']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <strong>Nomor Surat:</strong> <?= htmlspecialchars($s['nomor_surat']) ?>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Tanggal Surat:</strong> <?= $s['tanggal_surat'] ?>
                                            </div>
                                            <div>
                                                <strong>Isi Surat:</strong>
                                                <pre class="mt-2"><?= htmlspecialchars($s['isi_surat']) ?></pre>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?php if ($s['file_surat']): ?>
                                                <a href="../uploads/<?= $s['file_surat'] ?>" target="_blank" class="btn btn-primary">Download PDF</a>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><?= $s['tanggal_surat'] ?></td>
                        <td>
                            <?php if ($s['file_surat']): ?>
                                <a href="../uploads/<?= $s['file_surat'] ?>" target="_blank" class="btn btn-sm btn-primary">Download PDF</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>