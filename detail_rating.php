<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/header.php';
include 'includes/config.php';

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID rating tidak valid";
    header("Location: rating.php");
    exit;
}

$id = (int)$_GET['id'];

// Query database untuk mendapatkan data rating
$sql_rating = "SELECT * FROM rating WHERE id = $id";
$result_rating = $conn->query($sql_rating);

// Tangani error query
if ($result_rating === false) {
    $_SESSION['error'] = "Error query: " . $conn->error;
    header("Location: rating.php");
    exit;
}

if ($result_rating->num_rows === 0) {
    $_SESSION['error'] = "Data rating tidak ditemukan";
    header("Location: rating.php");
    exit;
}

$rating = $result_rating->fetch_assoc();

// Query untuk mendapatkan karyawan dengan rating ini
$sql_karyawan = "SELECT id, nama, tanggal_masuk FROM karyawan WHERE rating_id = $id";
$result_karyawan = $conn->query($sql_karyawan);

// Tangani error query karyawan
if ($result_karyawan === false) {
    $_SESSION['error'] = "Error query karyawan: " . $conn->error;
    header("Location: jabatan.php");
    exit;
}

// Query untuk menghitung total karyawan
$sql_count_karyawan = "SELECT COUNT(*) as total FROM karyawan WHERE rating_id = $id";
$result_count = $conn->query($sql_count_karyawan);
$total_karyawan = $result_count ? $result_count->fetch_assoc()['total'] : 0;

// Query untuk mendapatkan karyawan
$sql_karyawan = "SELECT id, nama, tanggal_masuk FROM karyawan WHERE rating_id = $id";
$result_karyawan = $conn->query($sql_karyawan);

// Tangani error query karyawan
if ($result_karyawan === false) {
    $_SESSION['error'] = "Error query karyawan: " . $conn->error;
    header("Location: jabatan.php");
    exit;
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Rating: <?= htmlspecialchars($rating['nama_rating']) ?></h1>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="row">
    <!-- Informasi Rating -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Informasi Rating</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Nama Rating</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($rating['nama_rating']) ?></dd>
                    
                    <dt class="col-sm-4">Bonus</dt>
                    <dd class="col-sm-8">Rp <?= number_format($rating['bonus'], 0, ',', '.') ?></dd>

                    <dt class="col-sm-4">Bintang</dt>
                    <dd class="col-sm-8"><?=
                    $nilai = (int)$rating['nilai_rating'];
                    for ($i = 1     ; $i <= 5; $i++) {
                        echo ($i <= $nilai) ? '<i class="bi bi-star-fill me-2 text-warning"></i>' : ' ';
                    }
                    ?></dd>

                    <dt class="col-sm-4">Total Karyawan</dt>
                    <dd class="col-sm-8"><?= $total_karyawan ?> orang</dd>
                    
                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <?= $rating['deskripsi'] ? htmlspecialchars($rating['deskripsi']) : '<span class="text-muted">Tidak ada deskripsi</span>' ?>
                    </dd>
                </dl>
                
                <div class="mt-4">
                    <a href="edit_rating.php?id=<?= $id ?>" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Rating
                    </a>
                    <a href="rating.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daftar Karyawan dengan Rating Ini -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5>Karyawan dengan Rating Ini</h5>
            </div>
            <div class="card-body">
                <?php if ($result_karyawan->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($karyawan = $result_karyawan->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <p><?= htmlspecialchars($karyawan['nama']) ?></p>
                                    </td>
                                    <td>
                                        <?php 
                                        if (isset($karyawan['tanggal_masuk']) && !empty($karyawan['tanggal_masuk'])) {
                                            echo date('d M Y', strtotime($karyawan['tanggal_masuk']));
                                        } else {
                                            echo '<span class="text-muted">Belum ada</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="detail_karyawan.php?id=<?= $karyawan['id'] ?>" 
                                           class="btn btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Tidak ada karyawan dengan jabatan ini.
                    </div>
                    <div class="text-center">
                        <a href="tambah_karyawan.php" class="btn btn-secondary">
                            <i class="bi bi-plus-circle"></i> Tambah Karyawan
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>