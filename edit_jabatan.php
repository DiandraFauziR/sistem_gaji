<?php
// Mulai session
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

// Ambil data jabatan yang akan diedit
$sql = "SELECT * FROM jabatan WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Data jabatan tidak ditemukan";
    header("Location: jabatan.php");
    exit;
}

$jabatan = $result->fetch_assoc();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Jabatan: <?= htmlspecialchars($jabatan['nama_jabatan']) ?></h1>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="proses_jabatan.php?action=edit" method="post">
            <input type="hidden" name="id" value="<?= $jabatan['id'] ?>">
            
            <div class="mb-3">
                <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" 
                       value="<?= htmlspecialchars($jabatan['nama_jabatan']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" 
                       value="<?= $jabatan['gaji_pokok'] ?>" min="0" step="100000" required>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Jabatan</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= 
                    htmlspecialchars($jabatan['deskripsi'] ?? '') 
                ?></textarea>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="jabatan.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>