<?php
session_start();

// Tangani parameter GET
$manga = isset($_GET['manga']) ? htmlspecialchars($_GET['manga']) : 'Manga';
$harga = isset($_GET['harga']) ? htmlspecialchars($_GET['harga']) : 'Rp 0';

// Data manga untuk detail
$manga_details = [
    'One Piece' => [
        'author' => 'Eiichiro Oda',
        'volumes' => '104+ Volume',
        'status' => 'Masih Berlanjut'
    ],
    'Naruto' => [
        'author' => 'Masashi Kishimoto',
        'volumes' => '72 Volume',
        'status' => 'Selesai'
    ],
    'Bleach' => [
        'author' => 'Tite Kubo',
        'volumes' => '74 Volume',
        'status' => 'Selesai'
    ],
    'Berserk' => [
        'author' => 'Kentaro Miura',
        'volumes' => '41 Volume',
        'status' => 'Hiatus'
    ]
];

$current_manga = $manga_details[$manga] ?? [
    'author' => 'Tidak diketahui',
    'volumes' => 'Tidak diketahui',
    'status' => 'Tidak diketahui'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli <?php echo $manga; ?> - Manga Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .purchase-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .manga-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .detail-item {
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }
        .warning-message {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Pembelian Manga</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if(isset($_SESSION['username'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="purchase-container">
            <h2>Konfirmasi Pembelian</h2>
            
            <div class="manga-details">
                <h3>📚 Detail Manga</h3>
                <div class="detail-item">
                    <strong>Judul:</strong> <?php echo $manga; ?>
                </div>
                <div class="detail-item">
                    <strong>Harga:</strong> <?php echo $harga; ?>
                </div>
                <div class="detail-item">
                    <strong>Author:</strong> <?php echo $current_manga['author']; ?>
                </div>
                <div class="detail-item">
                    <strong>Volume:</strong> <?php echo $current_manga['volumes']; ?>
                </div>
                <div class="detail-item">
                    <strong>Status:</strong> <?php echo $current_manga['status']; ?>
                </div>
            </div>
            
            <?php if(isset($_SESSION['username'])): ?>
                <div class="success-message">
                    <p>✅ Anda login sebagai: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
                    <p>Pembelian <strong><?php echo $manga; ?></strong> berhasil diproses!</p>
                    <p>Terima kasih telah berbelanja di toko kami. Manga akan dikirim dalam 2-3 hari kerja.</p>
                </div>
                <div class="action-buttons">
                    <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
                    <a href="index.php" class="btn">Belanja Lagi</a>
                </div>
            <?php else: ?>
                <div class="warning-message">
                    <p>⚠️ Anda belum login. Silakan login untuk menyelesaikan pembelian.</p>
                    <p>Dengan login, Anda dapat melacak pesanan dan mendapatkan notifikasi pengiriman.</p>
                </div>
                <div class="action-buttons">
                    <a href="login.php" class="btn btn-primary">Login Sekarang</a>
                    <a href="index.php" class="btn">Kembali ke Beranda</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>