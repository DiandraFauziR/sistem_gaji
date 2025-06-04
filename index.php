<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>

<div class="alert alert-success text-center">
    <h2 class="alert-heading fw-bold"><i class="bi bi-speedometer2 me-2"></i> Dashboard</h2>
    <marquee>
        <p class="mt-2 fw-semibold">Selamat Datang Di Sistem Manajemen Gaji Karyawan Perusahaan drfzrmdhni.</p>
    </marquee>
</div>

<hr class="my-8 m-4">

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Karyawan Terbaru</h5>
            </div>
            <div class="card-body d-flex flex-wrap">
                <?php
                $sql = "SELECT karyawan.*, jabatan.nama_jabatan 
                        FROM karyawan 
                        JOIN jabatan ON karyawan.jabatan_id = jabatan.id
                        ORDER BY id DESC LIMIT 5";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="card kartu-karyawan shadow-sm">
                            <img src="assets/img/'.($row['foto'] ?: 'default.jpg').'" class="foto-karyawan card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-1">' . $row['nama'] . '</h5>
                                <p class="card-text">' . $row['nama_jabatan'] . '</></p>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>Tidak ada data karyawan</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5>Statistik</h5>
            </div>
            <div class="card-body">
                <?php
                $sql_karyawan = "SELECT COUNT(*) as total FROM karyawan";
                $sql_jabatan = "SELECT COUNT(*) as total FROM jabatan";
                $sql_gaji = "SELECT COUNT(*) as total FROM gaji";
                
                $result = $conn->query($sql_karyawan);
                $row = $result->fetch_assoc();
                $total_karyawan = $row['total'];
                
                $result = $conn->query($sql_jabatan);
                $row = $result->fetch_assoc();
                $total_jabatan = $row['total'];
                
                $result = $conn->query($sql_gaji);
                $row = $result->fetch_assoc();
                $total_gaji = $row['total'];
                ?>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Karyawan
                        <span class="badge bg-primary rounded-pill"><?= $total_karyawan ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Jabatan
                        <span class="badge bg-success rounded-pill"><?= $total_jabatan ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Data Gaji
                        <span class="badge bg-warning rounded-pill"><?= $total_gaji ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>