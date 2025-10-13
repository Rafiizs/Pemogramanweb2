<?php
require_once 'koneksi.php';

echo "<h2>Testing Koneksi Database</h2>";

// Test koneksi
if ($conn) {
    echo "✅ Koneksi database BERHASIL!<br>";
    
    // Test query
    $sql = "SELECT * FROM manga";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $jumlah_manga = mysqli_num_rows($result);
        echo "✅ Query berhasil! Jumlah manga: " . $jumlah_manga . "<br>";
        
        // Tampilkan data manga
        echo "<h3>Data Manga:</h3>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "- " . $row['title'] . " by " . $row['author'] . "<br>";
        }
    } else {
        echo "❌ Query gagal: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
} else {
    echo "❌ Koneksi database GAGAL!";
}
?>