<?php
session_start();

// Redirect jika belum login
if(!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$login_time = $_SESSION['login_time'] ?? 'Tidak diketahui';

// Data statistik sederhana
$total_manga = 4;
$total_sales = 127;
$favorite_genre = "Adventure";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manga Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
        }
        .welcome-message {
            background-color: #e7f3ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #3498db;
        }
        .user-info {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard - Manga Store</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="dashboard-container">
            <div class="welcome-message">
                <h2>Selamat Datang, <?php echo htmlspecialchars($username); ?>! 👋</h2>
                <p>Ini adalah halaman dashboard administrator toko manga.</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_manga; ?></div>
                    <div>Total Manga</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_sales; ?></div>
                    <div>Total Penjualan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4.8</div>
                    <div>Rating Toko</div>
                </div>
            </div>
            
            <div class="user-info">
                <h3>📊 Informasi Akun</h3>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Status:</strong> <span style="color: green;">✓ Terautentikasi</span></p>
                <p><strong>Login Time:</strong> <?php echo $login_time; ?></p>
                <p><strong>Genre Favorit:</strong> <?php echo $favorite_genre; ?></p>
            </div>
            
            <div class="quick-actions">
                <h3>🚀 Menu Cepat</h3>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="index.php" class="btn btn-primary">Lihat Koleksi Manga</a>
                    <a href="index.php?search=One+Piece" class="btn">Cari One Piece</a>
                    <a href="beli.php?manga=One%20Piece&harga=Rp%2045.000" class="btn">Beli One Piece</a>
                    <a href="beli.php?manga=Naruto&harga=Rp%2042.000" class="btn">Beli Naruto</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>