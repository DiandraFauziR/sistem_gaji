<?php
include 'includes/config.php';

$action = $_GET['action'];

if ($action == 'add') {

    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $tarif = $_POST['tarif'];
    
    $sql = "INSERT INTO lembur (jam_mulai, jam_selesai, tarif ) 
            VALUES ('$jam_mulai', '$jam_selesai', '$tarif' )";
    
    if ($conn->query($sql)) {
        header("Location: lembur.php?sukses=tambah");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'edit') {
    $id = $_POST['id'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $tarif = $_POST['tarif'];
    
    $sql = "UPDATE lembur SET 
            jam_mulai = '$jam_mulai', 
            jam_selesai = '$jam_selesai', 
            tarif = $tarif 
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: lembur.php?sukses=edit");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM lembur WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: lembur.php?sukses=hapus");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>