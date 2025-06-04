<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="fw-bold"><i class="bi bi-cash-coin me-2"></i>Daftar Gaji Karyawan</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#hitungGaji">
            <i class="bi bi-calculator"></i> Hitung Gaji
        </button>
    </div>
</div>

<!-- Notifikasi -->
<?php if(isset($_GET['sukses'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data gaji berhasil <?= htmlspecialchars($_GET['sukses']) ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_GET['error']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Tabel Data Gaji -->
<div class="card shadow-lg p-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT gaji.*, karyawan.nama, jabatan.nama_jabatan 
                        FROM gaji 
                        JOIN karyawan ON gaji.karyawan_id = karyawan.id
                        JOIN jabatan ON karyawan.jabatan_id = jabatan.id
                        ORDER BY gaji.tahun DESC, gaji.bulan DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>".htmlspecialchars($row['nama'])."</td>
                                <td>".htmlspecialchars($row['bulan'])." ".htmlspecialchars($row['tahun'])."</td>
                                <td>
                                    <a href='detail_gaji.php?id={$row['id']}' class='btn btn-sm btn-warning'>
                                        <i class='bi bi-info-circle'></i> Detail
                                    </a>
                                    <a href='edit_gaji.php?action=edit&id={$row['id']}' class='btn btn-sm btn-primary'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <a href='proses_gaji.php?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <i class='bi bi-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data gaji</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hitung Gaji -->
<div class="modal fade" id="hitungGaji" tabindex="-1" aria-labelledby="hitungGajiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hitungGajiLabel">Hitung Gaji Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_gaji.php?action=hitung" method="post" id="formHitungGaji">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Karyawan</label>
                        <select class="form-select" id="karyawan_id" name="karyawan_id" required>
                            <option value="">Pilih Karyawan</option>
                            <?php
                            $sql = "SELECT karyawan.id, karyawan.nama, jabatan.nama_jabatan, jabatan.gaji_pokok 
                                    FROM karyawan 
                                    JOIN jabatan ON karyawan.jabatan_id = jabatan.id";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='".htmlspecialchars($row['id'])."' data-gaji='".htmlspecialchars($row['gaji_pokok'])."'>
                                        ".htmlspecialchars($row['nama'])." (".htmlspecialchars($row['nama_jabatan']).")
                                    </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-select" id="bulan" name="bulan" required>
                                <?php
                                $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                $currentMonth = (int)date('n');
                                foreach($bulan as $index => $b) {
                                    $selected = ($index + 1 == $currentMonth) ? 'selected' : '';
                                    echo "<option value='".htmlspecialchars($b)."' $selected>".htmlspecialchars($b)."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="tahun" name="tahun" 
                                   value="<?= date('Y') ?>" min="2000" max="<?= date('Y')+5 ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="rating_id" class="form-label">Rating Kinerja</label>
                        <select class="form-select" id="rating_id" name="rating_id" required>
                            <option value="">Pilih Rating</option>
                            <?php
                            $sql = "SELECT * FROM rating";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='".htmlspecialchars($row['id'])."' data-bonus='".htmlspecialchars($row['bonus'])."'>
                                        ".htmlspecialchars($row['nama_rating'])." (Bonus: Rp ".number_format($row['bonus'],0,',','.').")
                                    </option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" id="rating_bonus" name="rating_bonus" value="0">
                    </div>
                    
                    <div class="mb-3">
                        <label for="total_gaji" class="form-label">Total Gaji</label>
                        <input type="text" class="form-control fw-bold" id="total_gaji" name="total_gaji" readonly>
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

<!-- JavaScript -->
<script>
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

document.getElementById('karyawan_id').addEventListener('change', function() {
    const gajiPokok = this.options[this.selectedIndex].getAttribute('data-gaji') || 0;
    document.getElementById('gaji_pokok').value = formatRupiah(gajiPokok);
    hitungTotalGaji();
});

document.getElementById('rating_id').addEventListener('change', function() {
    const bonus = this.options[this.selectedIndex].getAttribute('data-bonus') || 0;
    document.getElementById('rating_bonus').value = bonus;
    hitungTotalGaji();
});

document.getElementById('lembur').addEventListener('change', hitungTotalGaji);

function hitungTotalGaji() {
    const karyawanSelect = document.getElementById('karyawan_id');
    const gajiPokok = parseFloat(karyawanSelect.options[karyawanSelect.selectedIndex]?.getAttribute('data-gaji')) || 0;

    const ratingBonus = parseFloat(document.getElementById('rating_bonus').value) || 0;

    const totalGaji = gajiPokok + ratingBonus;
    document.getElementById('total_gaji').value = formatRupiah(totalGaji);
}

document.getElementById('formHitungGaji').addEventListener('submit', function(e) {
    if (!document.getElementById('karyawan_id').value || 
        !document.getElementById('rating_id').value) {
        e.preventDefault();
        alert('Harap lengkapi semua data!');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
