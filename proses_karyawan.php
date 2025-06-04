<?php
include 'includes/config.php';

$action = $_GET['action'];

if ($action == 'add') {
    $nama = $_POST['nama'];
    $jabatan_id = $_POST['jabatan_id'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $rating_id = $_POST['nilai_rating'];

$sql = "INSERT INTO karyawan (nama, jabatan_id, alamat, telepon, email, foto, tanggal_masuk, jenis_kelamin, rating_id) 
        VALUES ('$nama', $jabatan_id, '$alamat', '$telepon', '$email', '$foto', '$tanggal_masuk', '$jk', '$rating_id')";
    
    // Upload foto
    $foto = 'default.jpg';
    if ($_FILES['foto']['name']) {
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $foto = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $foto;
        
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    }
    
    $sql = "INSERT INTO karyawan (nama, jabatan_id, jenis_kelamin, alamat, telepon, email, foto, tanggal_masuk, rating_id) 
            VALUES ('$nama', '$jabatan_id', '$jk', '$alamat', '$telepon', '$email', '$foto', '$tanggal_masuk', '$rating_id')";
    
    if ($conn->query($sql)) {
        header("Location: karyawan.php?sukses=tambah");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    
    // Hapus foto jika bukan default (dengan pengecekan file_exists)
    $sql_foto = "SELECT foto FROM karyawan WHERE id = $id";
    $result = $conn->query($sql_foto);
    $row = $result->fetch_assoc();
    
    if ($row['foto'] != 'default.jpg') {
        $file_path = "assets/img/" . $row['foto'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // PERBAIKAN: Hapus data terkait di tabel gaj1 terlebih dahulu
    $conn->query("DELETE FROM gaji WHERE karyawan_id = $id");
    
    $sql = "DELETE FROM karyawan WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: karyawan.php?sukses=hapus");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} elseif ($action == 'edit') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan_id = $_POST['jabatan_id'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $foto_lama = $_POST['foto_lama'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $rating_id = $_POST['nilai_rating'];

$sql = "UPDATE karyawan SET 
        nama = '$nama', 
        jabatan_id = $jabatan_id, 
        rating_id = $rating_id,
        alamat = '$alamat', 
        telepon = '$telepon', 
        email = '$email', 
        foto = '$foto',
        tanggal_masuk = '$tanggal_masuk',
        jenis_kelamin = '$jk'
        WHERE id = $id";
    
    // Jika ada file foto baru diupload
    if ($_FILES['foto']['name']) {
        // Hapus foto lama jika bukan default
        if ($foto_lama != 'default.jpg') {
            unlink("assets/img/" . $foto_lama);
        }
        
        // Upload foto baru
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $foto = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $foto;
        
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    } else {
        // Gunakan foto lama jika tidak ada upload baru
        $foto = $foto_lama;
    }
    
    $sql = "UPDATE karyawan SET 
            nama = '$nama', 
            jabatan_id = '$jabatan_id', 
            jenis_kelamin = '$jk', 
            alamat = '$alamat', 
            telepon = '$telepon', 
            tanggal_masuk = '$tanggal_masuk',
            rating_id = '$rating_id',
            email = '$email', 
            foto = '$foto' 
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: karyawan.php?sukses=edit");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>