<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Karyawan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="proses_karyawan.php?action=add" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div> 

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                </div>
                <div class="col-md-3">
                    <label for="nilai_rating" class="form-label">Rating</label>
                    <select class="form-select" id="nilai_rating" name="nilai_rating" required>
                        <option value="">Pilih Rating</option>
                        <?php
                        $sql = "SELECT * FROM rating";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nama_rating']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="jabatan_id" class="form-label">Jabatan</label>
                    <select class="form-select" id="jabatan_id" name="jabatan_id" required>
                        <option value="">Pilih Jabatan</option>
                        <?php
                        $sql = "SELECT * FROM jabatan";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nama_jabatan']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" required>
                </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="karyawan.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>