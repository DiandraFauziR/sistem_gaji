<?php
include 'includes/config.php';

// Sanitasi input untuk mencegah SQL Injection
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'add') {
    $nama_rating = $conn->real_escape_string($_POST['nama_rating']);
    $nilai_rating = $conn->real_escape_string($_POST['nilai_rating']);
    $bonus = (float)$_POST['bonus']; // Pastikan tipe data float
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    
    $sql = "INSERT INTO rating (nama_rating, nilai_rating, bonus, deskripsi) 
            VALUES ('$nama_rating', '$nilai_rating', $bonus, '$deskripsi')";
    
    if ($conn->query($sql)) {
        header("Location: rating.php?sukses=tambah");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'edit') {
    $id = (int)$_POST['id']; // Pastikan integer
    $nilai_rating = $conn->real_escape_string($_POST['nilai_rating']);
    $nama_rating = $conn->real_escape_string($_POST['nama_rating']);
    $bonus = (float)$_POST['bonus'];
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    
    $sql = "UPDATE rating SET 
            nama_rating = '$nama_rating',
            nilai_rating = '$nilai_rating',
            bonus = $bonus,
            deskripsi = '$deskripsi' 
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: rating.php?sukses=edit");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'delete') {
    $id = (int)$_GET['id']; // Pastikan integer
    
    // SOLUSI: Update data karyawan yang merujuk ke rating ini terlebih dahulu
    $update_sql = "UPDATE karyawan SET rating_id = NULL WHERE rating_id = $id";
    
    if ($conn->query($update_sql)) {
        // Setelah berhasil update, baru hapus rating
        $delete_sql = "DELETE FROM rating WHERE id = $id";
        
        if ($conn->query($delete_sql)) {
            header("Location: rating.php?sukses=hapus");
            exit;
        } else {
            $error_msg = "Gagal menghapus rating: " . $conn->error;
        }
    } else {
        $error_msg = "Gagal mengupdate data karyawan: " . $conn->error;
    }
    
    // Jika terjadi error, redirect dengan pesan error
    if (isset($error_msg)) {
        header("Location: rating.php?error=" . urlencode($error_msg));
        exit;
    }
}

$conn->close();
?>