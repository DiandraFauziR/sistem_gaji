<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="fw-bold"><i class="bi bi-clock me-2"></i>Daftar Tarif Lembur</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahLembur">
            <i class="bi bi-plus-circle"></i> Tambah Tarif Lembur
        </button>
    </div>  
</div>

<?php if(isset($_GET['sukses'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data lembur berhasil <?= $_GET['sukses'] ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-lg p-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Tarif per Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM lembur ORDER BY id DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['jam_mulai']}</td>
                                <td>{$row['jam_selesai']}</td>
                                <td>Rp " . number_format($row['tarif'], 0, ',', '.') . "</td>
                                <td>
                                    <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editLembur{$row['id']}'>
                                        <i class='bi bi-pencil'></i>
                                    </button>
                                    <a href='proses_lembur.php?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <i class='bi bi-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                        
                        // Modal Edit
                        echo "<div class='modal fade' id='editLembur{$row['id']}' tabindex='-1' aria-labelledby='editLemburLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='editLemburLabel'>Edit Tarif Lembur</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <form action='proses_lembur.php?action=edit' method='post'>
                                            <div class='modal-body'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <div class='mb-3'>
                                                    <label for='jam_mulai' class='form-label'>Jam Mulai</label>
                                                    <input type='time' class='form-control' id='jam_mulai' name='jam_mulai' value='{$row['jam_mulai']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label for='jam_selesai' class='form-label'>Jam Selesai</label>
                                                    <input type='time' class='form-control' id='jam_selesai' name='jam_selesai' value='{$row['jam_selesai']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label for='tarif' class='form-label'>Tarif per Jam</label>
                                                    <input type='number' class='form-control' id='tarif' name='tarif' value='{$row['tarif']}' required>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                                <button type='submit' class='btn btn-primary'>Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data lembur</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahLembur" tabindex="-1" aria-labelledby="tambahLemburLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLemburLabel">Tambah Tarif Lembur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_lembur.php?action=add" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="tarif" class="form-label">Tarif per Jam</label>
                        <input type="number" class="form-control" id="tarif" name="tarif" required>
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