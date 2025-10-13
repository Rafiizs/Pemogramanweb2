<?php
session_start();
require_once 'koneksi.php';

if(!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$login_time = $_SESSION['login_time'] ?? 'Tidak diketahui';

$message = '';
$message_type = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_manga']) || isset($_POST['update_manga'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $genre = mysqli_real_escape_string($conn, $_POST['genre']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $volumes = mysqli_real_escape_string($conn, $_POST['volumes']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        
        if(isset($_POST['add_manga'])) {
            $sql = "INSERT INTO manga (title, author, genre, price, volumes, status, description) 
                    VALUES ('$title', '$author', '$genre', '$price', '$volumes', '$status', '$description')";
            
            if(mysqli_query($conn, $sql)) {
                $message = "Manga berhasil ditambahkan!";
                $message_type = "success";
            } else {
                $message = "Error: " . mysqli_error($conn);
                $message_type = "error";
            }
        } else {
            $id = mysqli_real_escape_string($conn, $_POST['manga_id']);
            $sql = "UPDATE manga SET title='$title', author='$author', genre='$genre', 
                    price='$price', volumes='$volumes', status='$status', description='$description' 
                    WHERE id='$id'";
            
            if(mysqli_query($conn, $sql)) {
                $message = "Manga berhasil diupdate!";
                $message_type = "success";
            } else {
                $message = "Error: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    }
}

if(isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM manga WHERE id='$id'";
    
    if(mysqli_query($conn, $sql)) {
        $message = "Manga berhasil dihapus!";
        $message_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn);
        $message_type = "error";
    }
}

$edit_manga = null;
if(isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($conn, $_GET['edit']);
    $sql = "SELECT * FROM manga WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $edit_manga = mysqli_fetch_assoc($result);
}

$sql = "SELECT * FROM manga ORDER BY id DESC";
$manga_result = mysqli_query($conn, $sql);

$total_manga = mysqli_num_rows($manga_result);
$total_sales_sql = "SELECT COUNT(*) as total FROM orders";
$total_sales_result = mysqli_query($conn, $total_sales_sql);
$total_sales_row = mysqli_fetch_assoc($total_sales_result);
$total_sales = $total_sales_row['total'];

mysqli_data_seek($manga_result, 0);
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
            max-width: 1200px;
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
            margin-top: 20px;
        }
        .crud-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .manga-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .manga-table th, .manga-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .manga-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .btn-small {
            padding: 5px 10px;
            font-size: 0.8em;
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
            <?php if($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

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
            
            <div class="crud-section">
                <h2><?php echo $edit_manga ? 'Edit Manga' : 'Tambah Manga Baru'; ?></h2>
                <form method="POST" action="">
                    <?php if($edit_manga): ?>
                        <input type="hidden" name="manga_id" value="<?php echo $edit_manga['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="title">Judul Manga:</label>
                        <input type="text" id="title" name="title" required 
                               value="<?php echo $edit_manga ? htmlspecialchars($edit_manga['title']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <input type="text" id="author" name="author" required
                               value="<?php echo $edit_manga ? htmlspecialchars($edit_manga['author']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="genre">Genre:</label>
                        <input type="text" id="genre" name="genre" required
                               value="<?php echo $edit_manga ? htmlspecialchars($edit_manga['genre']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Harga:</label>
                        <input type="number" id="price" name="price" step="0.01" required
                               value="<?php echo $edit_manga ? htmlspecialchars($edit_manga['price']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="volumes">Jumlah Volume:</label>
                        <input type="number" id="volumes" name="volumes" required
                               value="<?php echo $edit_manga ? htmlspecialchars($edit_manga['volumes']) : '1'; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="Ongoing" <?php echo ($edit_manga && $edit_manga['status'] == 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                            <option value="Completed" <?php echo ($edit_manga && $edit_manga['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Hiatus" <?php echo ($edit_manga && $edit_manga['status'] == 'Hiatus') ? 'selected' : ''; ?>>Hiatus</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Deskripsi:</label>
                        <textarea id="description" name="description" rows="4" required><?php echo $edit_manga ? htmlspecialchars($edit_manga['description']) : ''; ?></textarea>
                    </div>
                    
                    <?php if($edit_manga): ?>
                        <button type="submit" name="update_manga" class="btn btn-primary">Update Manga</button>
                        <a href="dashboard.php" class="btn">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="add_manga" class="btn btn-primary">Tambah Manga</button>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="crud-section">
                <h2>Daftar Manga</h2>
                <?php if(mysqli_num_rows($manga_result) > 0): ?>
                    <table class="manga-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Author</th>
                                <th>Genre</th>
                                <th>Harga</th>
                                <th>Volume</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($manga = mysqli_fetch_assoc($manga_result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($manga['title']); ?></td>
                                    <td><?php echo htmlspecialchars($manga['author']); ?></td>
                                    <td><?php echo htmlspecialchars($manga['genre']); ?></td>
                                    <td>Rp <?php echo number_format($manga['price'], 0, ',', '.'); ?></td>
                                    <td><?php echo $manga['volumes']; ?></td>
                                    <td><?php echo $manga['status']; ?></td>
                                    <td class="action-buttons">
                                        <a href="dashboard.php?edit=<?php echo $manga['id']; ?>" class="btn btn-small">Edit</a>
                                        <a href="dashboard.php?delete=<?php echo $manga['id']; ?>" 
                                           class="btn btn-small" 
                                           onclick="return confirm('Yakin ingin menghapus manga ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tidak ada manga yang tersedia.</p>
                <?php endif; ?>
            </div>
            
            <div class="user-info">
                <h3>📊 Informasi Akun</h3>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Status:</strong> <span style="color: green;">✓ Terautentikasi</span></p>
                <p><strong>Login Time:</strong> <?php echo $login_time; ?></p>
            </div>
            
            <div class="quick-actions">
                <h3>🚀 Menu Cepat</h3>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="index.php" class="btn btn-primary">Lihat Koleksi Manga</a>
                    <a href="beli.php?manga=One%20Piece&harga=Rp%2045.000" class="btn">Beli One Piece</a>
                    <a href="beli.php?manga=Naruto&harga=Rp%2042.000" class="btn">Beli Naruto</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
mysqli_close($conn);
?>