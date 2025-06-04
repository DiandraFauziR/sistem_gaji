<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="fw-bold"><i class="bi bi-star-fill me-2"></i>Daftar Rating Karyawan</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahRating">
            <i class="bi bi-plus-circle"></i> Tambah Rating
        </button>
    </div>
</div>

<?php if(isset($_GET['sukses'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data rating berhasil <?= htmlspecialchars($_GET['sukses']) ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-lg p-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Rating</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM rating ORDER BY id DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($row['nama_rating']) . "</td>
                                <td>";
                        $nilai = (int)$row['nilai_rating'];
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $nilai) ? '<i class="bi bi-star-fill me-2 text-warning"></i>' : '';
                        }

                        echo "</td>
                                <td>
                                    <a href='detail_rating.php?id={$row['id']}' class='btn btn-sm btn-warning'>
                                        <i class='bi bi-info-circle'></i> Detail
                                    </a>
                                    <a href='edit_rating.php?id={$row['id']}' class='btn btn-sm btn-primary'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <a href='proses_rating.php?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <i class='bi bi-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data rating</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahRating" tabindex="-1" aria-labelledby="tambahRatingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahRatingLabel">Tambah Rating</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_rating.php?action=add" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_rating" class="form-label">Nama Rating</label>
                        <input type="text" class="form-control" id="nama_rating" name="nama_rating" required>
                    </div>
                    <div class="mb-3">
                        <label for="nilai_rating" class="form-label">Nilai Rating</label>
                        <input type="number" class="form-control" id="nilai_rating" name="nilai_rating" min="1" max="5">
                    </div>
                    <div class="mb-3">
                        <label for="bonus" class="form-label">Bonus</label>
                        <input type="number" class="form-control" id="bonus" name="bonus" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Rating</label>
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
