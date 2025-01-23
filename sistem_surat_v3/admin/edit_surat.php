<?php
// admin/edit_surat.php
session_start();
require_once '../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$id_surat = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM surat WHERE id_surat = ?");
$stmt->execute([$id_surat]);
$surat = $stmt->fetch();

if (!$surat) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor_surat = $_POST['nomor_surat'];
    $judul_surat = $_POST['judul_surat'];
    $isi_surat = $_POST['isi_surat'];
    $tanggal_surat = $_POST['tanggal_surat'];
    
    // Handle file upload if new file is provided
    $file_surat = $surat['file_surat'];
    if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] == 0) {
        // Delete old file if exists
        if ($file_surat && file_exists("../uploads/" . $file_surat)) {
            unlink("../uploads/" . $file_surat);
        }
        
        $target_dir = "../uploads/";
        $file_extension = pathinfo($_FILES["file_surat"]["name"], PATHINFO_EXTENSION);
        $file_surat = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $file_surat;
        
        if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $target_file)) {
            // File uploaded successfully
        } else {
            die("Error uploading file.");
        }
    }

    $stmt = $conn->prepare("UPDATE surat SET nomor_surat = ?, judul_surat = ?, isi_surat = ?, tanggal_surat = ?, file_surat = ? WHERE id_surat = ?");
    $stmt->execute([$nomor_surat, $judul_surat, $isi_surat, $tanggal_surat, $file_surat, $id_surat]);

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            color: black;
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

        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4481eb;
            box-shadow: 0 0 0 0.2rem rgba(68, 129, 235, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #4481eb, #04befe);
            border: none;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #3a70c4, #03b0ff);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #555f66;
            transform: translateY(-2px);
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }
    </style>
<body>
    <div class="container mt-4">
        <h2>Edit Surat</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nomor Surat:</label>
                <input type="text" name="nomor_surat" class="form-control" value="<?= htmlspecialchars($surat['nomor_surat']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Judul Surat:</label>
                <input type="text" name="judul_surat" class="form-control" value="<?= htmlspecialchars($surat['judul_surat']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Isi Surat:</label>
                <textarea name="isi_surat" class="form-control" rows="5" required><?= htmlspecialchars($surat['isi_surat']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Tanggal Surat:</label>
                <input type="date" name="tanggal_surat" class="form-control" value="<?= $surat['tanggal_surat'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Upload File Baru (PDF):</label>
                <input type="file" name="file_surat" class="form-control" accept=".pdf">
                <?php if ($surat['file_surat']): ?>
                    <small class="text-muted">File saat ini: <?= $surat['file_surat'] ?></small>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Surat</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>