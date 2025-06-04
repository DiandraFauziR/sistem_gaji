<?php
include 'includes/config.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID gaji tidak ditemukan.</div>";
    include 'includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT g.*, k.nama, j.nama_jabatan, j.gaji_pokok, k.id AS karyawan_id,
            r.bonus AS bonus_rating
        FROM gaji g
        JOIN karyawan k ON g.karyawan_id = k.id
        JOIN jabatan j ON k.jabatan_id = j.id
        LEFT JOIN rating r ON k.rating_id = r.id
        WHERE g.id = $id";

$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
    include 'includes/footer.php';
    exit;
}

$data = $result->fetch_assoc();

// Default nilai jika kosong
$tarif = $data['bonus_lembur'] ?? 0;
$bonus = $data['bonus_rating'] ?? 0;
$total_gaji = $data['gaji_pokok'] + $tarif + $bonus;

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $query = "UPDATE gaji SET bulan = '$bulan', tahun = '$tahun', total_gaji = $total_gaji WHERE id = $id";

    if ($conn->query($query)) {
        header("Location: gaji.php?sukses=edit");
        exit;
    }
     else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h4">Edit Gaji Karyawan</h2>
</div>

<form method="POST">
    <table class="table table-bordered">
        <tr>
            <th>Nama Karyawan</th>
            <td><?= htmlspecialchars($data['nama']) ?></td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td><?= htmlspecialchars($data['nama_jabatan']) ?></td>
        </tr>
        <tr>
            <th>Bulan</th>
            <td>
                <select name="bulan" class="form-control" required>
                    <?php
                    $bulan_list = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    foreach ($bulan_list as $b) {
                        $selected = ($data['bulan'] == $b) ? 'selected' : '';
                        echo "<option value='$b' $selected>$b</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Tahun</th>
            <td><input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($data['tahun']) ?>" required></td>
        </tr>
        <tr>
            <th>Gaji Pokok</th>
            <td>Rp <?= number_format($data['gaji_pokok'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Bonus Rating</th>
            <td>Rp <?= number_format($bonus, 0, ',', '.') ?></td>
        </tr>
        <tr class="table-success fw-bold">
            <th>Total Gaji</th>
            <td>Rp <?= number_format($total_gaji, 0, ',', '.') ?></td>
        </tr>
    </table>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Perubahan
    </button>
    <a href="gaji.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</form>

<?php include 'includes/footer.php'; ?>
