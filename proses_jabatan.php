<?php
include 'includes/config.php';

$action = $_GET['action'];

if ($action == 'add') {
    $nama_jabatan = $_POST['nama_jabatan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $deskripsi = $_POST['deskripsi'];
    
    $sql = "INSERT INTO jabatan (nama_jabatan, gaji_pokok, deskripsi) 
            VALUES ('$nama_jabatan', $gaji_pokok, '$deskripsi')";
    
    if ($conn->query($sql)) {
        header("Location: jabatan.php?sukses=tambah");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'edit') {
    $id = $_POST['id'];
    $nama_jabatan = $_POST['nama_jabatan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $deskripsi = $_POST['deskripsi'];
    
    $sql = "UPDATE jabatan SET 
            nama_jabatan = '$nama_jabatan', 
            gaji_pokok = $gaji_pokok,
            deskripsi = '$deskripsi'
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: jabatan.php?sukses=edit");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM jabatan WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: jabatan.php?sukses=hapus");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>