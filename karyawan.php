<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="fw-bold">
        <i class="bi bi-people me-2"></i>Daftar Karyawan
    </h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="tambah_karyawan.php" class="btn btn-secondary">
            <i class="bi bi-plus-circle"></i> Tambah Karyawan
        </a>
    </div>
</div>

<?php if(isset($_GET['sukses'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data karyawan berhasil <?= $_GET['sukses'] ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-lg p-3">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT karyawan.*, jabatan.nama_jabatan 
                        FROM karyawan 
                        JOIN jabatan ON karyawan.jabatan_id = jabatan.id
                        ORDER BY karyawan.id DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='text-center'>{$no}</td>
                                <td class='text-center'><img src='assets/img/{$row['foto']}' width='70' height='100' class='rounded'></td>
                                <td class='text-center'>{$row['nama']}</td>
                                
                                <td class='text-center'>{$row['nama_jabatan']}</td>
                            
                                <td class='text-center'>
                                    <a href='detail_karyawan.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-info-circle'></i> Detail</a>
                                    <a href='edit_karyawan.php?id={$row['id']}' class='btn btn-sm btn-primary'><i class='bi bi-pencil'></i></a>
                                    <a href='proses_karyawan.php?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'><i class='bi bi-trash'></i></a>
                                </td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data karyawan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>