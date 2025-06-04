<?php
    include 'includes/config.php';
    include 'includes/header.php';

    if (!isset($_GET['id'])) {
        echo "<div class='alert alert-danger'>ID gaji tidak ditemukan.</div>";
        include 'includes/footer.php';
        exit;
    }

    $id = (int)$_GET['id'];
    $sql = "SELECT g.*, k.nama, j.nama_jabatan, j.gaji_pokok, 
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

    $data['tarif'] = $data['tarif'] ?? 0;
    $data['bonus_rating'] = $data['bonus_rating'] ?? 0;
    $data['total_gaji'] = $data['total_gaji'] ?? ($data['gaji_pokok'] + $data['bonus_rating']);
    ?>

    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h4">Detail Gaji Karyawan</h2>
    </div>

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
            <th>Periode</th>
            <td><?= htmlspecialchars($data['bulan']) . " " . htmlspecialchars($data['tahun']) ?></td>
        </tr>
        <tr>
            <th>Gaji Pokok</th>
            <td>Rp <?= number_format($data['gaji_pokok'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Bonus Rating</th>
            <td>Rp <?= number_format($data['bonus_rating'], 0, ',', '.') ?></td>
        </tr>
        <tr class="table-success fw-bold">
            <th>Total Gaji</th>
            <td>Rp <?= number_format($data['total_gaji'], 0, ',', '.') ?></td>
        </tr>
    </table>

    <a href="gaji.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>

    <?php include 'includes/footer.php'; ?>
