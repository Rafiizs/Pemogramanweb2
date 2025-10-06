<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembelian Manga Online</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <h1>Pembelian Manga Online</h1>
    <nav>
      <ul>
        <li><a href="#tentang">Tentang</a></li>
        <li><a href="#koleksi">Koleksi</a></li>
        <li><a href="#kontak">Kontak</a></li>
        <?php if(isset($_SESSION['username'])): ?>
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>
    <section id="hero">
      <h2>Selamat Datang di Toko Manga Kami</h2>
      <p>Tempat terbaik membeli manga favorit dengan berbagai genre.</p>
      <a href="#koleksi" class="btn btn-primary">Lihat Koleksi</a>
      
      <?php
      // Menangani query string untuk pencarian
      if(isset($_GET['search'])) {
          $search = htmlspecialchars($_GET['search']);
          echo "<p style='margin-top: 20px;'>Hasil pencarian untuk: <strong>$search</strong></p>";
      }
      ?>
    </section>

    <section id="tentang">
      <h2>Tentang Kami</h2>
      <p>Kami menyediakan manga original berbagai genre seperti action, romance, dan shounen, dst
         untuk penggemar di seluruh Indonesia.</p>
    </section>

    <section id="koleksi">
      <h2>Koleksi Manga</h2>

      <?php
      // Data manga dari array PHP
      $mangas = [
          [
              'title' => 'One Piece',
              'genre' => 'Adventure, Fantasy comedy, Science fiction',
              'price' => 'Rp 45.000',
              'description' => 'Petualangan Monkey D. Luffy dan kru bajak lautnya mencari harta karun legendaris One Piece.'
          ],
          [
              'title' => 'Naruto',
              'genre' => 'Adventure, Fantasy comedy, Martial arts',
              'price' => 'Rp 42.000',
              'description' => 'Kisah Naruto Uzumaki, ninja muda yang bercita-cita menjadi Hokage desanya.'
          ],
          [
              'title' => 'Bleach',
              'genre' => 'Adventure, Martial arts, Supernatural',
              'price' => 'Rp 40.000',
              'description' => 'Ichigo Kurosaki mendapatkan kekuatan Shinigami dan bertugas melindungi manusia dari roh jahat.'
          ],
          [
              'title' => 'Berserk',
              'genre' => 'Dark fantasy, Epic fantasy, Sword and sorcery',
              'price' => 'Rp 50.000',
              'description' => 'Perjalanan Guts, seorang prajurit bayaran dalam dunia yang gelap dan penuh bahaya.'
          ]
      ];

      // Filter manga berdasarkan pencarian
      $filteredMangas = $mangas;
      if(isset($_GET['search']) && !empty($_GET['search'])) {
          $searchTerm = strtolower($_GET['search']);
          $filteredMangas = array_filter($mangas, function($manga) use ($searchTerm) {
              return strpos(strtolower($manga['title']), $searchTerm) !== false || 
                     strpos(strtolower($manga['genre']), $searchTerm) !== false;
          });
      }

      foreach($filteredMangas as $manga):
      ?>
      <article class="article-card">
        <h3><?php echo $manga['title']; ?></h3>
        <p><strong>Genre:</strong> <?php echo $manga['genre']; ?></p>
        <p><strong>Harga:</strong> <?php echo $manga['price']; ?></p>
        <p><?php echo $manga['description']; ?></p>
        <a href="beli.php?manga=<?php echo urlencode($manga['title']); ?>&harga=<?php echo urlencode($manga['price']); ?>" class="btn btn-primary">Beli Sekarang</a>
      </article>
      <?php endforeach; ?>

      <?php if(empty($filteredMangas)): ?>
        <p style="text-align: center; color: #666;">Tidak ada manga yang ditemukan.</p>
      <?php endif; ?>

    </section>

    <section id="kontak">
      <h2>Kontak</h2>
      <p>Email: info@mangastore.com</p>
      <p>Telepon: +62-812-3456-7890</p>
      <p>Alamat: Jl. Manga No. 123, Jakarta</p>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> Pembelian Manga Online</p>
    <p>Referensi desain: 
      <a href="https://www.crunchyroll.com/store" target="_blank" rel="noopener">
        https://www.crunchyroll.com/store
      </a>
    </p>
  </footer>

  <script src="script.js"></script>
</body>
</html>