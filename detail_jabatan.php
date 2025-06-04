<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/header.php';
include 'includes/config.php';

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID jabatan tidak valid";
    header("Location: jabatan.php");
    exit;
}

$id = (int)$_GET['id'];

// Query database untuk mendapatkan data jabatan
$sql_jabatan = "SELECT * FROM jabatan WHERE id = $id";
$result_jabatan = $conn->query($sql_jabatan);

// Tangani error query
if ($result_jabatan === false) {
    $_SESSION['error'] = "Error query: " . $conn->error;
    header("Location: jabatan.php");
    exit;
}

if ($result_jabatan->num_rows === 0) {
    $_SESSION['error'] = "Data jabatan tidak ditemukan";
    header("Location: jabatan.php");
    exit;
}

$jabatan = $result_jabatan->fetch_assoc();

// Pastikan $jabatan tidak null sebelum digunakan
if (!$jabatan) {
    $_SESSION['error'] = "Gagal memproses data jabatan";
    header("Location: jabatan.php");
    exit;
}

// Query untuk menghitung total karyawan
$sql_count_karyawan = "SELECT COUNT(*) as total FROM karyawan WHERE jabatan_id = $id";
$result_count = $conn->query($sql_count_karyawan);
$total_karyawan = $result_count ? $result_count->fetch_assoc()['total'] : 0;

// Query untuk mendapatkan karyawan
$sql_karyawan = "SELECT id, nama, tanggal_masuk FROM karyawan WHERE jabatan_id = $id";
$result_karyawan = $conn->query($sql_karyawan);

// Tangani error query karyawan
if ($result_karyawan === false) {
    $_SESSION['error'] = "Error query karyawan: " . $conn->error;
    header("Location: jabatan.php");
    exit;
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Jabatan: <?= isset($jabatan['nama_jabatan']) ? htmlspecialchars($jabatan['nama_jabatan']) : 'Jabatan Tidak Diketahui' ?></h1>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="row">
    <!-- Informasi Jabatan -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Informasi Jabatan</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Nama Jabatan</dt>
                    <dd class="col-sm-8"><?= isset($jabatan['nama_jabatan']) ? htmlspecialchars($jabatan['nama_jabatan']) : '-' ?></dd>
                    
                    <dt class="col-sm-4">Gaji Pokok</dt>
                    <dd class="col-sm-8"><?= isset($jabatan['gaji_pokok']) ? 'Rp ' . number_format($jabatan['gaji_pokok'], 0, ',', '.') : '-' ?></dd>

                    <dt class="col-sm-4">Total <?= isset($jabatan['nama_jabatan']) ? htmlspecialchars($jabatan['nama_jabatan']) : '-' ?></dt>
                    <dd class="col-sm-8"><?= $total_karyawan ?> orang</dd>
                    
                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">
                        <?= isset($jabatan['deskripsi']) && !empty($jabatan['deskripsi']) ? htmlspecialchars($jabatan['deskripsi']) : '<span class="text-muted">Tidak ada deskripsi</span>' ?>
                    </dd>
                </dl>
                
                <div class="mt-4">
                    <a href="edit_jabatan.php?id=<?= $id ?>" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Jabatan
                    </a>
                    <a href="jabatan.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daftar Karyawan dengan Jabatan Ini -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5>Karyawan dengan Jabatan Ini</h5>
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
                                    <td><?= htmlspecialchars($karyawan['nama']) ?></td>
                                    <td>
                                        <?= !empty($karyawan['tanggal_masuk']) ? date('d M Y', strtotime($karyawan['tanggal_masuk'])) : '<span class="text-muted">Belum ada</span>' ?>
                                    </td>
                                    <td>
                                        <a href="detail_karyawan.php?id=<?= $karyawan['id'] ?>" class="btn btn-sm">
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>