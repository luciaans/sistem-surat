<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .welcome-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            margin-top: 50px;
            max-width: 800px;
        }

        .logo {
            max-width: 250px;
            margin-bottom: 20px;
        }

        h1 {
            color: #4481eb;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        .welcome-text {
            font-size: 1.4rem;
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem Informasi Surat Masuk dan Surat Keluar</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="home.php">Home</a>
                <a class="nav-link" href="dashboard.php">Surat Masuk</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center">
        <div class="welcome-container">
            <img src="img/logo.png" alt="Logo" class="logo">
            <h1>Selamat Datang di Sistem Informasi Surat</h1>
            <p class="welcome-text">
                Sebagai pengguna, Anda dapat melihat status dan informasi surat yang telah dibuat oleh admin. Anda tidak dapat membuat surat baru, tetapi dapat melihat dan memantau surat-surat yang sedang diproses.
            </p>
        </div>
    </div>
</body>
</html>