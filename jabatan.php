<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="fw-bold"><i class="bi bi-person-badge me-2"></i>Daftar Jabatan</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahJabatan">
            <i class="bi bi-plus-circle"></i> Tambah Jabatan
        </button>
    </div>
</div>

<?php if(isset($_GET['sukses'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data jabatan berhasil <?= $_GET['sukses'] ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-lg p-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM jabatan ORDER BY id DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama_jabatan']}</td>
                                <td>Rp " . number_format($row['gaji_pokok'], 0, ',', '.') . "</td>
                                <td>
                                    <a href='detail_jabatan.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-info-circle'></i> Detail</a>
                                    <a href='edit_jabatan.php?id={$row['id']}' class='btn btn-sm btn-primary' >
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <a href='proses_jabatan.php?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <i class='bi bi-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Tidak ada data jabatan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahJabatan" tabindex="-1" aria-labelledby="tambahJabatanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahJabatanLabel">Tambah Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_jabatan.php?action=add" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Jabatan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>