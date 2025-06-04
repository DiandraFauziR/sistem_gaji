<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<?php
// Ambil data karyawan berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT karyawan.*, jabatan.nama_jabatan 
        FROM karyawan 
        JOIN jabatan ON karyawan.jabatan_id = jabatan.id
        WHERE karyawan.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Karyawan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="proses_karyawan.php?action=edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="foto_lama" value="<?= $row['foto'] ?>">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="Laki-Laki" <?= ($row['jenis_kelamin'] == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                        <option value="Perempuan" <?= ($row['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $row['telepon'] ?>">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $row['email'] ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= $row['alamat'] ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" 
                        value="<?= isset($row['tanggal_masuk']) ? $row['tanggal_masuk'] : date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="nilai_rating" class="form-label">Rating</label>
                    <select class="form-select" id="nilai_rating" name="nilai_rating" required>
                        <option value="">Pilih Rating</option>
                        <?php
                        $sql_rating = "SELECT * FROM rating";
                        $result_rating = $conn->query($sql_rating);
                        while($rating = $result_rating->fetch_assoc()) {
                            $selected = ($rating['id'] == $row['rating_id']) ? 'selected' : '';
                            echo "<option value='{$rating['id']}' $selected>{$rating['nama_rating']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="jabatan_id" class="form-label">Jabatan</label>
                    <select class="form-select" id="jabatan_id" name="jabatan_id" required>
                        <option value="">Pilih Jabatan</option>
                        <?php
                        $sql_jabatan = "SELECT * FROM jabatan";
                        $result_jabatan = $conn->query($sql_jabatan);
                        while($jabatan = $result_jabatan->fetch_assoc()) {
                            $selected = ($jabatan['id'] == $row['jabatan_id']) ? 'selected' : '';
                            echo "<option value='{$jabatan['id']}' $selected>{$jabatan['nama_jabatan']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                <?php if($row['foto']): ?>
                <div class="mt-2">
                    <img src="../assets/img/<?= $row['foto'] ?>" width="100" class="img-thumbnail">
                </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="karyawan.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>