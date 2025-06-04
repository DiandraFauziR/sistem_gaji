<?php
include 'includes/header.php';
include 'includes/config.php';

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: karyawan.php");
    exit;
}

$id = (int)$_GET['id'];

// Query database dengan JOIN ke tabel jabatan
$sql = "SELECT karyawan.*, jabatan.nama_jabatan, rating.nilai_rating
FROM karyawan 
JOIN jabatan ON karyawan.jabatan_id = jabatan.id
LEFT JOIN rating ON karyawan.rating_id = rating.id
WHERE karyawan.id = $id";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>Data karyawan tidak ditemukan</div>";
    include 'includes/footer.php';
    exit;
}

$row = $result->fetch_assoc();
?>

<div class="card">
    <div class="card-body">
        <!-- Bagian Foto -->
        <div class="text-center mb-4">
            <img src="assets/img/<?= htmlspecialchars($row['foto']) ?>" 
                 class="rounded"
                 width="150"
                 height="225"
                 onerror="this.src='assets/img/default.jpg'">
            <div class="mt-2">
                <?php
                $rating = $row['nilai_rating'];
                for ($i = 0; $i < 5; $i++) {
                    echo $i < $rating ? '★' : '☆';
                }
                ?>
            </div>
        </div>

        <!-- Detail Karyawan -->
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($row['nama']) ?></dd>

                    <dt class="col-sm-4">Jenis Kelamin</dt>
                    <dd class="col-sm-8">
                        <?= htmlspecialchars($row['jenis_kelamin']) ?></dd>
                    </dd>

                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($row['alamat']) ?></dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">No. Telp</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($row['telepon']) ?></dd>

                    <dt class="col-sm-4">Jabatan</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($row['nama_jabatan']) ?></dd>

                    <dt class="col-sm-4">Tanggal Masuk</dt>
                    <dd class="col-sm-8">
                        <?= date('d F Y', strtotime($row['tanggal_masuk'])) ?>
                    </dd>
                </dl>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4">
            <a href="edit_karyawan.php?id=<?= $id ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="karyawan.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>