<?php
// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "dbsensorgas");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke database: " . mysqli_connect_error();
    exit();
}

// Baca data yang dikirim (gunakan GET)
if (isset($_GET['Gas'])) {
    $Gas = mysqli_real_escape_string($konek, $_GET['Gas']);
    
    // Pastikan data Gas tidak kosong
    if ($Gas !== null && is_numeric($Gas)) {
        // Simpan data sensor ke tabel tb_sensorgas
        $simpan = mysqli_query($konek, "INSERT INTO tb_sensorgas (Gas) VALUES ('$Gas')");
        
        // Memberi respon ke ESP32
        if ($simpan) {
            echo "Data berhasil dikirim dan disimpan";
        } else {
            echo "Gagal menyimpan data";
        }
    } else {
        echo "Nilai Gas tidak valid";
    }
} else {
    echo "Data tidak ditemukan";
}

// Tutup koneksi
mysqli_close($konek);
?>
