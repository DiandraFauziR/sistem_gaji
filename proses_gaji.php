<?php
include 'includes/config.php';

// Pastikan action aman digunakan
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle hitung gaji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'hitung') {
    // Validasi input dasar
    $karyawan_id = isset($_POST['karyawan_id']) ? (int)$_POST['karyawan_id'] : 0;
    $bulan = isset($_POST['bulan']) ? $conn->real_escape_string($_POST['bulan']) : '';
    $tahun = isset($_POST['tahun']) ? (int)$_POST['tahun'] : 0;
    $total_gaji = isset($_POST['total_gaji']) ? (float)str_replace(['Rp', '.', ' '], '', $_POST['total_gaji']) : 0;

    if ($karyawan_id <= 0 || empty($bulan) || $tahun <= 0 || $total_gaji <= 0) {
        header("Location: gaji.php?error=Data+tidak+lengkap+atau+tidak+valid");
        exit;
    }

    // Cek duplikat gaji
    $check_sql = "SELECT id FROM gaji WHERE karyawan_id = $karyawan_id AND bulan = '$bulan' AND tahun = $tahun";
    $check_result = $conn->query($check_sql);
    
    if ($check_result && $check_result->num_rows > 0) {
        header("Location: gaji.php?error=Data+gaji+untuk+periode+ini+sudah+ada");
        exit;
    }

    // Simpan ke database
    $sql = "INSERT INTO gaji (karyawan_id, bulan, tahun, total_gaji) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        header("Location: gaji.php?error=Prepare+statement+gagal");
        exit;
    }

    $stmt->bind_param("issd", $karyawan_id, $bulan, $tahun, $total_gaji);
    
    if ($stmt->execute()) {
        header("Location: gaji.php?sukses=ditambahkan");
    } else {
        header("Location: gaji.php?error=Gagal+menyimpan+data");
    }
    $stmt->close();
    exit;
}

// Handle hapus gaji
if ($action === 'delete') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id > 0) {
        $sql = "DELETE FROM gaji WHERE id = $id";
        if ($conn->query($sql)) {
            header("Location: gaji.php?sukses=dihapus");
        } else {
            header("Location: gaji.php?error=Gagal+menghapus+data");
        }
    } else {
        header("Location: gaji.php?error=ID+tidak+valid");
    }
    exit;
}
?>
