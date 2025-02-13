<?php
// Buat koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "dbsensorgas");

// Cek koneksi
if (!$konek) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Baca data dari tabel
$sql = mysqli_query($konek, "SELECT * FROM tb_sensorgas ORDER BY id DESC"); // Data terakhir berada di atas

// Cek apakah query berhasil
if ($sql) {
    // Baca data paling atas
    $data = mysqli_fetch_array($sql);
    $Gas = isset($data['Gas']) ? $data['Gas'] : 0; // Cek apakah nilai Gas ada
    
    // Apabila data kosong maka anggap nilai gas = 0
    if ($Gas == "") {
        $Gas = 0;
    }
    
    // Cetak nilai gas
    echo $Gas;
} else {
    echo "Query gagal: " . mysqli_error($konek);
}

// Tutup koneksi
mysqli_close($konek);
?>
