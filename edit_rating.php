<?php
// Mulai session
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

// Ambil data rating yang akan diedit
$sql = "SELECT * FROM rating WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Data rating tidak ditemukan";
    header("Location: rating.php");
    exit;
}

$rating = $result->fetch_assoc();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit rating: <?= htmlspecialchars($rating['nama_rating']) ?></h1>
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
        <form action="proses_rating.php?action=edit" method="post">
            <input type="hidden" name="id" value="<?= $rating['id'] ?>">
            
            <div class="mb-3">
                <label for="nama_rating" class="form-label">Nama Rating</label>
                <input type="text" class="form-control" id="nama_rating" name="nama_rating" 
                       value="<?= htmlspecialchars($rating['nama_rating']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="bonus" class="form-label">Bonus</label>
                <input type="number" class="form-control" id="bonus" name="bonus" 
                       value="<?= $rating['bonus'] ?>" min="0" step="10000" required>
            </div>
            
            <div class="mb-3">
                <label for="nilai_rating" class="form-label">Nilai</label>
                <input type="number" class="form-control" id="nilai_rating" name="nilai_rating" 
                       value="<?= $rating['nilai_rating'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Rating</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= 
                    htmlspecialchars($rating['deskripsi'] ?? '') 
                ?></textarea>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="rating.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>